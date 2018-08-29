<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Models\Order;
use Carbon\Carbon;
use App\Jobs\CloseOrder;
class OrdersController extends Controller
{


    public function index(Order $order, Request $request){
        $orders = $order->query()
            ->with(['items.product','items.productSku'])
            ->where('user_id',$request->user()->id)
            ->orderBy('created_at','desc')
            ->paginate();
        return view('orders.index',compact('orders'));
    }

    public function store(OrderRequest $request){
        $user = $request->user();

        //开启一个数据库事务
        $order = \DB::transaction(function () use ($user,$request){
            $address = UserAddress::query()->find($request->input('address_id'));
            // 更新此地址的最后使用时间
            $address->update(['last_used_at' => Carbon::now()]);

            $order = new Order([
                'address' => [
                    'address' => $address->full_address,
                    'zip'     => $address->zip,
                    'contact_name' => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'remark'   => $request->input('remark'),
                'total_amount' => 0,
            ]);

            $order->user()->associate($user); // 订单关联到当前用户

            $order->save(); // 写入数据库

            $totalAmount = 0;
            $items = $request->input('items');

            foreach ($items as $data){
                $sku = ProductSku::find($data['sku_id']);

                //创建一个orderItem直接与当前订单关联
                $item  = $order->items()->make([
                    'amount' => $data['amount'],
                    'price'  => $sku->price
                ]);

                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                $totalAmount += $sku->price*$data['amount'];
                if($sku->decreaseStock($data['amount']) <= 0 ){
                    throw new InvalidRequestException('该商品库存不足');
                }

            }
            //更新订单总金额
            $order->update(['total_amount' => $totalAmount]);
            //将下单的商品从购物车中移除

            $skuIds = collect($request->input('items'))->pluck('sku_id');
            $user->cartItem()->whereIn('product_sku_id',$skuIds)->delete();
            $this->dispatch(new CloseOrder($order,config('app.order_ttl')));
            return $order;
        });
        return $order;
    }


}
