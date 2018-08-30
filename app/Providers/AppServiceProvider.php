<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Pay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //往服务容器中注入一个名alipay的单例对象
        $this->app->singleton('alipay',function(){
            $config = config('pay.alipay');
            if(app()->environment() !== 'production'){
                $config['mode']   = 'dev';
                $config['log']['level'] = Logger::DEBUG;
            }else{
                $config['log']['level'] = Logger::WARNING;
            }

            return Pay::alipay($config);
        });
        $this->app->singleton('wechat_pay',function(){
            $config = config('pay.alipay');
            if(app()->environment() !== 'production'){
                $config['mode']   = 'dev';
                $config['log']['level'] = Logger::DEBUG;
            }else{
                $config['log']['level'] = Logger::WARNING;
            }
            return Pay::wechat($config);
        });

    }
}
