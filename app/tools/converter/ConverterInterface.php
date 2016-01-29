<?php

namespace app\tools\converter;

interface ConverterInterface
{
    public function get();
    public function validate();
    public function required();
}