<?php

declare (strict_types = 1);

namespace Jackin\Response;

use Jackin\Controller\BaseController;

abstract class BaseResponse
{
    /**
     * @var BaseController $Controller 
     */
    protected $Controller;

    public function setController(BaseController $Controller)
    {
        $this->Controller = $Controller;

        return $this;
    }

    abstract public function finish();
}