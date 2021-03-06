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

use App\Model;
use App\Table;
use Pop\Form\Form;
use Pop\Validator;

/**
 * Forgot form class
 *
 * @category   Pop\Bootstrap
 * @package    Pop\Bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class Forgot extends Form
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
     * @return $this|Form
     * @throws \Pop\Form\Element\Exception
     */
    public function setFieldValues(array $values)
    {
        parent::setFieldValues($values);

        if (($_POST) && (null !== $this->email)) {
            $user  = Table\Users::findOne(['email' => $this->email]);
            if (!isset($user->id)) {
                $this->getField('email')
                     ->addValidator(new Validator\NotEqual($this->email, 'That email does not exist.'));
            } else {
                $role = new Model\Role();
                if (!$role->canSendReminder($user->role_id)) {
                    $this->getField('email')
                        ->addValidator(new Validator\NotEqual($this->email, 'That request cannot be processed.'));
                }
            }
        }

        return $this;
    }
}