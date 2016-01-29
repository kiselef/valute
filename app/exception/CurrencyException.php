<?php

namespace app\exception;

class CurrencyException extends BaseException
{
    const NO_ATTRIBUTE = 0;
    const NO_JSON = 1;

    public static $messages = array(
        self::NO_ATTRIBUTE => 'Не указаны обязательные аттрибуты',
        self::NO_JSON => 'Входящий запрос должен быть в формате JSON',
    );
}