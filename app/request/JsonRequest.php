<?php

namespace app\request;

use app\exception\CurrencyException;

class JsonRequest extends Request
{
    private $time;
    private $rawData;
    private $jsonRawData;

    public function __construct()
    {
        $this->time = microtime(true);
    }

    public function get($name)
    {
        $data = $this->getJsonRawData();
        return array_key_exists($name, $data) ? $data[$name] : null;
    }

    public function getRawData()
    {
        if (empty($this->rawData)) {
            $this->rawData = file_get_contents("php://input");
        }
        return $this->rawData;
    }

    public function getJsonRawData()
    {
        if (empty($this->jsonRawData)) {
            $this->jsonRawData = json_decode($this->getRawData(), true);
            if ($this->jsonRawData === null) {
                throw new CurrencyException(CurrencyException::$messages[CurrencyException::NO_JSON]);
            }
        }
        return $this->jsonRawData;
    }

    public function getStartTime()
    {
        return $this->time;
    }
}