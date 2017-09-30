<?php


namespace SistemaAcesso\UserBundle\Controller;


use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\BaseBundle\Form\Type\Filter\UniversalFilterType;
use SistemaAcesso\UserBundle\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SistemaAcesso\UserBundle\Entity\User;
use SistemaAcesso\UserBundle\Form\AdminType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 * @package SistemaAcesso\UserBundle\Controller
 * @Route("/person")
 * @Template()
 */
class PersonController extends Controller
{
    /**
     * @Route("/", name="person_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User\Person::class)->findFilter($filter->isActive(), $filter->getName(), $filter->getActivity());

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
     * @Route("/new", name="person_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $user = new User\Person();
        $form = $this->createForm(new PersonType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $user->setRoles(['ROLE_USER']);
                $user->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addSuccessMessage('person.new.success');

            } catch (\Exception $e) {
                //echo $e->getMessage(); die;
                $this->addErrorMessage('person.new.error');

            }
            return $this->redirectToRoute('person_index');
        }

        return array(
            'user' => $user,
            'form' => $form->createView()
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="person_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(User\Person $user, Request $request)
    {
        $editForm = $this->createForm(new PersonType(), $user);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addSuccessMessage('person.edit.success');

            } catch (\Exception $e) {

                $this->addErrorMessage('person.edit.error');

            }

            return $this->redirectToRoute('person_index');
        }

        return array(
            'user' => $user,
            'form' => $editForm->createView(),
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