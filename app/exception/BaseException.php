<?php

namespace app\exception;

class BaseException extends \Exception
{
    public function getErrorInfo()
    {
        return array(
            'error' => array(
                'message' => $this->getMessage()
            )
        );
    }
}