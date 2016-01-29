<?php

namespace app\models;

class CurrencyLog extends Model
{
    public $request;
    public $time;
    public $duration;
    public $ip;
    public $client;

    public function getTable()
    {
        return 'logs';
    }

    public function create($request)
    {
        $this->request = $request->getRawData();
        $this->ip = $request->getIP();
        $this->client = $request->getClient();
        $this->time = new \MongoDate($request->getStartTime());
        $this->duration = microtime(true) - $request->getStartTime();
        $this->save();
    }
}