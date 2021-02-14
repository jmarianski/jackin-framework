<?php

declare(strict_types = 1);

namespace Jackin\Starter;

use Jackin\Controller\BaseController;
use Jackin\Tools\FileTools;
use Jackin\Config\DirectoryConfig;

class Router 
{
    private const REGENERATE_CACHE = 60 * 60 * 24 * 30;

    public function getBestRoute(string $type, string $inputRoute): ?string
    {
        $routes = $this->getAvailableRoutes($type);
        foreach ($routes as $className => $route) {
            if (strpos($inputRoute, $route) === 0) {
                return $className;
            }
        }

        return null;
    }

    protected function getAvailableRoutes(string $type): array
    {
        $cached = $this->getRouteCache($type);
        if (is_array($cached)) {
            return $cached;
        }

        $routes = $this->getRoutesFromClassStructures();
        if (isset($routes[$type])) {
            $this->saveRouteCache($type, $routes[$type]);

            return $routes[$type];
        }

        return [];
    }

    protected function getRouteCache(string $type): ?array
    {
        $cacheRoute = DirectoryConfig::getCacheDirectory($type);

        if (!file_exists($cacheRoute) || filemtime($cacheRoute) < time() - self::REGENERATE_CACHE) {
            return null;
        }

        $routeString = file_get_contents($cacheRoute);
        $routeLines = explode(PHP_EOL, $routeString);
        $routes = [];
        foreach ($routeLines as $line) {
            $lineResults = mb_split(':', $line, 2);
            if (count($lineResults) === 2) {
                $routes[$lineResults[0]] = $lineResults[1];
            }
        }

        return $routes;
    }

    protected function saveRouteCache(string $type, array $data) 
    {
        $lines = [];
        foreach ($data as $className => $route) {
            $lines[] = sprintf('%s:%s', $className, $route);
        }
        $textToSave = join(PHP_EOL, $lines);

        file_put_contents(DirectoryConfig::getCacheDirectory($type), $textToSave);

        return $this;
    }

    protected function getRoutesFromClassStructures(): array
    {
        $allFiles = FileTools::getDirContents(DirectoryConfig::getBaseDirectory());
        $routes = [];
        foreach ($allFiles as $fileName) {
            $className = FileTools::getClassName($fileName);
            if (is_string($className) && is_subclass_of($className, BaseController::class, true)) {
                $type = $className::getType();
                $route = $className::getRoute();
                $routes[$type][$className] = $route;
            }
        }

        return $routes;
    }

}