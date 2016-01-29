<?php

namespace app\request;

class RequestFactory
{
    public static function create($dataType)
    {
        $requestClass = "app\\request\\{$dataType}Request";
        if (class_exists($requestClass)) {
            return new $requestClass();
        } else {
            throw new \Exception("Ошибка типа запроса");
        }
    }
}