<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 13/11/16
 * Time: 01:56
 */

namespace SistemaAcesso\SchoolBundle\Controller;


use SistemaAcesso\SchoolBundle\Entity\Course;
use SistemaAcesso\SchoolBundle\Form\Type\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class CourseController
 * @package SistemaAcesso\SchoolBundle\Controller
 * @Template()
 * @Route("/course")
 */

class CourseController extends Controller
{
    /**
     * @Route("/", name="course_index")
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
        $courses = $em->getRepository(Course::class)->findAll();

        $total = count($courses);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $courses,
            $request->query->get('page', 1),
            10
        );


        return array(
            'courses' => $pagination,
            'string' => $string,
            'active' => $active,
            'total'  => $total
        );
    }

    /**
     * @Route("/new", name="course_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(new CourseType(), $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($course);
                $em->flush();

                $this->addSuccessMessage('course.new.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('course.new.error');

            }
            return $this->redirectToRoute('course_index');
        }
        return array(
            'course' => $course,
            'form' => $form->createView(),
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="course_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Course $course, Request $request)
    {

        $editForm = $this->createForm(new CourseType(), $course);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($course);
                $em->flush();
                $this->addSuccessMessage('course.edit.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('course.edit.error');

            }

            return $this->redirectToRoute('course_index');
        }
        return array(
            'course' => $course,
            'form' => $editForm->createView(),
        );
    }

    /**
     * @Route("/delete/{id}",
     *      requirements={"id" = "\d+"},
     *      name="course_delete"
     * )
     * @Method({"GET", "DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    function deleteAction(Request $request, Course $course)
    {
        try {

            $em = $this->getDoctrine()->getManager();
            $course->setActive(false);
            $em->persist($course);
            $em->flush();

            $this->addSuccessMessage('course.delete.success');

        } catch (\Exception $e) {

            $this->addErrorMessage('course.delete.error');

        }

        return $this->redirectToRoute('course_index');
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