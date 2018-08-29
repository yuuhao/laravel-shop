<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ProductSku;


class OrderRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 判断用户提交的id 是否存在数据库中，
            // 后面的判断很重要，防止恶意用户重复提交算出所有用户的收获地址
            'address_id' => ['required', Rule::exists('user_addresses','id')->where('user_id',$this->user()->id)],
            'items' => ['required', 'array'],
            'items.*.sku_id' => [
                'required',
                function($attribute,$value,$fail){
                    if(!$sku = ProductSku::find($value)){
                        $fail('该商品不存在');
                        return ;
                    }
                    if(!$sku->product->on_sale){
                        $fail('该商品为上架');
                        return ;
                    }
                    if($sku->stock === 0){
                        $fail('该商品已售完');
                        return ;
                    }

                    preg_match('/items\.(\d+)\.sku_id/', $attribute, $m);
                    $index  = $m[1];

                    $amount = $this->input('items')[$index]['amount'];
                    if ($amount > 0 && $amount > $sku->stock) {
                        $fail('该商品库存不足');
                        return;
                    }
                }
            ],
            'items.*.amount' => ['required' ,'integer','min:1']
         ];
    }

    public function messages()
    {
        return [
            'items.required' => '请选择商品',
            'items.*.amount.required' => '请填写数量',
            'items.*.amount.integer' => '商品数量为整数',
        ];
    }
}
