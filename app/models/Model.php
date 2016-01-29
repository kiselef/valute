<?php

namespace app\models;

use app\App;

abstract class Model
{
    public function save()
    {
        $db = App::core()->db;
        return $db->insert($this->getTable(), (array) $this);
    }

    abstract public function getTable();
}