<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/15/16
 * Time: 7:39 PM
 */

namespace Jimmy\fifo\Http\Controller;


use Jimmy\fifo\Domain\Entity\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController implements ControllerProviderInterface
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->match('/create', [$this, 'userCreateAction'])->bind('userCreate');
        $controllers->get('/createRaw', [$this, 'userCreateRawAction']);
        $controllers->get('/list', [$this, 'userListAction'])->bind('user_list');

        return $controllers;
    }

    public function userCreateAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {


            $this->app['session']->getFlashBag()->add(
                'message_success',
                'User berhasil ditambahkan'
            );

            return $this->app->redirect($this->app['url_generator']->generate('userCreate'));

        }
        return $this->app['twig']->render('Admin/users/create.twig');
    }

    public function userCreateRawAction()
    {
        $info = User::createUser('jack@komaltechno.com','faster','Jack', 'Laksono');

        $this->app['orm.em']->persist($info);
        $this->app['orm.em']->flush();

        return 'OK';
    }

    public function userListAction()
    {
        $qb = $this->app['orm.em']->createQueryBuilder();
        $qb->select('u')->from('Jimmy\fifo\Domain\Entity\User', 'u')->where('u.isDelete != 1');

        return $this->app['twig']->render('Admin/users/list.twig', ['userList' => $qb->getQuery()->getResult()]);
    }

}