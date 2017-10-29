<?php

namespace SistemaAcesso\BaseBundle\Controller;

use SistemaAcesso\AccessControlBundle\Entity\Access;
use SistemaAcesso\SchoolBundle\Entity\Environment;
use SistemaAcesso\SchoolBundle\Entity\Teacher;
use SistemaAcesso\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
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
    public function testEmailAction(Request $request)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('arley.msn@gmail.com', 'SGA')
            ->setTo('arley.msn@hotmail.com', 'Arley Oliveira')
            ->setBody(
                $this->renderView(
                    'email/Hello.html.twig',
                    array('name' => 'Arley Oliveira')
                ),
                'text/html'
            );

        $this->container->get('mailer')->send($message);


        return $this->render(
            'email/Hello.html.twig',
            array('name' => 'Arley Oliveira')
        );
    }

    /**
     * @Route("/get-data", name="default_get_data")
     * @Method("GET")
     */
    public function getDataAction(Request $request)
    {
        $httpCode = 400;
        try {

            $em = $this->getDoctrine()->getManager();

            $environments = $em->getRepository(Environment::class)->findFilter(true);
            $teachers = $em->getRepository(Teacher::class)->findFilter(true);
            $users = $em->getRepository(User\Admin::class)->findBy(['active' => true]);
            $persons = $em->getRepository(User\Person::class)->findBy(['active' => true]);
            $access = $em->getRepository(Access::class)->findBy(['active' => true]);

            $data = [
                'countTeacher' => count($teachers),
                'countUser' => count($persons) + count($users),
                'countEnvironment' => count($environments),
                'countAccess' => count($access)
            ];
            $httpCode = 200;
            $dataResult = [
                'success' => true,
                'data' => $data
            ];

        } catch (\Exception $e) {
            $dataResult = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        $response = new Response(\json_encode($dataResult, true), $httpCode);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}
