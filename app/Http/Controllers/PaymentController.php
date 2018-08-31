<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Exceptions\InvalidRequestException;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
class PaymentController extends Controller
{
    public function payByAlipay(Order $order,Request $request){
        //判断订单是否属于当前用户
        // 为什么要判断，，查看订单，同一个表，
        $this->authorize('own',$order);
        if($order->paid_at || $order->closed){
            throw new InvalidRequestException('订单状态不正确');
        }

        // 调用支付宝网页支付
        return app('alipay')->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount,
            'subject'      => '支付 Laravel Shop 的订单'.$order->no,
        ]);

        //
    }
    public function alipayReturn(){
        try{
            $data = app('alipay')->verify(); // 单列
        } catch (\Exception $e){
            return view('pages.error',['msg' => '数据不正确']);
        }
        return view('pages.success',['msg'=>'付款成功']);
    }

    public function alipayNotify(){
        $data = app('alipay')->verify();
        $order = Order::where('no',$data->out_trade_no)->first();
        if(!$order){
            return 'fail';
        }
        $this->afterPaid($order);
        if($order->paid_at){
            return app('alipay')->success();
        }
        $order->update([
            'paid_at'   =>Carbon::now(),
            'payment_method' => 'alipay',
            'payment_no' =>$data->trade_no
        ]);

    }

    public function afterPaid($order){
        event(new OrderPaid($order));
    }


}
