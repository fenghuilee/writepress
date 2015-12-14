<?php
namespace App\Frontend;

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
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("App\Frontend\Controllers\\");
            return $dispatcher;
        });

        //Registering a dispatcher
        /*$di->set('dispatcher', function(){
            //Create an EventsManager
            $eventsManager = new EventsManager();
            //Attach a listener
            $eventsManager->attach("dispatch", function($event, $dispatcher, $exception) {
                //Handle controller or action doesn't exist
                if ($event->getType() == 'beforeException') {
                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward([
                                'controller' => 'error',
                                'action'     => 'index',
                                'params'     => ['message' => $exception->getMessage()],
                            ]);
                            return false;
                    }
                }
            });

            $dispatcher = new MvcDispatcher();
            //$dispatcher->setDefaultNamespace('App\Controllers\\');
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        });*/

        // Registering a smarty component
        $di->set('smarty', function(){
            $smarty = new \Smarty();
            $options = [
                'left_delimiter' => '<{',
                'right_delimiter' => '}>',
                'template_dir'      => ROOT_DIR . '/app/Frontend/Views',
                'compile_dir'       => ROOT_DIR . '/runtime/Smarty/compile',
                'cache_dir'         => ROOT_DIR . '/runtime/Smarty/cache',
                'error_reporting'   => error_reporting() ^ E_NOTICE,
                'escape_html'       => true,
                'force_compile'     => false,
                'compile_check'     => true,
                'caching'           => false,
                'debugging'         => false,
            ];
            foreach ($options as $k => $v) {
                $smarty->$k = $v;
            };
            $config = include(ROOT_DIR . "/config/main.php");
            if (!empty($config['theme']))
                $smarty->addTemplateDir(ROOT_DIR . '/app/Frontend/Themes/' . $config['theme']);
            return $smarty;
        });
    }

}