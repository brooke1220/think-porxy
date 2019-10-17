<?php
declare(strict_types=1);

namespace Brooke\Proxy;

class Route
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function routeCheck()
    {
        $path = $this->request->path();

        foreach ($this->getRoutes() as $key => $route) {
            if(strpos($path, $key) !== false){
                $route['path'] = $path;
                return $route;
            }
        }

        return null;
    }

    public function getRoutes()
    {
        return config('proxy.');
    }
}
