<?php

declare (strict_types = 1);

namespace Jackin\Tools;

class ArrayTools
{
    public static function hasStringKeys(array $array): bool
    {
        return !empty(array_filter(array_keys($array), 'is_string'));
    }
}