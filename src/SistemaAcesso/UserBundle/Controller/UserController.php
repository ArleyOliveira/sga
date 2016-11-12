<?php

namespace SistemaAcesso\UserBundle\Controller;


use SistemaAcesso\UserBundle\Entity\User;
use SistemaAcesso\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="user_index")
     */
    public function indexAction()
    {

        return new Response('<html><body>Hello!</body></html>');
    }

    /**
     * @Template()
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $user->setRoles(['ROLE_DEFAULT']);
                $user->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addSuccessMessage('user.new.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('user.new.error');

            }
            return $this->redirectToRoute('default_index');
        }

        return array(
            'user' => $user,
            'form' => $form->createView()
        );

    }

    /**
     * @param $message
     */
    private function addErrorMessage($message)
    {
        $this->get('session')->getFlashBag()->add('error', $message);
    }

    /**
     * @param $message
     */
    private function addSuccessMessage($message)
    {
        $this->get('session')->getFlashBag()->add('success', $message);
    }

    /**
     * @param $message
     */
    private function addInfoMessage($message)
    {
        $this->get('session')->getFlashBag()->add('info', $message);
    }

}