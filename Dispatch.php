<?php
declare(strict_types=1);

namespace Brooke\Proxy;

use Brooke\Supports\HasHttpRequest;

class Dispatch
{
    use HasHttpRequest;

    protected $baseUri;

    protected $route;

    protected $request;

    public function __construct(array $route, Request $request)
    {
        $this->route = $route;

        $this->request = $request;
    }

    public function init() : self
    {
        $this->setBaseUri($this->route['target']);

        return $this;
    }

    public function setBaseUri(string $url)
    {
        $this->baseUri = $url;
    }

    public function execute()
    {
        $method = $this->request->method(true);

        $options = [
            'query' => $this->request->get(),
            'headers' => $this->request->header()
        ];

        if(in_array($method, ['post', 'put', 'patch'])){
            $data = $this->request->getOpenInputData();

            if(empty($data)){
                $options['form_params'] = $_POST;
            }else{
                $options['body'] = $this->request->getInput();
            }
        }

        $options = array_filter($options, function($option){
            return !empty($option);
        });

        $response = $this->request($method, $this->buildEndpoint(), $options);

        return $response;
    }

    public function buildEndpoint() : string
    {
        foreach($this->route['pathRewrite'] as $key => $rewrite){
            if(preg_match('/'.str_replace(['\\/', '/'], ['/', '\\/'], $key).'/i', $this->route['path'], $matches)){
                return str_replace(current($matches), $rewrite, $this->route['path']);
            }
        }

        return $this->route['path'];
    }
}
