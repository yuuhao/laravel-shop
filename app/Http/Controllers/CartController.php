<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Services\CartService;
use Auth;
class CartController extends Controller
{
    protected $carService;
    public function __construct( CartService $cartService)
    {
        $this->carService = $cartService;
    }

    public function index(Request $request){
        $cartItems = $this->carService->get();   ///  productSku.product 多层预加载，此处预加载了和sku有关的商品
        $addresses = $request->user()->addresses()->orderBy('last_used_at','desc')->get();
        return view('cart.index', ['cartItems' => $cartItems,'addresses' => $addresses]);
    }


    //
    ////新增购物车商品sku
    public function add(AddCartRequest $request){
        $user = Auth::user();
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');
        $this->carService->add($skuId,$amount);
    }
    // 移除购物车上商品
    public function remove(ProductSku $sku, Request $request){
        $request->user()->cartItem()->where('product_sku_id', $sku->id)->delete();
        return [];
    }

}
