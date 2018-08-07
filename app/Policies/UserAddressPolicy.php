<?php

namespace App\Policies;

use App\Models\UserAddress;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function own(User $user, UserAddress $address){
        // 当own返回true时代表当前登录用户可以修改对应的地址
        return $address->user_id = $user->id;
    }
}
