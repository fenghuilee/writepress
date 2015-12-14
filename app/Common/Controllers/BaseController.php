<?php

namespace App\Common\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class BaseController extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        
    }

    public function redirect($location = null)
    {
        return $this->response->redirect($location, false, 301);
    }
}
