<?php

declare (strict_types = 1);

namespace Jackin\Tools;

class FileTools
{
    public static function getDirContents($dir, &$results = []): array 
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                static::getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

    public static function getClassName(string $fileName): ?string
    {
        if (preg_match('/\.php$/', $fileName)) {
            $contents = file_get_contents($fileName);
            if (preg_match('/namespace (.*);[\s\S]*?(?<!abstract )class *([^ {]+)/', $contents, $matches)) {
                $className = $matches[1] . '\\' . $matches[2];
                if (class_exists($className)) {
                    return $className;
                }
            }
        }

        return null;
    }
}