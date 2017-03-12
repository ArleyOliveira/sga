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
class InfoController extends Controller
{
    /**
     * @Route("/privacy_policy", name="privacy_policy")
     * @Method("GET")
     */
    public function privacyPolicyAction()
    {
        return [];
    }

    /**
     * @Route("/terms", name="terms")
     * @Method("GET")
     */
    public function termsAction()
    {
        return [];
    }
}