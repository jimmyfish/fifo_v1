<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 8:10 AM
 */

/**
 * Register Doctrine Service Provider
 */
$app->register(new \Silex\Provider\DoctrineServiceProvider(), $config['db']);

/**
 * Register Doctrine ORM Service Provider
 */
$app->register(new \Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), $config['orm']);

$app->register(new \Silex\Provider\SwiftmailerServiceProvider());

/**
 * Register Twig Service Provider
 */
$app->register(new \Silex\Provider\TwigServiceProvider(), $config['twig']);

/**
 * Register Monolog Service Provider
 */
$app->register(new \Silex\Provider\MonologServiceProvider());

/**
 * Register Form Service Provider
 */
$app->register(new \Silex\Provider\FormServiceProvider());

/**
 * Register Translation Service Provider
 */
$app->register(new \Silex\Provider\TranslationServiceProvider());

/**
 * Register Session Service Provider
 */
$app->register(new \Silex\Provider\SessionServiceProvider());

/**
 * Register Url Generator Service Provider
 */
$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

/**
 * Register Controller Service Provider
 */
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

/**
 * Register Http Fragment Service Provider
 */
$app->register(new \Silex\Provider\HttpFragmentServiceProvider());

/**
 * Register Validator Service Provider
 */
$app->register(new \Silex\Provider\ValidatorServiceProvider());

/**
 * Register Web Profiler Service Provider
 */
if ($app['debug']) {
    Symfony\Component\Debug\Debug::enable(E_ALL, true);
    $app->register(new \Silex\Provider\WebProfilerServiceProvider(), $config['profiler']);
}

$app['user.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Jimmy\fifo\Domain\Entity\User::class);
};

$app['swiftmailer.use_spool'] = false;