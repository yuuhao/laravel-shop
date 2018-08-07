<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
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

            $content->header('Index');
            $content->description('description');

            $content->body($this->grid());
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->email('邮箱');
            $grid->email_verified('已验证过邮箱')->display(function ($value){
                return $value ? '是' : '否';
            });
            $grid->created_at('注册时间');
            $grid->disableCreateButton(); // 不显示新增按钮
            $grid->actions(function ($actions){
                $actions->disableDelete();
                $actions->disableEdit();
            });
            // 禁用批量删除按钮
            $grid->tools(function ($tools){
                $tools->batch(function ($batch){
                    $batch->disableDelete();
                });
            });
        });
    }

}
