<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 8:10 AM
 */

$loader = require __DIR__ . '/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$config = require __DIR__ . '/../app/config.php';

$app = new \Silex\Application($config['common']);

require 'bootstrap.php';

$footerData = $app['footer.repository']->findAll();
if ($footerData != null) {
    $app['twig']->addGlobal('Footer', $footerData);
} else {
    \Jimmy\fifo\Domain\Entity\Footer::init();
    $app['twig']->addGlobal('Footer', $footerData);
}

$app->mount('/', new \Jimmy\fifo\Http\Controller\clientController($app));
$app->mount('/admin', new \Jimmy\fifo\Http\Controller\adminController($app));
$app->mount('/admin/user', new \Jimmy\fifo\Http\Controller\UserController($app));

$app->get('/logout', function () use ($app) {
    $app['session']->clear();
    return $app->redirect($app['url_generator']->generate('homeClient'));
})->bind('logout');

$app->run();