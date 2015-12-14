<?php

class BlogApp extends \Phalcon\Mvc\Application
{

    protected function _registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->register();
    }

    /**
     * This methods registers the services to be used by the application
     */
    protected function _registerServices()
    {
        $di = new \Phalcon\DI\FactoryDefault();

        // Registering a Config shared-service
        $di->setShared('config', function() {
            $config['main']     = include(ROOT_DIR . "/config/main.php");
            $config['db']       = include(ROOT_DIR . "/config/db.php");
            $config['router']   = include(ROOT_DIR . "/config/router.php");
            return new \Phalcon\Config($config);
        });

        $config = $di->get('config');

        // Change FactoryDefault default Router service
        $di->getService('router')
            ->setDefinition(function () use ($config) {
                $router = new \Phalcon\Mvc\Router();
                //Setup routes from /config/router.php
                foreach ($config->router->toArray() as $key=>$value) {
                    $router->add($key, $value);
                };
                // Mount each module routers
                $router->mount(new \App\Frontend\Router);
                $router->mount(new \App\Backend\Router);
                // URI_SOURCE_SERVER_REQUEST_URI
                $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
                // Remove trailing slashes automatically
                $router->removeExtraSlashes(true);
                // Setting a specific default using an array
                // DefaultModule
                // DefaultNamespace
                // DefaultController
                // DefaultAction
                $router->setDefaults(
                    array(
                        'modul'      => 'frontend',
                        'namespace'  => 'App\Frontend\Controllers\\',
                        'controller' => 'index',
                        'action'     => 'index'
                    )
                );
                // Set 404 paths
                $router->notFound([
                    "controller" => "error",
                    "action"     => "error404",
                ]);
                return $router;
            });

        // Registering a View shared-service
        $di->setShared('view', function() {
            return new \Phalcon\Mvc\View();
        });

        // Registering a Mysql shared-service
        $di->setShared('mysql', function() use ($config) {
            return new \Phalcon\Db\Adapter\Pdo\Mysql($config->db->mysql->toArray());
        });

        // Registering a Db shared-service
        $di->setShared('db', function() use ($di) {
            return $di->get('mysql');
        });

        // Registering a Url shared-service
        $di->setShared('url', function () {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/');
            return $url;
        });

        // Start the Session service
        $di->get('session')->start();

        // Setup the Crypt service
        $di->get('crypt')
            ->setMode(MCRYPT_MODE_CFB)
            ->setKey($config->main->crypt_key);

        // Setup the Security service
        $di->get('security')->setWorkFactor(12);

        // Registering a custom authentication shared-service
        $di->setShared('auth', function () {
            return new \App\Common\Libs\Auth();
        });

        $this->setDI($di);
    }

    public function run()
    {
        $this->_registerServices();
        $this->_registerAutoloaders();

        // Register the installed modules
        $this->registerModules([
            'frontend' => [
                'className' => 'App\Frontend\Module',
                'path'      => ROOT_DIR . '/app/Frontend/Module.php',
            ],
            'backend'  => [
                'className' => 'App\Backend\Module',
                'path'      => ROOT_DIR . '/app/Backend/Module.php',
            ],
        ]);

        // Handle the request
        echo $this->handle()->getContent();
    }
}
