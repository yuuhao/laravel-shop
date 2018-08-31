<?php

namespace App\Services;
use Auth;
use App\Models\CartItem;

class CartService{
    public function get(){
        return Auth::user()->cartItem()->with(['productSku.product'])->get();
    }

    public function add($skuId,$amount){
        $user = Auth::user();
        //从数据库中查询该商品是否已经在购物车中
        if($item = $user->cartItem()->where('product_sku_id',$skuId)->first()){
            $item->update([
                'amount' => $item->amount + $amount,
            ]);
        }else{
            $item = new CartItem(['amount' => $amount]); // 提前填充数据
            $item->user()->associate($user);
            $item->productSku()->associate($skuId);
            $item->save();
        }
    }

    public function remove($skuIds){
        if(!is_array($skuIds)){
            $skuIds = [$skuIds];
        }
       // Auth::user()->carItem()->whereIn('product_sku_id',$skuIds)->delete();
        Auth::user()->cartItem()->first()->destroy($skuIds);
    }
}