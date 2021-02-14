<?php

declare(strict_types = 1);

namespace Jackin\Starter;

use Jackin\Starter\Router;
use Jackin\Controller\BaseController;

class Starter 
{
    /**
     * @var Router $Router
     */
    protected $Router;

    /**
     * @var Environment $Environment
     */
    protected $Environment;

    public function __construct(Router $Router, Environment $Environment)
    {
        $this->Router = $Router;
        $this->Environment = $Environment;
    }

    public function run()
    {
        $type = $this->Environment->getEnvironmentType();
        $args = $this->Environment->getArgs($type);
        $route = $this->Environment->getRoute($type);
        $className = $this->Router->getBestRoute($type, $route);
        if (is_string($className)) {
            /** @var BaseController $Controller */
            $Controller = new $className;
            $Controller->setParams($args);
            $Controller->run();
            $Response = $Controller->getResponse();
            $Response->setController($Controller);
            $Response->finish();
        } else {
            die ('no route found');
        }
    }
}