<?php

declare(strict_types = 1);

namespace Jackin\Controller;

use Jackin\Response\BaseResponse;
use Jackin\Tools\ArrayTools;

abstract class BaseController 
{
    public const STRING = 'string';

    public const INT = 'int';

    public const FLOAT = 'float';

    public const ARRAY = 'array';

    protected $params = [];

    protected $data = [];

    private $paramsData = [];

    abstract static function getRoute(): string;

    abstract static function getType(): string;

    abstract function run();

    abstract function getResponse(): BaseResponse;

    public function setParams(array $params)
    {
        $hasStringKeys = ArrayTools::hasStringKeys($params);
        if ($hasStringKeys) {
            foreach ($this->params as $paramName => $type) {
                    $this->paramsData[$paramName] = $this->filterVariable($type, $params[$paramName] ?? null);
            }
        } else {
            $keys = array_keys($this->params);
            foreach ($params as $index => $param) {
                if (!isset($keys[$index])) {
                    break;
                }
                $this->paramsData[$keys[$index]] = $this->filterVariable($this->params[$keys[$index]], $param);
            }
        }

        return $this;
    }

    public function getParams(array $params)
    {
        return $this->paramsData;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($key, $value = null)
    {
        if (is_null($value)) {
            $this->data = $key;
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    protected function filterVariable(string $type, $value)
    {
        switch ($type) {
            case static::STRING:
                if (is_array($value)) {
                    $value = '';
                }

                return (string) $value;
            case static::INT:
                if (!is_numeric($value)) {
                    $value = 0.0;
                }

                return (int) $value;
            case static::FLOAT:
                if (!is_numeric($value)) {
                    $value = 0.0;
                }
                
                return (float) $value;
            case static::ARRAY:
                if (!is_array($value)) {
                    $value = [];
                }

                return $value;
        }
    }
}