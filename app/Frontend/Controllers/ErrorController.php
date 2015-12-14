<?php

namespace App\Frontend\Controllers;

use App\Common\Controllers\BaseController;

class ErrorController extends BaseController
{

    public function error404Action()
    {
        $this->response->setStatusCode(404, "Not Found");
        $html = '<title>Not Found</title>';
        $this->response->setContent($html);
        $this->response->send();
    }
}
