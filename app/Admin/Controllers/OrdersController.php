<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;

class OrdersController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('订单列表');

            $content->body($this->grid());
        });
    }

    /**
     * Show interface.
     *
     * @param $id
     * @return Content
     */
    public function show(Order $order)
    {
        return Admin::content(function (Content $content) use ($order) {

            $content->header('查看订单');

            $content->body(view('admin.orders.show',['order'=>$order]));
        });
    }

    public function ship(Order $order,Request $request){
        //判断订单是否支付
        if(!$order->paid_at){
            throw new InvalidRequestException('订单未支付');
        }

        if(!$order->ship_status){
            throw new InvalidRequestException('订单已发货');
        }

        $data = $this->validate($request, [
            'express_company' => ['required'],
            'express_no'      => ['required'],
        ], [], [
            'express_company' => '物流公司',
            'express_no'      => '物流单号',
        ]);

        $order->update([
            'ship_status' => Order::SHIP_STATUS_DELIVERED,
            'ship_data'   => $data
        ]);

        return redirect()->back();

    }



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->model()->whereNotNull('paid_at')->orderBy('paid_at','desc');
            $grid->no('订单流水号');
            //展示关联字段用column方法
            $grid->column('user.name','买家');
            $grid->total_amount('总金额')->sortable();
            $grid->paid_at('支付时间')->sortable();
            $grid->ship_status('物流')->display(function($value){
                return Order::$shipStatusMap[$value];
            });
            $grid->refund_status('退款状态')->display(function ($value){
                return Order::$refundStatusMap[$value];
            });
            $grid->disableCreateButton();
            $grid->actions(function($actions){
                $actions->disableDelete();
                $actions->disableEdit();
            });
            $grid->tools(function($tools){
                $tools->batch(function($batch){
                    $batch->disableDelete();
                });
            });
        });
    }

}
