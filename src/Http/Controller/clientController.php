<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/15/16
 * Time: 7:19 PM
 */

namespace Jimmy\fifo\Http\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Jimmy\fifo\Domain\Entity\Barang;
use Jimmy\fifo\Domain\Entity\Comentar;
use Jimmy\fifo\Domain\Entity\Photo;
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
        $controllers->match('/', [$this, 'homeClientAction'])
            ->bind('homeClient');

        $controllers->get('/about', [$this, 'aboutClientAction'])
            ->bind('aboutClient');

        $controllers->get('/daftar-barang-ditemukan', [$this, 'barangDitemukanClientAction'])
            ->bind('barangDitemukanClient');

        $controllers->get('/daftar-barang-dicari', [$this, 'barangDicariClientAction'])
            ->bind('barangDicariClient');

        $controllers->match('/detail-barang/{id}', [$this, 'detailClientAction'])
            ->bind('detailClient');

        $controllers->get('/faq', [$this, 'faqClientAction'])
            ->bind('faqClient');

        $controllers->get('/video', [$this, 'videoClientAction'])
            ->bind('videoClient');

        $controllers->match('/login', [$this, 'loginClientAction'])
            ->before([$this, 'NoNeedData'])
            ->bind('loginClient');

        $controllers->match('/success', [$this, 'successClientAction'])
            ->bind('successClient');

        $controllers->match('/client-registration', [$this, 'registrationClientAction'])
            ->bind('client_registration');

        $controllers->match('/upload', [$this, 'uploadClientAction'])
            ->bind('uploadClient');

        $controllers->get('/success-step-one/{email}', [$this, 'successStepOneAction'])
            ->bind('success_step_one');

        $controllers->get('/activation/{token}', [$this, 'clientActivationAction'])
            ->bind('client_activation');

        $controllers->match('/edit/', [$this, 'clientEditAction'])
            ->before([$this, 'NeedData'])
            ->bind('edit_client');

        $controllers->get('/resend-activation', [$this, 'resendAction'])
            ->bind('resend_activation');

        $controllers->get('/profil', [$this, 'clientProfileAction'])
            ->before([$this, 'NeedData'])
            ->bind('profil_client');

        $controllers->match('/forget-password',[$this, 'clientForgetAction'])
            ->bind('client_forget');

        $controllers->match('/reset/{token}', [$this, 'clientResetAction'])
            ->bind('reset_client');

        $controllers->match('/setting-password', [$this, 'clientSettingPasswordAction'])
            ->bind('setting_password');

        $controllers->post('/daftar-barang/filter', [$this, 'clientListBarangWithFilterAction'])->bind('client_list_barang_filter');

        $controllers->get('/login-check', [$this, 'loginCheckAuthorization'])->bind('login_check');

        return $controllers;
    }

    public function NeedData()
    {
        $session = $this->app['session'];
        if ($session->get('email') == null) {
            return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
        }
    }

    public function NoNeedData()
    {
        $session = $this->app['session'];
        if ($session->get('email') != null) {
            return $this->app->redirect($this->app['url_generator']->generate('profil_client'));
        }
    }

    public function clientListBarangWithFilterAction(Request $request)
    {
        $arrPhoto = [];
        $cat = $this->app['category.repository']->findAll();
        if ($request->get('search_param') != 0 ) {
            $barang = $this->app['orm.em']->getRepository('Jimmy\fifo\Domain\Entity\Barang')
                ->createQueryBuilder('o')
                ->where('o.description LIKE :querysatu OR o.title LIKE :querysatu')
                ->andWhere('o.categoryId = :querydua')
                ->setParameter('querysatu', '%'. $request->get('search-keyword') .'%')
                ->setParameter('querydua', $request->get('search_param'))
                ->getQuery()
                ->getResult();
        } else {
            $barang = $this->app['orm.em']->getRepository('Jimmy\fifo\Domain\Entity\Barang')
                ->createQueryBuilder('o')
                ->where('o.description LIKE :querysatu OR o.title LIKE :querysatu')
                ->setParameter('querysatu', '%'. $request->get('search-keyword') .'%')
                ->getQuery()
                ->getResult();
        }

        foreach ($barang as $modify) {
            $info = $this->app['photo.repository']->findOneBy(['idBarang' => $modify->getId()]);
            array_push($arrPhoto, $info);
        }
        return $this->app['twig']->render('Client/barang.twig', ['barang' => $barang, 'cat' => $cat, 'photo' => $arrPhoto]);
    }

    public function homeClientAction()
    {
        $arrPhoto = [];
        $barang = $this->app['orm.em']->getRepository('Jimmy\fifo\Domain\Entity\Barang')
            ->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();
        foreach ($barang as $modify) {
            $info = $this->app['photo.repository']->findOneBy(['idBarang' => $modify->getId()]);
            array_push($arrPhoto, $info);
        }

        $cat = $this->app['category.repository']->findAll();
        return $this->app['twig']->render('Client/index.twig', ['cat' => $cat, 'barang' => $barang, 'photo' => $arrPhoto]);
    }

    public function aboutClientAction()
    {
        return $this->app['twig']->render('Client/about.twig');
    }

    public function barangDitemukanClientAction()
    {
        $arrPhoto = [];
        $barang = $this->app['barang.repository']->findbyType(0);
        $cat = $this->app['category.repository']->findAll();
        foreach ($barang as $modify) {
            $info = $this->app['photo.repository']->findOneBy(['idBarang' => $modify->getId()]);
            array_push($arrPhoto, $info);
        }
        return $this->app['twig']->render('Client/barang.twig', ['barang' => $barang, 'photo' => $arrPhoto, 'cat' => $cat]);
    }
    
    public function barangDicariClientAction()
    {
        $arrPhoto = [];
        $barang = $this->app['barang.repository']->findbyType(1);
        $cat = $this->app['category.repository']->findAll();
        foreach ($barang as $modify) {
            $info = $this->app['photo.repository']->findOneBy(['idBarang' => $modify->getId()]);
            array_push($arrPhoto, $info);
        }
        return $this->app['twig']->render('Client/barang.twig', ['barang' => $barang, 'photo' => $arrPhoto, 'cat' => $cat]);
    }


    public function detailClientAction(Request $request)
    {
        $cat = $this->app['category.repository']->findAll();
        $barang = $this->app['barang.repository']->findById($request->get('id'));
        $comment = $this->app['comentar.repository']->findByIdBarang($request->get('id'));
        $uid = [];
        foreach($comment as $item) {
            $arr = $this->app['user.repository']->findById($item->getIdUser())->getFirstName() . ' ' . $this->app['user.repository']->findById($item->getIdUser())->getLastName();
            array_push($uid, $arr);
            $item->setIdUser($arr);
        }

        $photo = $this->app['photo.repository']->findByIdBarang($request->get('id'));

        if ($request->getMethod() == 'POST') {
            $idBarang = $request->get('id');
            $idUser = $this->app['user.repository']->findByEmail($this->app['session']->get('email'))->getId();

            $comm = new Comentar();
            $comm->setIdBarang($idBarang);
            $comm->setIdUser($idUser);
            $comm->setContent($request->get('content'));
            $comm->setCreatedAt(new \DateTime());

            $this->app['orm.em']->persist($comm);
            $this->app['orm.em']->flush();

            return $this->app->redirect($request->headers->get('referer'));
        }

        return $this->app['twig']->render('Client/detail.twig',['cat' => $cat, 'barang' => $barang, 'photo' => $photo, 'comment' => $comment]);
    }

    public function faqClientAction()
    {
        return $this->app['twig']->render('Client/faq.twig');
    }

    public function videoClientAction(){
        return $this->app['twig']->render('Client/video.twig');
    }

    public function successClientAction()
    {
        return $this->app['twig']->render('Client/success.twig');
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
                    $this->app['session']->set('role', ['value' => $data->getRole()]);
                    $this->app['session']->set('email', ['value' => $data->getEmail()]);
                    $this->app['session']->set('profile_picture', ['value' => $data->getPicture()]);
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
        $cat = $this->app['category.repository']->findAll();
        $data = $this->app['user.repository']->findByEmail($session->get('email')['value']);
        if ($session->get('name') != null) {

            if ($request->getMethod() == 'POST') {
                $files = new ArrayCollection();
                $info = Barang::create($request->get('first-name') . ' ' . $request->get('last-name'),$request->get('phone'),$request->get('email'),$request->get('address'),$request->get('description'),$request->get('title'), $request->get('category'), $request->get('type'));

                if ($request->get('facebook') != "") {
                    $info->setFounderFacebook($request->get('facebook'));
                }
                if ($request->get('bbm') != "") {
                    $info->setFounderPin($request->get('bbm'));
                }
                $this->app['orm.em']->persist($info);
                $this->app['orm.em']->flush();
                $dirName = $this->app['foto.path'] . '/barang/' . $info->getId();
                mkdir($dirName, 0755);

                foreach($request->files->get('images') as $img) {
                    $fileName = md5(uniqid()) . '.' . $img->guessExtension();
                    $files->add(Photo::create($info->getId(), $fileName));
                    $img->move($dirName, $fileName);
                }

                for ($i = 0;$i < count($files);$i++) {
                    $this->app['orm.em']->persist($files[$i]);
                    $this->app['orm.em']->flush();
                }

                return $this->app['twig']->render('Client/succes-upload.twig');
            }

            return $this->app['twig']->render('Client/upload.twig', ['data' => $data, 'cat' => $cat]);
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
            ->setPassword('Faster123');

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

        return $this->app->redirect($request->headers->get('referer'));
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
            return 'Token tidak valid, silahkan periksa kembali link yang anda terima.';
        }
    }

    public function clientEditAction(Request $request)
    {
        $data = $this->app['user.repository']->findByEmail($this->app['session']->get('email')['value']);
        $fileDummy = '';

        if ($request->getMethod() == 'POST') {

            $data->setFirstName($request->get('first-name'));
            $data->setLastName($request->get('last-name'));
            $data->setPhone($request->get('phone'));
            $data->setFbLink($request->get('fb-link'));
            $data->setPinBBM($request->get('pin-bbm'));
            $data->setAddress($request->get('address'));
            $this->app['session']->set('name', ['value' => $data->getFirstName() . ' ' . $data->getLastName()]);

            if ($request->files->get('profile-image') != null) {
                if ($data->getPicture() != null) {
                    $fileDummy = $data->getPicture();
                }
                if ($fileDummy != '') {
                    if (file_exists($this->app['foto.path'] . '/profiles/' . $data->getPicture())) {
                        unlink($this->app['foto.path'] . '/profiles/' . $fileDummy);
                    }
                }
                $fileName = md5(uniqid()) . '.' . $request->files->get('profile-image')->guessExtension();
                $data->setPicture($fileName);
                $request->files->get('profile-image')->move($this->app['foto.path'] . '/profiles/', $fileName);
                $this->app['session']->set('profile_picture', ['value' => $fileName]);
            }

            if ($request->files->get('berkas-ktp') != null) {
                $ktpName = md5(uniqid()) . '.' . $request->files->get('berkas-ktp')->guessExtension();
                $data->setKtpPicture($ktpName);
                $request->files->get('berkas-ktp')->move($this->app['foto.path'] . '/ktp-picture/', $ktpName);
            }

            $this->app['orm.em']->merge($data);

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

    public function clientForgetAction(Request $request)
    {
        $session = $this->app['session'];
        if ($request->getMethod() == 'POST') {
            $data = $this->app['user.repository']->findByEmail($request->get('email'));

            if ($data != null ) {
                $transport = \Swift_SmtpTransport::newInstance
                ('smtp.gmail.com', 587, 'tls')
                    ->setUsername('killcoder212@gmail.com')
                    ->setPassword('Faster123');

                $message = \Swift_Message::newInstance();
                $message->setSubject('Activation Required');
                $message->setFrom(['noreply@fifo.com']);
                $message->setTo([$request->get('email')]);
                $message->setBody(
                    $this->app['twig']->render(
                        'Client/forget_temp.twig',
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

                return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
            } else {
                $session->getFlashBag()->add(
                    'message_error', 'Maaf alamat e-mail tidak dikenal'
                );
            }

        }
        return $this->app['twig']->render('Client/forget.twig');
    }

    public function clientResetAction(Request $request)
    {
        $data = $this->app['user.repository']->findByToken($request->get('token'));
        if ($data != null) {
            if ($request->getMethod() == 'POST') {
                if ($request->get('password') == $request->get('repeat-password')) {
                    $data->setPassword($request->get('repeat-password'));

                    $this->app['orm.em']->flush();
                    $this->app['session']->getFlashBag()->add('message_success','Password telah berhasil diganti, silahkan masuk dengan password baru anda.');
                    return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
                } else {
                    $this->app['session']->getFlashBag()->add('message_error','Password tidak cocok');
                }
            }

            return $this->app['twig']->render('Client/reset_password.twig');

        } else {
            return 'Token tidak valid, silahkan periksa kembali link yang anda terima';
        }

    }

    public function clientSettingPasswordAction(Request $request)
    {
        $data = $this->app['user.repository']->findByEmail($this->app['session']->get('email'));

        if ($request->getMethod() == 'POST' ) {
            if ($data->getPassword() == md5($request->get('old-password'))) {
                if ($request->get('password') == $request->get('repeat-password')) {
                    $data->setPassword($request->get('password'));
                    $this->app['orm.em']->flush();

                    $this->app['session']->getFlashBag()->add('message_success', 'Password telah berhasil diganti, silahkan masuk dengan password baru anda');
                    return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
                } else {
                    $this->app['session']->getFlashBag()->add('message_error','Password tidak cocok, silahkan ulangi lagi');
                }
            } else {
                $this->app['session']->getFlashBag()->add('message_error','Password lama tidak cocok');
            }
        }

        return $this->app['twig']->render('Client/setting_password.twig');
    }
}