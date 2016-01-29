<?php

namespace app\cache;


class MCache extends Cache
{
    private $host;
    private $port;

    public function create($params)
    {
        $this->host = $params['host'];
        $this->port = $params['port'];
        $this->cache = new \Memcached;
        $this->cache->addServer($params['host'], $params['port']);
        return $this;
    }

    public function set($key, $value, $exp = 0)
    {
        $this->cache->set($key, $value, $exp);
    }

    public function get($key)
    {
        $this->cache->get($key);
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }
}