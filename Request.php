<?php
declare(strict_types=1);

namespace Brooke\Proxy;

use Brooke\Supports\Arr;
use think\Request as ThinkRequest;

class Request extends ThinkRequest
{
    public function header($name = '', $default = null)
    {
        return Arr::only(parent::header(), [ 'x-token', 'sx-token', 'user-agent', 'content-type']);
    }

    public function getOpenInputData()
    {
        return $this->getInputData($this->input);
    }
}
