<?php
/**
 * Pop Web Bootstrap Application Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/pop-bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace App\Controller\Admin\Users;

use App\Controller\AbstractController;
use App\Form;
use App\Model;
use Pop\Paginator\Form as Paginator;

/**
 * Users controller class
 *
 * @category   Pop\Bootstrap
 * @package    Pop\Bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class UsersController extends AbstractController
{
    /**
     * Index action method
     *
     * @param  int $rid
     * @return void
     * @throws \Pop\Http\Exception
     * @throws \Pop\View\Exception
     */
    public function index($rid = null)
    {
        if ((null === $rid) || ($this->services['acl']->isAllowed($this->sess->user->role, 'users-of-role-' . $rid, 'index'))) {
            $deniedRoles = [];
            $resources   = $this->services['acl']->getResources();
            foreach ($resources as $name => $resource) {
                if (!$this->services['acl']->isAllowed($this->sess->user->role, $name, 'index')) {
                    $deniedRoles[] = (int)substr($name, strrpos($name, '-') + 1);
                }
            }

            $user = new Model\User();

            $searchUsername = $this->request->getQuery('search_username');

            if ($user->hasPages($this->application->config()['pagination'], $rid, $searchUsername, $deniedRoles)) {
                $limit = $this->application->config()['pagination'];
                $pages = new Paginator($user->getCount($rid, $searchUsername, $deniedRoles), $limit);
            } else {
                $limit = null;
                $pages = null;
            }

            $this->prepareView('users/index.phtml', 'admin' );
            $this->view->staticNav   = $this->services['nav.static'];
            $this->view->title          = 'Users';
            $this->view->pages          = $pages;
            $this->view->roleId         = $rid;
            $this->view->queryString    = $this->getQueryString('sort');
            $this->view->searchUsername = $searchUsername;
            $this->view->users          = $user->getAll(
                $rid, $searchUsername, $deniedRoles, $limit,
                $this->request->getQuery('page'), $this->request->getQuery('sort')
            );
            $this->view->roles = $user->getRoles();
            $this->send();
        } else {
            $this->redirect('/users');
        }
    }

    /**
     * Add action method
     *
     * @param  int $rid
     * @return void
     * @param null $rid
     * @throws \Pop\Db\Exception
     * @throws \Pop\Http\Exception
     * @throws \Pop\Service\Exception
     * @throws \Pop\View\Exception
     */
    public function add($rid = null)
    {
        $this->prepareView('users/add.phtml', 'admin' );
        $this->view->staticNav   = $this->services['nav.static'];
        $this->view->title = 'Add User';

        if (null !== $rid) {
            $role = new Model\Role();
            $role->getById($rid);
            $this->view->title .= ' : ' . $role->name;

            if ( $role->email_as_username ) {
                $fields = $this->application->config()['forms']['App\Form\UserEmail'];
            } else {
                $fields = $this->application->config()['forms']['App\Form\User'];
                if ( $role->email_required ) {
                    $fields[1]['email']['required'] = true;
                }
            }

            $fields[1]['password1']['required']   = true;
            $fields[1]['password1']['validators'] = new \Pop\Validator\LengthGte(6);
            $fields[1]['password2']['required']   = true;
            $fields[0]['role_id']['value']        = $rid;
            unset($fields[0]['clear_logins']);
            unset($fields[0]['failed_attempts']);

            //echo "<pre>"; print_r($fields); echo "</pre>";
            $this->view->form = ($role->email_as_username)
                ? Form\User::createFromFieldsetConfig($fields)
                : Form\UserEmail::createFromFieldsetConfig($fields);

            if ($this->request->isPost()) {
                $this->view->form->addFilter('strip_tags')
                     ->addFilter('htmlentities', [ENT_QUOTES, 'UTF-8', false])
                     ->setFieldValues($this->request->getPost());

                if ($this->view->form->isValid()) {
                    $this->view->form->clearFilters()
                         ->addFilter('html_entity_decode', [ENT_QUOTES, 'UTF-8'])
                         ->filterValues();
                    $user = new Model\User();
                    $user->save(
                        $this->view->form,
                        $this->application->config()['application_title'],
                        $this->application->services()->get('mailer')
                    );

                    $this->view->id = $user->id;
                    $this->sess->setRequestValue('saved', true);
                    $this->redirect('/users/edit/' . $user->id);
                }
            }
        } else {
            $this->view->roles = (new Model\Role())->getAll();
        }

        $this->send();
    }

    /**
     * Edit action method
     *
     * @param  int $id
     * @return void
     * @throws \Pop\Http\Exception
     * @throws \Pop\Service\Exception
     * @throws \Pop\View\Exception
     */
    public function edit($id)
    {
        $user = new Model\User();
        $user->getById($id);

        if (!isset($user->id)) {
            $this->redirect('/users');
        }

        if ($this->services['acl']->isAllowed($this->sess->user->role, 'users-of-role-' . $user->role_id, 'edit')) {
            $this->prepareView('users/edit.phtml', 'admin' );
            $this->view->staticNav   = $this->services['nav.static'];
            $this->view->title    = 'Edit User';
            $this->view->username = $user->username;

            $role       = new Model\Role();
            $roles      = $role->getAll();
            $roleValues = [];
            foreach ($roles as $r) {
                $roleValues[$r->id] = $r->name;
            }

            $fields = $this->application->config()['forms']['App\Form\User'];

            $fields[1]['username']['attributes']['onkeyup'] = 'pop.changeTitle(this.value);';
            $fields[1]['password1']['required']    = false;
            $fields[1]['password2']['required']    = false;
            $fields[0]['clear_logins']['label']    = $user->total_logins . ' Login' . (($user->total_logins == 1) ? '' : 's');
            $fields[0]['role_id']['type']          = 'select';
            $fields[0]['role_id']['label']         = 'Role';
            $fields[0]['role_id']['values']        = $roleValues;
            $fields[0]['role_id']['selected']      = $user->role_id;

            $this->view->form = Form\User::createFromFieldsetConfig($fields);
            $this->view->form->addFilter('strip_tags', null, 'textarea')
                 ->addFilter('htmlentities', [ENT_QUOTES, 'UTF-8', false])
                 ->setFieldValues($user->toArray());

            if ($this->request->isPost()) {
                $this->view->form->addFilter('strip_tags', null, 'textarea')
                    ->setFieldValues($this->request->getPost());

                if ($this->view->form->isValid()) {
                    $this->view->form->clearFilters()
                        ->addFilter('html_entity_decode', [ENT_QUOTES, 'UTF-8'])
                        ->filterValues();
                    $user = new Model\User();
                    $user->update(
                        $this->view->form,
                        $this->application->config()['application_title'],
                        $this->application->services()->get('mailer'),
                        $this->sess
                    );

                    $this->view->id = $user->id;
                    $this->sess->setRequestValue('saved', true);
                    $this->redirect('/users/edit/' . $user->id);
                }
            }
            $this->send();
        } else {
            $this->redirect('/users');
        }
    }

    /**
     * Process action method
     *
     * @return void
     * @throws \Pop\Http\Exception
     * @throws \Pop\Service\Exception
     */
    public function process()
    {
        if ($this->request->isPost()) {
            $user = new Model\User();
            $user->process($this->request->getPost(), $this->application->config()['application_title'], $this->application->services()->get('mailer'));
        }

        if ((null !== $this->request->getPost('user_process_action')) && ($this->request->getPost('user_process_action') == -1)) {
            $this->sess->setRequestValue('removed', true);
        } else {
            $this->sess->setRequestValue('saved', true);
        }

        $this->redirect('/users' .
            (((int)$this->request->getPost('role_id') != 0) ? '/' . (int)$this->request->getPost('role_id') : null));
    }
}