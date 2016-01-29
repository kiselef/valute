<?php

namespace app\response;

class ResponseFactory
{
    public static function create($dataType)
    {
        $responseClass = "app\\response\\{$dataType}Response";
        if (class_exists($responseClass)) {
            return new $responseClass();
        } else {
            throw new \Exception("Ошибка типа ответа");
        }
    }
}