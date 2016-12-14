<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 2:35 PM
 */

namespace Jimmy\fifo\Http\Controller;


use Jimmy\fifo\Domain\Entity\Category;
use Jimmy\fifo\Domain\Entity\User;
use Silex\Application;
use Silex\Controller;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class adminController
 * @package Jimmy\fifo\Http\Controller
 */
class adminController implements ControllerProviderInterface
{
    private $app;

    /**
     * adminController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Application $app
     * @return Controller
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/home', [$this, 'adminHomeAction'])->bind('homeAdmin');

        $controllers->get('/error',[$this, 'errorAction']);

        $controllers->get('/category/', [$this, 'categoryAction'])->bind('category');

        $controllers->get('/category/list', [$this, 'categoryListAction'])->bind('category_list');

        $controllers->match('/category/create', [$this, 'categoryCreateAction'])->bind('category_create');

        $controllers->match('/masuk-admin', [$this, 'adminLoginAction'])->bind('loginAdmin');

        return $controllers;
    }

    public function categoryAction()
    {
        return $this->app->redirect($this->app['url_generator']->generate('category_list'));
    }

    public function categoryListAction()
    {
        $data = $this->app['category.repository']->findAll();
        return $this->app['twig']->render('Admin/categories/list.twig', ['data' => $data]);
    }

    public function categoryCreateAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $info = Category::create($request->get('name'));

            $this->app['orm.em']->persist($info);
            $this->app['orm.em']->flush();

            $this->app['session']->getFlashBag()->add('message_success', 'Category has been successfully added to the database');

            return $this->app->redirect($this->app['url_generator']->generate('category_list'));

        }
        return $this->app['twig']->render('Admin/categories/create.twig');
    }

    public function errorAction()
    {
        return $this->app['twig']->render('Admin/404.twig');
    }

    public function adminHomeAction()
    {
        if ($this->app['session']->get('email') == null) {
            return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
        }
        return $this->app['twig']->render('Admin/index.twig');
        
    }

    public function adminLoginAction(Request $request)
    {
        $username = $request->get('username');
        $password = md5($request->get('password'));
        $data = $this->app['user.repository']->findByEmail($username);
        $userList = $this->app['user.repository']->findAll();

        if ($this->app['session']->get('name') != null) {
            return $this->app->redirect($this->app['url_generator']->generate('homeAdmin'));
        }

        if ($request->getMethod() == 'POST' ) {
            if ($data != null ) {
                if ($data->getPassword() == $password) {
                    $this->app['session']->set('name', ['value' => $data->getFirstName() . ' ' . $data->getLastName()]);
                    $this->app['session']->set('user-count', ['value' => count($userList)]);

                    return $this->app->redirect($this->app['url_generator']->generate('homeAdmin'));
                } else {
                    $this->app['session']->getFlashBag()->add('message_error', 'Password Incorrect');
                    return $this->app->redirect($this->app['url_generator']->generate('loginAdmin'));
                }
            } else {
                $this->app['session']->getFlashBag()->add('message_error', 'Username not Found');
                return $this->app->redirect($this->app['url_generator']->generate('loginAdmin'));
            }
        }

        return $this->app['twig']->render('Admin/login.twig');
    }

}