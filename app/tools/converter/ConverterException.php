<?php

namespace app\tools\converter;


class ConverterException extends \Exception
{
    const NO_ATTRIBUTE = 0;
    const NO_CURRENCY = 1;

    public static $messages = array(
        self::NO_ATTRIBUTE => 'Не указаны обязательные аттрибуты',
        self::NO_CURRENCY => 'Нет текущей валюты',
    );
}