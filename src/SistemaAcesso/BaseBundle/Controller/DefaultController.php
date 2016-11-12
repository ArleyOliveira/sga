<?php

namespace SistemaAcesso\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class DefaultController
 * @package SistemAcesso\BaseBundle\Controller
 *
 * @Template()
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="default_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        return [
            'name' => 'Arley',
        ];
    }
}
