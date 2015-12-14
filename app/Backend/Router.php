<?php

namespace App\Backend;

class Router extends \Phalcon\Mvc\Router\Group
{
    public function initialize()
    {
        //Default paths
        $this->setPaths([
            'module' => 'backend',
            'namespace' => 'App\Backend\Controllers\\'
        ]);

        //All the routes start with /dashboard
        $prefix = '/dashboard';
        $this->setPrefix($prefix);

        $this->add('', [
            'controller' => 'dashboard',
            'action' => 'index',
        ]);

        $this->add('/:controller/:params', [
            'controller' => 1,
            'action'     => 'index',
            'params'     => 2,
        ]);

        $this->add('/:controller/:action/:params', [
            'controller' => 1,
            'action'     => 2,
            'params'     => 3,
        ]);
	}
}
