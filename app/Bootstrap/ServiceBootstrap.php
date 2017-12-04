<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午5:38
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\BootStrap;

use App\Component\BootstrapInterface;
use App\Component\Core\App;
use App\Component\Http\ErrorHelper;
use App\Constants\Services;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Simple as View;


class ServiceBootstrap implements BootstrapInterface
{

    public function run(App $app, FactoryDefault $di, Config $config)
    {
        /**
         * @description Config - \Phalcon\Config
         */
        $di->setShared(Services::CONFIG, $config);
        /**
         * @description Phalcon - EventsManager
         */
        $di->setShared(Services::EVENTS_MANAGER, new Manager());

        $di->setShared(Services::ERROR_HELPER, new ErrorHelper());
        /**
         * @description Phalcon - \Phalcon\Db\Adapter\Pdo\Mysql
         */
        $di->set(Services::DB, function () use ($config, $di) {

            $config = $config->get('database')->toArray();
            $adapter = $config['adapter'];
            unset($config['adapter']);
            $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;
            /** @var  $connection  Mysql*/
            $connection = new $class($config);

            $connection->setEventsManager($di->get(Services::EVENTS_MANAGER));

            return $connection;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\Url
         */
        $di->set(Services::URL, function () use ($config) {

            $url = new UrlResolver;
            $url->setBaseUri($config->get('application')->baseUri);
            return $url;
        });

        /**
         * @description Phalcon - \Phalcon\Mvc\View\Simple
         */
        $di->set(Services::VIEW, function () use ($config) {
            $view = new View();
            $view->setViewsDir($config->get('application')->viewsDir);
            return $view;
        });

    }

}