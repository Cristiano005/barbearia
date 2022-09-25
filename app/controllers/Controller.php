<?php

namespace app\controllers;

use app\models\Delete;
use app\models\Insert;
use app\models\Select;
use app\models\Update;

abstract class Controller {

    protected Insert $insert;
    protected Select $select;
    protected Update $update;
    protected Delete $delete;
    
    public function __construct()
    {
        $this->insert = new Insert;
        $this->select = new Select;
        $this->update = new Update;
        $this->delete = new Delete;
    }
}