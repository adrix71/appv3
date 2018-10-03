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
namespace App\Event;

use App\Model;
use App\Table;
use Pop\Application;
use Pop\Http\Response;
use Pop\Http\Request;

/**
 * Session event class
 *
 * @category   Pop\Bootstrap
 * @package    Pop\Bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class Session
{
    /**
     * Check for the user session
     *
     * @param  Application $application
     * @return void
     * @throws \Pop\Http\Exception
     */
    public static function check(Application $application)
    {
        $sess   = $application->getService('session');
        $action = $application->router()->getRouteMatch()->getAction();

        if (isset($sess->user) && isset($sess->user->sess_id) && !isset(Table\UserSessions::findById($sess->user->sess_id)->id)) {
            $user = new Model\User();
            $user->logout($sess);
            unset($sess->user);
            $sess->setRequestValue('expired', true);
            Response::redirect('/login');
            exit();
        } else if (isset($sess->user) && (($action == 'login') || ($action == 'forgot') || ($action == 'verify'))) {
            Response::redirect( '/admin' );
            exit();
        } else if (!isset($sess->user) && ($action != 'login') && ($action != 'forgot') && ($action != 'verify')) {
            $pages = $application->config()['protected_page'];
            $request = new Request();
            foreach ( $pages as $page ) {
                if ( $request->getSegment(0) === $page ) {
                    Response::redirect( '/login' );
                    exit();
                }
            }
        }
    }
}