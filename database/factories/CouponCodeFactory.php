<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CouponCode::class, function (Faker $faker) {
    //生成书记
    $type = $faker->randomElement(array_keys(App\Models\CouponCode::$typeMap));
    $value = $type === App\Models\CouponCode::TYPE_FIXED ? random_int(1,200) : random_int(1,50);

    //如果是固定金额，则最低售价要比优惠金额高0.01元
    if($type === App\Models\CouponCode::TYPE_FIXED){
        $minamout = $value + 0.01;
    }else{
        if(random_int(0,100) < 50){
            $minamout = 0;
        }else{
            $minamout = random_int(100,1000);
        }
    }

    return [
        'name'      => join(',',$faker->words),
        'code'      => App\Models\CouponCode::findAvailableCode(),
        'type'      => $type,
        'value'     => $value,
        'total'     => 1000,
        'used'      => 0,
        'min_amount'=> $minamout,
        'not_before'=> null,
        'not_after' => null,
        'enabled'   => true
    ];
});
