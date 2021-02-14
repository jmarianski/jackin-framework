<?php

declare(strict_types = 1);

namespace Jackin\Starter;

class Environment 
{
    public const CLI = 'cli';

    public const HTTP = 'http';

    public static function getEnvironmentType(): string
    {
        if (php_sapi_name() === static::CLI)
        {
            return static::CLI;
        }

        return static::HTTP;
    }

    public function getArgs(string $type): array 
    {
        if ($type === static::CLI) {
            return $this->getCliArguments();
        } else {
            return $this->getHttpArguments();
        }
    }

    public function getRoute(string $type): string 
    {
        if ($type === static::CLI) {
            return $this->getCliRoute();
        } else {
            return $this->getHttpRoute();
        }
    }

    protected function getCliRoute(): string
    {
        if (isset($_SERVER['argv'][1])) {
            return $_SERVER['argv'][1];
        }

        return '';
    }

    protected function getHttpRoute(): string
    {
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

        return $$uri_parts[0];
    }

    protected function getCliArguments(): array
    {
        $cli = $_SERVER['argv'];
        array_shift($cli);

        return $cli;
    }

    protected function getHttpArguments(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $args = $_GET;
        } else {
            $args = $_POST;
        }

        return $args;
    }
}