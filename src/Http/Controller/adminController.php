<?php
/**
 * Created by PhpStorm.
 * User: jimmyfish
 * Date: 11/14/16
 * Time: 2:35 PM
 */

namespace Jimmy\fifo\Http\Controller;


use Jimmy\fifo\Domain\Entity\About;
use Jimmy\fifo\Domain\Entity\Barang;
use Jimmy\fifo\Domain\Entity\Category;
use Jimmy\fifo\Domain\Entity\Faq;
use Jimmy\fifo\Domain\Entity\Footer;
use Jimmy\fifo\Domain\Entity\Komunitas;
use Jimmy\fifo\Domain\Entity\Member;
use Jimmy\fifo\Domain\Entity\Team;
use Jimmy\fifo\Domain\Entity\User;
use Jimmy\fifo\Domain\Entity\Video;
use Silex\Application;
use Silex\Controller;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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

        $controllers->get('/barang/found-list', [$this, 'adminBarangListDitemukanAction'])->bind('admin_barang_list_ditemukan');

        $controllers->get('/barang/wanted-list', [$this, 'adminBarangListDicariAction'])->bind('admin_barang_list_dicari');

        $controllers->get('/video/list', [$this, 'adminVideoListAction'])
            ->bind('admin_video_list');

        $controllers->match('/video/create', [$this, 'adminVideoCreateAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_video_create');

        $controllers->get('/video/delete/{id}', [$this, 'adminVideoDeleteAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_video_delete');

        $controllers->match('/video/edit/{id}', [$this, 'adminVideoEditAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_video_edit');

        $controllers->match('/user/edit/{id}', [$this, 'adminUserEditCredentialAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_user_edit_credential');

        $controllers->get('/user/delete/{id}', [$this, 'adminUserDeleteAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_user_delete');

        $controllers->match('/footer/edit', [$this, 'adminFooterEditAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_footer_edit');

        $controllers->match('/faq/create', [$this, 'adminFaqCreateAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_faq_create');

        $controllers->get('/faq/list', [$this, 'adminFaqListAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_faq_list');

        $controllers->get('/faq/delete/{id}', [$this, 'adminFaqDeleteAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_faq_delete');

        $controllers->get('/about/list', [$this, 'adminAboutListAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_about_list');

        $controllers->match('/about/member/create', [$this, 'adminMemberCreateAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_member_create');

        $controllers->get('/about/member/delete/{id}', [$this, 'adminKMemberDeleteAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_member_delete');

        $controllers->match('/about/team/create', [$this, 'adminTeamCreateAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_team_create');

        $controllers->get('/about/team/delete/{id}', [$this, 'adminTeamDeleteAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_team_delete');

        $controllers->match('/about/team/edit/{id}', [$this, 'adminTeamEditAction'])
            ->before([$this, 'credentialCheck'])
            ->bind('admin_team_edit');

        return $controllers;
    }

    public function adminAboutListAction()
    {
        $data = $this->app['team.repository']->findAll();
        return $this->app['twig']->render('Admin/about/list.twig', ['data' => $data]);
    }

    public function adminMemberDeleteAction(Request $request)
    {
        $data = $this->app['member.repository']->findById($request->get('id'));

        if ($data != null) {
            $this->app['orm.em']->remove($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));
        }

        return false;
    }

    public function adminMemberCreateAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = new Member();

            $data->setTitle($request->get('title'));
            $data->setJob($request->get('job'));
            $data->setDescription($request->get('description'));
            $data->setFbLink($request->get('fbLink'));
            $data->setIgLink($request->get('igLink'));
            $data->setImages($request->get('images'));

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));
        }

        return $this->app['twig']->render('Admin/about/member/create.twig');
    }

    public function adminTeamEditAction(Request $request)
    {
        $data = $this->app['team.repository']->findById($request->get('id'));

        if ($data == null) {
            $this->app['session']->getFlashBag()->add(
                'team_error',
                'Komunitas dengan id tersebut tidak ditemukan, proses dibatalkan'
            );

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));
        }

        if ($request->getMethod() === 'POST') {
            $data->setTitle($request->get('title'));
            $data->setDescription($request->get('description'));
            $data->setImages($request->get('images'));

            $this->app['orm.em']->merge($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));
        }

        return $this->app['twig']->render('Admin/about/team/edit.twig', ['data' => $data]);
    }

    public function adminTeamDeleteAction(Request $request)
    {
        $data = $this->app['team.repository']->findById($request->get('id'));

        if ($data != null) {
            $this->app['orm.em']->remove($data);
            $this->app['orm.em']->flush();

            $this->app['session']->getFlashBag()->add(
                'team_success',
                'Komunitas berhasil dihapus'
            );

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));

        } else {
            $this->app['session']->getFlashBag()->add(
                'team_error',
                'Komunitas dengan id tersebut tidak tersedia, Proses dibatalkan'
            );

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));
        }

        return false;
    }

    public function adminTeamCreateAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = new Team();

            $data->setTitle($request->get('title'));
            $data->setDescription($request->get('description'));
            $data->setImages($request->get('images'));

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            $this->app['session']->getFlashBag()->add(
                'team_success',
                'Komunitas berhasil ditambahkan'
            );

            return $this->app->redirect($this->app['url_generator']->generate('admin_about_list'));
        }

        return $this->app['twig']->render('Admin/about/team/create.twig');
    }

    public function adminFaqDeleteAction(Request $request)
    {
        $data = $this->app['faq.repository']->findById($request->get('id'));

        if ($data != null) {
            $this->app['orm.em']->remove($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_faq_list'));
        }

        return false;
    }

    public function adminFaqListAction()
    {
        $data = $this->app['faq.repository']->findAll();
        return $this->app['twig']->render('Admin/faq/list.twig', ['data' => $data]);
    }

    public function adminFaqCreateAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = new Faq();

            $data->setQuestion($request->get('question'));
            $data->setAnswer($request->get('answer'));

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_faq_list'));
        }

        return $this->app['twig']->render('Admin/faq/create.twig');
    }

    public function adminFooterEditAction(Request $request)
    {
        $data = $this->app['footer.repository']->findAll();

        if ($data == null) {
            $info = Footer::init();

            $this->app['orm.em']->persist($info);
            $this->app['orm.em']->flush();
        } else {
            $info = $data[0];

            if ($request->getMethod() === 'POST') {
                $info->setDonasiUmum($request->get('donasi-umum'));
                $info->setFacebook($request->get('facebook'));
                $info->setInstagram($request->get('instagram'));
                $info->setGooglePlus($request->get('google-plus'));
                $info->setUpdatedAt(new \DateTime());

                $this->app['orm.em']->merge($info);
                $this->app['orm.em']->flush();

                return $this->app->redirect($this->app['url_generator']->generate('admin_footer_edit'));
            }

            return $this->app['twig']->render('Admin/footer.twig', ['info' => $info]);
        }

        return $this->app['twig']->render('Admin/footer.twig');
    }

    public function adminUserDeleteAction(Request $request)
    {
        $user_id = $request->get('id');

        if ($user_id != null and $user_id != '') {
            $data = $this->app['user.repository']->findById($user_id);

            if ($data != null) {
                $data->setIsDelete(1);

                $this->app['orm.em']->merge($data);
                $this->app['orm.em']->flush();

                return $this->app->redirect($this->app['url_generator']->generate('user_list'));
            }
        }
    }

    public function adminUserEditCredentialAction(Request $request)
    {
        $data = $this->app['user.repository']->findById($request->get('id'));

        if ($data == null) {
            $this->app['session']->getFlashBag()->add(
                'user_error',
                'Pengguna dengan id tersebut tidak ditemukan, proses dibatalkan'
            );

            return $this->app->redirect($request->headers->get('referer'));
        }

        if ($request->getMethod() === 'POST') {
            $data->setRole($request->get('role'));
            $this->app['orm.em']->merge($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('user_list'));
        }

        return $this->app['twig']->render('Admin/users/edit-credential.twig', ['data' => $data->getRole()]);
    }

    public function adminVideoEditAction(Request $request)
    {
        $data = $this->app['video.repository']->findById($request->get('id'));

        if ($data == null) {
            $this->app['session']->getFlashBag()->add(
                'video_error',
                'Video dengan id tersebut tidak ditemukan, proses dibatalkan'
            );

            return $this->app->redirect($request->headers->get('referer'));
        }

        if ($request->getMethod() === 'POST') {
            $data->setTitle($request->get('title'));
            $data->setLinkVideo($request->get('link_video'));
            $data->setDescription($request->get('description'));
            $data->setUpdatedAt(new \DateTime());

            $this->app['orm.em']->merge($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_video_list'));
        }

        return $this->app['twig']->render('Admin/video/edit.twig', ['data' => $data]);
    }

    public function adminVideoDeleteAction(Request $request)
    {
        $data = $this->app['video.repository']->findById($request->get('id'));

        if ($data != null) {
            $this->app['orm.em']->remove($data);
            $this->app['orm.em']->flush();

            $this->app['session']->getFlashBag()->add(
                'video_success',
                'Video berhasil dihapus'
            );

            return $this->app->redirect($request->headers->get('referer'));

        } else {
            $this->app['session']->getFlashBag()->add(
                'video_error',
                'Video dengan id tersebut tidak tersedia, Proses dibatalkan'
            );

            return $this->app->redirect($request->headers->get('referer'));
        }
    }

    public function adminVideoCreateAction(Request $request)
    {
        $user = $this->app['user.repository']->findByEmail($this->app['session']->get('email'));

        if ($request->getMethod() === 'POST') {
            $data = Video::create(
                $request->get('title'),
                $user,
                $request->get('link_video'),
                $request->get('description')
            );

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            $this->app['session']->getFlashBag()->add(
                'video_success',
                'Video berhasil ditambahkan'
            );

            return $this->app->redirect($this->app['url_generator']->generate('admin_video_list'));
        }

        return $this->app['twig']->render('Admin/video/create.twig');
    }

    public function adminVideoListAction()
    {
        $videoList = $this->app['video.repository']->findAll();

        return $this->app['twig']->render('Admin/video/list.twig', ['videoList' => $videoList]);
    }

    public function adminBarangListDitemukanAction()
    {
        $barangList = $this->app['barang.repository']->findByType(0);

        for ($i = 0;$i < count($barangList);$i++) {
            $catName = $this->app['category.repository']->findById($barangList[$i]->getCategoryId());
            $barangList[$i]->setCategoryId($catName->getName());
        }

        return $this->app['twig']->render('Admin/barang/list.twig', ['barangList' => $barangList, 'title' => 'Ditemukan']);
    }

    public function adminBarangListDicariAction()
    {
        $barangList = $this->app['barang.repository']->findByType(1);

        for ($i = 0;$i < count($barangList);$i++) {
            $catName = $this->app['category.repository']->findById($barangList[$i]->getCategoryId());
            $barangList[$i]->setCategoryId($catName->getName());
        }

        return $this->app['twig']->render('Admin/barang/list.twig', ['barangList' => $barangList, 'title' => 'Dicari']);
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

    public function credentialCheck()
    {
        $session = $this->app['session'];
        if ($session->get('role')['value'] != 0) {
            return $this->app->redirect($this->app['url_generator']->generate('loginClient'));
        }
        return null;
    }

}