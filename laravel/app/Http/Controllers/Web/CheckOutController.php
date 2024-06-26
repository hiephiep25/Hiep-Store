<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OnlineOrder;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use App\Utils\VNPay;
use Carbon\Carbon;

class CheckOutController extends Controller
{
    public function index()
    {
        $carts = Cart::content();
        $total = number_format((float)str_replace(',', '', Cart::total()), 0, '.', ',');
        $subtotal = number_format((float)str_replace(',', '', Cart::subtotal()), 0, '.', ',');

        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }
    public function addOrder(Request $request)
    {
        $total = number_format((float)str_replace(',', '', Cart::total()), 0, '.', ',');
        $subtotal = number_format((float)str_replace(',', '', Cart::subtotal()), 0, '.', ',');

        $discount = null;
        $discountProducts = collect();

        if ($request->has('discount')) {
            $discount = Discount::where('code', $request->discount)->where(function ($query) {
                $query->where('end', '>', Carbon::now())
                    ->where('start', '<=', Carbon::now());
            })->first();
            if ($discount) {
                $discountProducts = DiscountProduct::where('discount_id', $discount->id)->get();
            }
        }

        $order = new Order();
        $order->type = Order::ONLINE;
        $order->status = Order::COMPLETE;
        $order->total = 0;
        $order->save();

        $orderTotal = 0;
        $carts = Cart::content();
        foreach ($carts as $cart) {
            $product = Product::where('id', $cart->id)->firstOrFail();
            $productPrice = $product->price_per_qty * $cart->qty;

            if ($discount && $discountProducts->contains('product_id', $cart->id)) {
                $discountProduct = $discountProducts->where('product_id', $cart->id)->first();
                if ($discountProduct && $discountProduct->qty >= $cart->qty) {
                    $discountValue = $discountProduct->value;
                    $discountAmount = ($productPrice * $discountValue) / 100;
                    $productPrice -= $discountAmount;
                    $discountProduct->qty -= $cart->qty;
                    $discountProduct->save();
                }
            }

            $orderTotal += $productPrice;

            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'product_code' => $product->code,
                'qty' => $cart->qty
            ]);

            $product->qty -= $cart->qty;
            $product->save();
        }

        $order->total = intval($orderTotal);
        $order->save();

        OnlineOrder::create([
            'order_id' => $order->id,
            'user_id' => $request->user_id,
            'payment_type' => $request->payment_type,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address
        ]);

        $customer = Customer::where('user_id', $request->user_id)->firstOrFail();
        $customer->number_of_order += 1;

        if ($request->payment_type == OnlineOrder::ONLINE_PAYMENT) {
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id,
                'vnp_OrderInfo' => 'Thanh toán đơn hàng',
                'vnp_Amount' => $orderTotal,
            ]);
            return redirect()->to($data_url);
        }

        if ($request->payment_type == OnlineOrder::PAY_LATER) {
            $req = [
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_type' => OnlineOrder::PAY_LATER,
            ];
            $this->sendMail($order, $carts, $orderTotal, $orderTotal, $req);
            Cart::destroy();
            return redirect('checkout/result')->with('notification', 'Thàng công, bạn sẽ thanh toán sau khi nhận được hàng, vui lòng kiểm tra email.');
        }
    }


    public function vnPayCheck(Request $request)
    {

        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');
        $vnp_Amount = $request->get('vnp_Amount');
        $order = Order::find($vnp_TxnRef);
        $carts = Cart::content();
        $total = $order->total;
        $subtotal = $order->total;
        $onlineOrder = $order->onlineOrder()->first();
        $user = $onlineOrder->user()->first();
        $req = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $onlineOrder->customer_phone,
            'address' => $onlineOrder->customer_address,
            'payment_type' => OnlineOrder::ONLINE_PAYMENT,
        ];

        if ($vnp_ResponseCode != null) {
            if ($vnp_ResponseCode == 00) {
                $this->sendMail($order, $carts, $total, $subtotal, $req);
                Cart::destroy();
                return redirect('checkout/result')->with('notification', 'Cảm ơn bạn đã mua hàng');
            } else {
                $carts = Cart::content();
                foreach ($carts as $cart) {
                    $product = Product::where('id', $cart->id)->firstOrFail();
                    $product->qty += $cart->qty;
                    $product->save();
                }
                $customer = Customer::where('user_id', $user->id)->firstOrFail();
                OrderProduct::where('order_id', $vnp_TxnRef)->delete();
                OnlineOrder::where('order_id', $vnp_TxnRef)->delete();
                Order::find($vnp_TxnRef)->delete();
                $customer->number_of_order -= 1;

                return redirect('checkout/result')->with('notification', 'Có lỗi, đơn hàng đã bị hủy');
            }
        }
    }

    public function result()
    {
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));
    }

    public function sendMail($order, $carts, $total, $subtotal, $request)
    {
        Mail::send('Mails.send_mail_checkout', compact('order', 'carts', 'total', 'subtotal', 'request'), function ($message) use ($request) {
            $message->from('hello@example.com');
            $message->to($request['email']);
            $message->subject('Thông báo mua hàng');
        });
    }
}
