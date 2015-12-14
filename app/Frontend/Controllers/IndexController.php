<?php

namespace App\Frontend\Controllers;

use App\Common\Controllers\BaseController;

class IndexController extends BaseController
{
    public function indexAction()
    {
        print_r($this);
        //$this->smarty->display('index.html');
    }
}
