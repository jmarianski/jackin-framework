<?php

declare(strict_types = 1);

namespace Jackin\Controller;

use Jackin\Response\BaseResponse;
use Jackin\Response\ConsoleResponse;
use Jackin\Starter\Environment;

abstract class BaseConsoleController extends BaseController 
{
    public static function getType(): string
    {
        return Environment::CLI;
    }

    public function getResponse(): BaseResponse
    {
        return new ConsoleResponse;
    }

    abstract static function getRoute(): string;

    abstract function run();
}