<?php
declare(strict_types=1);

namespace Brooke\Proxy;

class Proxy
{
    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function handle()
    {
        $dispatch = $this->routeCheck()->init();

        $response = $dispatch->execute();

        return $response;
    }

    public function routeCheck() : Dispatch
    {
        $route = $this->route->routeCheck();

        if(! $route){
            throw new \Exception("路由不存在");
        }

        $dispatch = app()->invokeClass(Dispatch::class, [ $route ]);

        return $dispatch;
    }
}
