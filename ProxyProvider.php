<?php

declare(strict_types=1);

namespace Brooke\Proxy;

use think\App;
use think\Request;
use think\response\Json;
use think\facade\Middleware;
use Brooke\Supports\ServiceProvider;

class ProxyProvider extends ServiceProvider
{
    const MIDDLEWARE_NAME = 'proxy';

    public static function register(App $app, Request $request)
    {
        $proxy = self::getInstance();

        $proxy->loadConfig(env('config_path'). 'proxy.php', 'proxy');

        $proxy->registerApiProxy();
    }

    public function registerApiProxy()
    {
        try{
            $response = new Json(
                app(Proxy::class)->handle()
            );
            
            $response->send();die();
        } catch (\Exception $e){}
    }

}
