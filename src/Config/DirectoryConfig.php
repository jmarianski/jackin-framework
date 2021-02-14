<?php

declare(strict_types = 1);

namespace Jackin\Config;

class DirectoryConfig
{
    protected static $basePath;

    public static function setBaseDirectory(string $path) {
        static::$basePath = $path;
    }

    public static function getBaseDirectory(): string
    {
        return static::$basePath;
    }

    public static function getCacheDirectory(string $fileName): string
    {
        $baseDir = static::getBaseDirectory();
        if (!is_dir(sprintf('%s/cache', $baseDir))) {
            mkdir(sprintf('%s/cache', $baseDir));
        }

        return sprintf('%s/cache/%s', $baseDir, $fileName);
    }
}