<?php

namespace App\Common\Models;

use Phalbee\Base\Model;

class BaseModel extends Model
{
    public function initialize()
    {
        $db = $this->getDI()->get('db')->getDescriptor();
        if (array_key_exists('prefix', $db))
            $this->setSource($db['prefix'].strtolower(substr(strrchr(get_class($this), "\\"), 1)));
        else
            $this->setSource(strtolower(substr(strrchr(get_class($this), "\\"), 1)));
    }
}
