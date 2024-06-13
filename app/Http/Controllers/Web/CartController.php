<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function add($id){
        $product = Product::findOrFail($id);
        Cart::add([
            'id' => $id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price_per_qty,
            'weight' => 0,
            'options' => [
                'image' => $product->image,
            ],
        ]);

        return back();
    }

    public function index(){
        $carts = Cart::content();
        $total = number_format((float)str_replace(',', '', Cart::total()), 0, '.', ',');
        $subtotal = number_format((float)str_replace(',', '', Cart::subtotal()), 0, '.', ',');
        return view('front.shop.cart', compact('carts','total','subtotal'));
    }
    public function delete($rowId){
        Cart::remove($rowId);
        return back();
    }
    public function destroy(){
        Cart::destroy();
        return back();
    }
    public function update(Request $request){
        if($request->ajax()){
            Cart::update($request->rowId, $request->qty);
        }
    }
}
