<?php

namespace app\response;

class JsonResponse extends Response
{
    public function set($response)
    {
        $content = is_array($response) ? $response : (array) $response;
        $this->content = json_encode($content);
    }

    public function setError($message)
    {
        $content = array(
            'error' => array(
                'message' => $message
            )
        );

        $this->content = json_encode($content);
    }

    public function send()
    {
        header('Content-Type: application/json');
        echo $this->get();
    }
}