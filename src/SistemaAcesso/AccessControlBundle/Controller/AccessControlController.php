<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 02/04/17
 * Time: 16:08
 */

namespace SistemaAcesso\AccessControlBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class AccessControlController
 * @package SistemaAcesso\AccessControlController\Controller
 * @Template()
 * @Route("/access-control")
 */
class AccessControlController extends Controller
{
    /**
     * @Route("/check", name="access_control_check")
     * @Method("GET")
     */
    public function checkAction(Request $request){

        echo "Acesso concebido"; die;
    }

    /**
     * @Route("/check-out", name="access_control_check_out")
     * @Method("GET")
     */
    public function checkOutAction(Request $request){

        echo "Acesso encerrado!"; die;
    }

}