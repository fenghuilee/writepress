<?php

namespace App\Backend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
    }

    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices(DiInterface $di)
    {
        // Setup the Dispatcher service
        $di->get('dispatcher')
            ->setDefaultNamespace("App\Backend\Controllers\\");

        // Registering a Smarty shared-service
        $di->setShared('smarty', function() use ($di) {
            $smarty = new \Smarty();
            $options = [
                'left_delimiter' => '<{',
                'right_delimiter' => '}>',
                'template_dir'      => ROOT_DIR . '/app/Backend/Views',
                'compile_dir'       => ROOT_DIR . '/runtime/Smarty/compile',
                'cache_dir'         => ROOT_DIR . '/runtime/Smarty/cache',
                'error_reporting'   => error_reporting() ^ E_NOTICE,
                'escape_html'       => true,
                'force_compile'     => false,
                'compile_check'     => true,
                'caching'           => false,
                'debugging'         => true,
            ];
            foreach ($options as $k => $v) {
                $smarty->$k = $v;
            };
            $BaseUri = './';
            $smarty->assign('BaseUri',$BaseUri);
            return $smarty;
        });

        // Registering a Html shared-service
        $di->setShared('html', function() use ($di) {
            $smarty = $di->get('smarty');
            $router = $di->get('router');
            $controller = $router->getControllerName();
            $action = $router->getActionName();
            return $smarty->display(implode('/', [$controller,$action]).'.html');
        });
    }
}
