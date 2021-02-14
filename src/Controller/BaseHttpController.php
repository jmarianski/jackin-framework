<?php

declare(strict_types = 1);

namespace Jackin\Controller;

use Jackin\Response\BaseResponse;
use Jackin\Response\HttpPageReponse;
use Jackin\Starter\Environment;

abstract class BaseHttpController extends BaseController 
{
    abstract static function getRoute(): string;

    static function getType(): string
    {
        return Environment::HTTP;
    }

    public function getResponse(): BaseResponse
    {
        return new HttpPageReponse;
    }

    abstract function run();
}