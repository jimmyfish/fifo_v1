<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/15/16
 * Time: 7:19 PM
 */

namespace Jimmy\fifo\Http\Controller;

use Jimmy\fifo\Domain\Entity\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\SwiftmailerServiceProvider;
use Symfony\Component\HttpFoundation\Session\Session;

class clientController implements ControllerProviderInterface
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'homeClientAction'])->bind('homeClient');
        $controllers->get('/about', [$this, 'aboutClientAction'])->bind('aboutClient');
        $controllers->get('/daftar-barang', [$this, 'barangClientAction'])->bind('barangClient');
        $controllers->get('/detail-barang', [$this, 'detailClientAction'])->bind('detailClient');
        $controllers->get('/faq', [$this, 'faqClientAction'])->bind('faqClient');
        $controllers->match('/login', [$this, 'loginClientAction'])->bind('loginClient');
        $controllers->match('/client-registration', [$this, 'registrationClientAction'])->bind('client_registration');
        $controllers->match('/upload', [$this, 'uploadClientAction'])->bind('uploadClient');
        $controllers->get('/success-step-one/{email}', [$this, 'successStepOneAction'])->bind('success_step_one');
        $controllers->get('/activation/{token}', [$this, 'clientActivationAction'])->bind('client_activation');
        $controllers->match('/edit/', [$this, 'clientEditAction'])->bind('edit_client');
        $controllers->get('/resend-activation', [$this, 'resendAction'])->bind('resend_activation');
        $controllers->get('/profil', [$this, 'clientProfileAction'])->bind('profil_client');


        return $controllers;
    }

    public function homeClientAction()
    {
        return $this->app['twig']->render('Client/index.twig');
    }

    public function aboutClientAction()
    {
        return $this->app['twig']->render('Client/about.twig');
    }

    public function barangClientAction()
    {
        return $this->app['twig']->render('Client/barang.twig');
    }

    public function detailClientAction()
    {
        return $this->app['twig']->render('Client/detail.twig');
    }

    public function faqClientAction()
    {
        return $this->app['twig']->render('Client/faq.twig');
    }

    public function loginClientAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $email = $request->get('email');
            $pass = md5($request->get('password'));
            $data = $this->app['user.repository']->findByEmail($email);
            $userList = $this->app['user.repository']->findAll();

            if ($data != null) {
                if ($pass == $data->getPassword()) {
                    $this->app['session']->set('name', ['value' => $data->getFirstName() . ' ' . $data->getLastName()]);
                    $this->app['session']->set('email', ['value' => $data->getEmail()]);
                    $this->app['session']->set('user-count', ['value' => count($userList)]);
                    return $this->app->redirect($this->app['url_generator']->generate('homeClient'));
                } else {

                    $this->app['session']->getFlashBag()->add('message_error','Password tidak cocok');
                    /**
                     * Put Statement if password not match
                     */
                }
            } else {
                $this->app['session']->getFlashBag()->add('message_error','Email tidak ditemukan');
                /**
                 * Put Statement if data with email given did not match with any data
                 */
            }
        }

        return $this->app['twig']->render('Client/login.twig');
    }

    public function uploadClientAction(Request $request)
    {
        $session = $this->app['session'];
        $data = $this->app['user.repository']->findByEmail($session->get('email')['value']);
        if ($session->get('name') != null) {

            return $this->app['twig']->render('Client/upload.twig', ['data' => $data]);
        } else {
            return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
        }
    }

    public function registrationClientAction(Request $request)
    {
        $firstName = $request->get('first-name');
        $lastName = $request->get('last-name');
        $password = $request->get('password');
        $email = $request->get('email');

        $info = User::createUser($email, $password, $firstName, $lastName);

        $this->app['orm.em']->persist($info);
        $this->app['orm.em']->flush();

        $data = $this->app['user.repository']->findByEmail($email);
        $secretToken = $data->getSecretToken();

        $transport = \Swift_SmtpTransport::newInstance
        ('smtp.gmail.com', 587, 'tls')
            ->setUsername('killcoder212@gmail.com')
            ->setPassword('getmarried');

        $message = \Swift_Message::newInstance();
        $message->setSubject('Activation Required');
        $message->setFrom(['send@example.com']);
        $message->setTo([$email]);
        $message->setBody(
            $this->app['twig']->render(
                'Client/mess_temp.twig',
                [
                    'token' => $secretToken,
                    'host' => $request->getHost(),
                    'name' => $firstName
                ]
            ),
            'text/html'
        );

        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);

        return 'Registrasi Sukses';
    }

    public function clientActivationAction(Request $request)
    {
        $data = $this->app['user.repository']->findByToken($request->get('token'));

        if ($data != null) {
            if ($data->getValidateState() != 1) {
                $data->setValidateState(1);
                $this->app['orm.em']->flush();

                return 'Account Validate';
            } else {
                return 'Account Allready Validated';
            }
        } else {
            return 'Data Not Available';
        }
    }

    public function clientEditAction(Request $request)
    {
        $data = $this->app['user.repository']->findByEmail($this->app['session']->get('email')['value']);

        if ($request->getMethod() == 'POST') {
            $fileName = md5(uniqid()) . '.' . $request->files->get('profile-image')->guessExtension();
            $data->setFirstName($request->get('first-name'));
            $data->setLastName($request->get('last-name'));
            $data->setPhone($request->get('phone'));
            $data->setFbLink($request->get('fb-link'));
            $data->setPinBBM($request->get('pin-bbm'));
            $data->setAddress($request->get('address'));
            $this->app['session']->set('name', ['value' => $data->getFirstName() . ' ' . $data->getLastName()]);
            $data->setPicture($fileName);

            $request->files->get('profile-image')->move($this->app['foto.path'] . '/', $fileName);

            $this->app['orm.em']->flush();
            return $this->app->redirect($this->app['url_generator']->generate('profil_client'));
        }

        return $this->app['twig']->render('Client/edit.twig', ['data' => $data]);
    }

    public function resendAction()
    {
        $session = $this->app['session'];
        $data = $this->app['user.repository']->findByEmail($session->get('email')['value']);
        $transport = \Swift_SmtpTransport::newInstance
        ('smtp.gmail.com', 587, 'tls')
            ->setUsername('killcoder212@gmail.com')
            ->setPassword('getmarried');

        $message = \Swift_Message::newInstance();
        $message->setSubject('Activation Required');
        $message->setFrom(['send@example.com']);
        $message->setTo([$session->get('email')['value']]);
        $message->setBody(
            $this->app['twig']->render(
                'Client/mess_temp.twig',
                [
                    'token' => $data->getSecretToken(),
                    'host' => $this->app['request']->getHost(),
                    'name' => $data->getFirstName()
                ]
            ),
            'text/html'
        );

        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);

        return $this->app->redirect($this->app['url_generator']->generate('edit_client'));
    }

    public function clientProfileAction()
    {
        $data = $this->app['user.repository']->findByEmail($this->app['session']->get('email')['value']);

        return $this->app['twig']->render('Client/profil.twig', ['data' => $data]);
    }
}