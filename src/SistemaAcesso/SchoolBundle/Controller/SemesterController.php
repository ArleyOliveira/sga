<?php


namespace SistemaAcesso\SchoolBundle\Controller;

use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\BaseBundle\Form\Type\Filter\UniversalFilterType;
use SistemaAcesso\SchoolBundle\Entity\Semester;
use SistemaAcesso\SchoolBundle\Form\Type\SemesterType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class SemesterController
 * @package SistemaAcesso\SchoolBundle\Controller
 * @Template()
 * @Route("/semester")
 */
class SemesterController extends Controller
{

    /**
     * @Route("/", name="semester_index")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $semesters = $em->getRepository(Semester::class)->findFilter($filter->isActive(), $filter->getYear(), $filter->getSemester());

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $semesters,
            $request->query->get('page', 1),
            10
        );

        return array(
            'semesters' => $pagination,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/new", name="semester_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $semester = new Semester();
        $form = $this->createForm(new SemesterType(), $semester);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($semester);
                $em->flush();

                $this->addSuccessMessage('semester.new.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('semester.new.error');

            }
            return $this->redirectToRoute('semester_index');
        }
        return array(
            'semester' => $semester,
            'form' => $form->createView(),
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="semester_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Semester $semester, Request $request)
    {

        $editForm = $this->createForm(new SemesterType(), $semester);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($semester);
                $em->flush();
                $this->addSuccessMessage('semester.edit.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('semester.edit.error');

            }

            return $this->redirectToRoute('semester_index');
        }
        return array(
            'semester' => $semester,
            'form' => $editForm->createView(),
        );
    }

    /**
     * @Route("/delete/{id}",
     *      requirements={"id" = "\d+"},
     *      name="semester_delete"
     * )
     * @Method({"GET", "DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    function deleteAction(Request $request, Semester $semester)
    {
        try {

            $em = $this->getDoctrine()->getManager();
            $semester->setActive(false);
            $em->persist($semester);
            $em->flush();

            $this->addSuccessMessage('semester.delete.success');

        } catch (\Exception $e) {

            $this->addErrorMessage('semester.delete.error');

        }

        return $this->redirectToRoute('semester_index');
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