<?php

declare(strict_types = 1);

namespace Jackin\Test;

use Jackin\Controller\BaseConsoleController;
use Jackin\Tools\Cli;

class TestController extends BaseConsoleController 
{
    protected $params = ['abc'];

    public static function getRoute(): string
    {
        return 'test';
    }

    public function run()
    {
        $Cli = new Cli();
        $karta = $Cli->getInput('Podaj kartę');
        echo 'Czy to twoja karta? ';

        $this->setData($karta);
    }
}