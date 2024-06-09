<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OnlineOrder;
use App\Models\OrderProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

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
        $order = new Order();
        $order->type = Order::ONLINE;
        $order->total = $total;
        $order->save();

        OnlineOrder::create([
            'order_id' => $order->id,
            'user_id' => $request->user_id,
        ]);

        $carts = Cart::content();
        foreach ($carts as $cart) {
            $product = Product::where('id', $cart->id)->firstOrFail();
            $code = $product->code;
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'product_code' => $code,
                'qty' => $cart->qty
            ]);
            $product->qty -= $cart->qty;
            $product->save();
        }
        $this->sendMail($order, $carts, $total, $subtotal, $request);
        Cart::destroy();
        return redirect('checkout/result')->with('notification', 'Cảm ơn bạn đã mua hàng');
    }
    public function result()
    {
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));
    }

    public function sendMail($order, $carts, $total, $subtotal, $request)
    {
        Mail::send('Mails.send_mail_checkout', compact('order', 'carts', 'total', 'subtotal', 'request'), function($message) use ($request) {
            $message->from('hello@example.com');
            $message->to($request->email, $request->email);
            $message->subject('Thông báo mua hàng');
        });
    }
}
