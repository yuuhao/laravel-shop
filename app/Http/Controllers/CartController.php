<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
class CartController extends Controller
{

    public function index(Request $request){
        $cartItems = $request->user()->cartItem()->with(['productSku.product'])->get();   ///  productSku.product 多层预加载，此处预加载了和sku有关的商品
        return view('cart.index', ['cartItems' => $cartItems]);
    }


    //
    ////新增购物车商品sku
    public function add(AddCartRequest $request){
        $user = $request->user();
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');
        if($cart = $user->cartItem()->where('product_sku_id',$skuId)->first()){

            //如果存在，直接叠加商品数量
            $cart->update([
                'amount' => $amount + $cart->amount,
            ]);
        }else{
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
    }
    // 移除购物车上商品
    public function remove(ProductSku $sku, Request $request){
        $request->user()->cartItem()->where('product_sku_id', $sku->id)->delete();
        return [];
    }

}
