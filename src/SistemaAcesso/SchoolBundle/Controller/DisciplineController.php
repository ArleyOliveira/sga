<?php


namespace SistemaAcesso\SchoolBundle\Controller;


use SistemaAcesso\SchoolBundle\Entity\Discipline;
use SistemaAcesso\SchoolBundle\Form\Type\DisciplineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class DisciplineController
 * @package SistemaAcesso\SchoolBundle\Controller
 * @Template()
 * @Route("/discipline")
 */

class DisciplineController extends Controller
{
    /**
     * @Route("/", name="discipline_index")
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
        $disciplines = $em->getRepository(Discipline::class)->findAll();

        $total = count($disciplines);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $disciplines,
            $request->query->get('page', 1),
            10
        );


        return array(
            'disciplines' => $pagination,
            'string' => $string,
            'active' => $active,
            'total'  => $total
        );
    }

    /**
     * @Route("/new", name="discipline_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $discipline = new Discipline();
        $form = $this->createForm(new DisciplineType(), $discipline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($discipline);
                $em->flush();

                $this->addSuccessMessage('discipline.new.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('discipline.new.error');

            }
            return $this->redirectToRoute('discipline_index');
        }
        return array(
            'discipline' => $discipline,
            'form' => $form->createView(),
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="discipline_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Discipline $discipline, Request $request)
    {

        $editForm = $this->createForm(new DisciplineType(), $discipline);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($discipline);
                $em->flush();
                $this->addSuccessMessage('discipline.edit.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('discipline.edit.error');

            }

            return $this->redirectToRoute('discipline_index');
        }
        return array(
            'discipline' => $discipline,
            'form' => $editForm->createView(),
        );
    }

    /**
     * @Route("/delete/{id}",
     *      requirements={"id" = "\d+"},
     *      name="discipline_delete"
     * )
     * @Method({"GET", "DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    function deleteAction(Request $request, Discipline $discipline)
    {
        try {

            $em = $this->getDoctrine()->getManager();
            $discipline->setActive(false);
            $em->persist($discipline);
            $em->flush();

            $this->addSuccessMessage('discipline.delete.success');

        } catch (\Exception $e) {

            $this->addErrorMessage('discipline.delete.error');

        }

        return $this->redirectToRoute('discipline_index');
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