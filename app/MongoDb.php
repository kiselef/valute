<?php

namespace app;

class MongoDb extends DB
{
    public function connect($config)
    {
        $this->name = $config['name'];
        $this->db = new \MongoClient("{$config['connect']}/{$config['name']}");
        return $this;
    }

    public function insert($table, $row)
    {
        $collection = $this->db->selectCollection($this->name, $table);
        return $collection->insert($row);
    }

    public function close()
    {
        $this->db->close();
    }
}