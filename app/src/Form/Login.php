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
namespace App\Form;

use App\Table;
use Pop\Application;
use Pop\Auth\Table as Auth;
use Pop\Form\Form;
use Pop\Validator;

/**
 * Login form class
 *
 * @category   Pop\Bootstrap
 * @package    Pop\Bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class Login extends Form
{
    /**
     * Constructor
     *
     * Instantiate the form object
     *
     * @param  array  $fields
     * @param  string $action
     * @param  string $method
     */
    public function __construct(array $fields = null, $action = null, $method = 'post')
    {
        parent::__construct($fields, $action, $method);
        $this->setAttribute('id', 'login-form');
        $this->setAttribute('class', 'form-signin');
        $this->setIndent('        ');
    }

    /**
     * Set the field values
     *
     * @param  array $values
     * @param  Auth  $auth
     * @return $this|Form
     * @throws \Pop\Form\Element\Exception
     */
    public function setFieldValues(array $values, Auth $auth = null)
    {
        parent::setFieldValues($values);

        if (($_POST) && (null !== $this->username) && (null !== $this->password) && (null !== $auth)) {
            $auth->authenticate(
                html_entity_decode($this->username, ENT_QUOTES, 'UTF-8'),
                html_entity_decode($this->password, ENT_QUOTES, 'UTF-8')
            );

            if (!($auth->isValid())) {
                $this->getField('password')
                     ->addValidator(new Validator\NotEqual($this->password, 'The login was not correct.'));
            } else if (!$auth->getUser()->verified) {
                $this->getField('password')
                     ->addValidator(new Validator\NotEqual($this->password, 'That user is not verified.'));
            } else if (!$auth->getUser()->active) {
                $this->getField('password')
                     ->addValidator(new Validator\NotEqual($this->password, 'That user is blocked.'));
            } else {
                /**$this->getField('password')
                    ->addValidator(new Validator\NotEqual($this->password, 'That user is not allowed to login.'));*/

                $role = Table\Roles::findById($auth->getUser()->role_id);
                //echo "<pre>"; print_r( $role ); echo "</pre>";
                if (isset($role->id) && (null !== $role->permissions)) {
                    $permissions = unserialize($role->permissions);
                    if (isset($permissions['deny'])) {
                        foreach ($permissions['deny'] as $deny) {
                            if ($deny['resource'] == 'login') {
                                $this->getField('password')
                                    ->addValidator(new Validator\NotEqual(
                                        $this->password, 'That user is not allowed to login.'
                                    ));
                            }
                        }
                    }
                }
            }
        }
        return $this;
    }
}