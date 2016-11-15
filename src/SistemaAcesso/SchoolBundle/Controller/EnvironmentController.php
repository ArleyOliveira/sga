<?php


namespace SistemaAcesso\SchoolBundle\Controller;


use SistemaAcesso\SchoolBundle\Entity\Environment;
use SistemaAcesso\SchoolBundle\Form\Type\EnvironmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class EnvironmentController
 * @package SistemaAcesso\SchoolBundle\Controller
 * @Template()
 * @Route("/environment")
 */

class EnvironmentController extends Controller
{
    /**
     * @Route("/", name="environment_index")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $string = $request->get('string');
        $active = 1;
        if (isset($string)) {
            $active = ($request->get('active') != null) ? 1 : 0;
        }


        $em = $this->getDoctrine()->getManager();
        $environments = $em->getRepository(Environment::class)->findAll();

        $total = count($environments);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $environments,
            $request->query->get('page', 1),
            10
        );


        return array(
            'environments' => $pagination,
            'string' => $string,
            'active' => $active,
            'total'  => $total
        );
    }

    /**
     * @Route("/new", name="environment_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $environment = new Environment();
        $form = $this->createForm(new EnvironmentType(), $environment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($environment);
                $em->flush();

                $this->addSuccessMessage('environment.new.success');

            } catch (\Exception $e) {
                echo $e->getMessage(); die;
                $this->addErrorMessage('environment.new.error');

            }
            return $this->redirectToRoute('environment_index');
        }
        return array(
            'environment' => $environment,
            'form' => $form->createView(),
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="environment_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Environment $environment, Request $request)
    {

        $editForm = $this->createForm(new EnvironmentType(), $environment);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($environment);
                $em->flush();
                $this->addSuccessMessage('environment.edit.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('environment.edit.error');

            }

            return $this->redirectToRoute('environment_index');
        }
        return array(
            'environment' => $environment,
            'form' => $editForm->createView(),
        );
    }

    /**
     * @Route("/delete/{id}",
     *      requirements={"id" = "\d+"},
     *      name="environment_delete"
     * )
     * @Method({"GET", "DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    function deleteAction(Request $request, Environment $environment)
    {
        try {

            $em = $this->getDoctrine()->getManager();
            $environment->setActive(false);
            $em->persist($environment);
            $em->flush();

            $this->addSuccessMessage('environment.delete.success');

        } catch (\Exception $e) {

            $this->addErrorMessage('environment.delete.error');

        }

        return $this->redirectToRoute('environment_index');
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
}