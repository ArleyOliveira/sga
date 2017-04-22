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

    /**
     * @Route("/email-test", name="default_email_test")
     * @Method("GET")
     */
    public function testEmailAction(){
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('arley.msn@hotmail.com')
            ->setTo('arley.msn@hotmail.com')
            ->setBody(
                $this->renderView(
                    'email/Hello.html.twig',
                    array('nome' => 'Arley Oliveira')
                )
            )
        ;
        $this->container->get('mailer')->send($message);


        die('!ok');
    }
}
