<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index(Request $request){
        $builder  = Product::query()->where('on_sale',true);

        if($search = $request->input('search','')){
            $like = '%'.$search.'%';
            $builder->where(function ($query) use ($like){

                $query->where('title','like',$like)
                      ->orWhere('description','like',$like)
                      ->orWhereHas('skus',function ($query) use ($like){

                          $query->where('title', 'like', $like)
                                ->orWhere('description', 'like', $like);
                      });
            });
        }

        if($order = $request->input('order','')){
            // 是否是以_asc 或者 _desc 结尾
            if(preg_match('/^(.+)_(asc|desc)$/',$order,$m)){
                if(in_array($m[1],['price','sold_count','rating']))
                    $builder->orderBy($m[1],$m[2]);
            }
        }
        $products = $builder->paginate(16);

        return view('products.index', ['products' => $products,
            'filters' => [
                'search'=> $search,
                'order'=>$order
            ]]);
    }

    public function show(Product $product , Request $request){

        $favor = false;

        // 判断是否已经上架，没有就抛出异常
        if(!$product->on_sale){
            throw new InvalidRequestException('商品未上架');
        }
        //没登陆也是可以看到这，登陆后怎么判断是否收藏呢
        if($user = $request->user()){
            $favor = boolval($user->favoriteProducts()->find($product->id));
        }

        return view('products.show',['product' => $product,'favor'=>$favor]);
    }

    public function favor(Product $product, Request $request){
        $user = $request->user();
        if($user->favoriteProducts()->find($product->id)){
            return [];
        }

        $user->favoriteProducts()->attach($product);
    }

    public function disfavor(Product $product, Request $request){
        $user = $request->user();
        $user->favoriteProducts()->detach($product);

        return [];
    }

    public function favorites(Request $request){
        $products = $request->user()->favoriteProducts()->paginate(16);
        return view('products.favorites',['products' => $products]);
    }
}
