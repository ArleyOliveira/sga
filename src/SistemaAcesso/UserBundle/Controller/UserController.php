<?php

namespace SistemaAcesso\UserBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\BaseBundle\Form\Type\Filter\UniversalFilterType;
use SistemaAcesso\UserBundle\Entity\User;
use SistemaAcesso\UserBundle\Form\AdminType;
use SistemaAcesso\UserBundle\Form\UserProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 * @package SistemaAcesso\UserBundle\Controller
 * @Route("/user")
 * @Template()
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User\Admin::class)->findFilter($filter->isActive(), $filter->getName());

        $paginator = $this->get('knp_paginator');


        $pagination = $paginator->paginate(
            $users,
            $request->query->get('page', 1),
            10
        );

        return array(
            'users' => $pagination,
            'filter' => $filter,
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $user = new User\Admin();
        $form = $this->createForm(new AdminType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $user->setRoles(['ROLE_ADMIN']);
                $user->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addSuccessMessage('user.new.success');

            } catch (\Exception $e) {
                //echo $e->getMessage(); die;
                $this->addErrorMessage('user.new.error');

            }
            return $this->redirectToRoute('user_index');
        }

        return array(
            'user' => $user,
            'form' => $form->createView()
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="user_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(User\Admin $user, Request $request)
    {
        $editForm = $this->createForm(new AdminType(), $user);
        $editForm->remove('password');


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addSuccessMessage('user.edit.success');

            } catch (\Exception $e) {

                $this->addErrorMessage('user.edit.error');

            }

            return $this->redirectToRoute('user_index');
        }

        return array(
            'user' => $user,
            'form' => $editForm->createView(),
        );
    }


    /**
     * @Route("/profile", name="user_profile")
     * @Method({"GET", "POST"})
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();

        $fom = $this->createForm(new UserProfileType(), $user);

        $fom->handleRequest($request);

        if ($fom->isSubmitted() && $fom->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addSuccessMessage('user.edit.success');

            } catch (\Exception $e) {

                $this->addErrorMessage('user.edit.error');

            }
        }

        return array(
            'user' => $user,
            'form' => $fom->createView(),
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