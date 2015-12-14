<?php

namespace App\Frontend;

class Router extends \Phalcon\Mvc\Router\Group
{
    public function initialize()
    {
        //Default paths
        $this->setPaths([
            'module' => 'frontend',
            'namespace' => 'App\Frontend\Controllers\\'
        ]);

        //All the routes start with /
        $prefix = '/';
        $this->setPrefix($prefix);

        $this->add('', [
            'controller' => 'index',
            'action' => 'index'
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
