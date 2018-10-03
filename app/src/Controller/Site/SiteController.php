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
namespace App\Controller\Site;

use App\Controller\AbstractController;

/**
 * Index controller class
 *
 * @category   Pop\Bootstrap
 * @package    Pop\Bootstrap
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.0
 */
class SiteController extends AbstractController
{
    public function index()
    {
        $this->prepareView( 'index.phtml', 'site' );
        $this->view->title = 'Home del blog';
        $this->view->content = 'Indice degli articoli';
        $this->send();
    }

    public function content()
    {
        $this->prepareView( 'content.phtml', 'site' );
        $this->view->title = 'Pagina dei contenuti';
        $this->view->content = 'Questa pagina visualizzerà i contenuti del blog';
        $this->send();
    }

}