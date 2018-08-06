<?php

namespace App\Http\Controllers;

use App\Notifications\EmailVerificationNotification;
use Illuminate\Http\Request;
use \Exception;
use Illuminate\Support\Facades\Cache;
use Mail;
use App\Models\User;
use App\Exceptions\InvalidRequestException;

class EmailVerificationController extends Controller
{

    // 邮箱链接验证 。。
    // 1.注册成功时生成一个以邮箱为键，随机字符串为值的键值对，存入缓存中，，
    // 2.链接中带上随机字符，在访问链接时验证是否一致
    public function verify(Request $request){
        $email = $request->input('email');
        $token = $request->input('token');
        // 如果有一个为空说明不是合法链接
        if(!$email || !$token){
            throw new InvalidRequestException('验证链接不正确');
        }
        if($token != Cache::get('email_verification_'.$email)){
            throw new InvalidRequestException('验证链接不正确或已过期');
        }

        if(!$user = User::where('email',$email)->first()){
            throw new InvalidRequestException('用户不存在');
        }

        Cache::forget('email_verification_'.$email);
        $user->update(['email_verified' => true ]);
        return view('pages.success',['msg' => '邮箱验证成功']);
    }
   //   用户手动发送验证请求
    public function send(Request $request){
        $user = $request->user();
        if($user->email_verified){
            throw new InvalidRequestException('你已验证过邮箱');
        }

        $user->notify(new EmailVerificationNotification());
        return view('pages.success', ['msg' => '邮件发送成功']);

    }
}
