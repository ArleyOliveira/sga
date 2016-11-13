<?php


namespace SistemaAcesso\SchoolBundle\Controller;


use SistemaAcesso\SchoolBundle\Entity\Teacher;
use SistemaAcesso\SchoolBundle\Form\Type\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * TeacherController.
 * @package SistemaAcesso\SchoolBundle\Controller
 * @Route("/teacher")
 * @Template()
 */

class TeacherController extends Controller
{
    /**
     * @Route("/", name="teacher_index")
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
        $teachers = $em->getRepository(Teacher::class)->findAll();

        $total = count($teachers);
        $paginator = $this->get('knp_paginator');


        $pagination = $paginator->paginate(
            $teachers,
            $request->query->get('page', 1),
            10
        );

        return array(
            'teachers' => $pagination,
            'string' => $string,
            'active' => $active,
            'total'  => $total
        );
    }

    /**
     * @Route("/new", name="teacher_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $teacher = new Teacher();
        $form = $this->createForm(new TeacherType(), $teacher);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $teacher->setRoles(['ROLE_USER']);
                $teacher->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($teacher);
                $em->flush();
                $this->addSuccessMessage('teacher.new.success');

            } catch (\Exception $e) {
                //echo $e->getMessage(); die;
                $this->addErrorMessage('teacher.new.error');

            }
            return $this->redirectToRoute('teacher_index');
        }

        return array(
            'teacher' => $teacher,
            'form' => $form->createView()
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="teacher_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Teacher $teacher, Request $request)
    {
        $editForm = $this->createForm(new TeacherType(), $teacher);
        $editForm->remove('password');


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($teacher);
                $em->flush();
                $this->addSuccessMessage('teacher.edit.success');

            } catch (\Exception $e) {

                $this->addErrorMessage('teacher.edit.error');

            }

            return $this->redirectToRoute('teacher_index');
        }

        return array(
            'teacher' => $teacher,
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