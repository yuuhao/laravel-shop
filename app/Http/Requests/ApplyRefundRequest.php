<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyRefundRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason' => 'required'
        ];
    }

    public function attributes(){ // 返回相应时
        return [
            'reason' => '原因'
        ];
    }
}
