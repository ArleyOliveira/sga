<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 25/03/17
 * Time: 09:27
 */

namespace SistemaAcesso\SchoolBundle\Controller;


use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\BaseBundle\Form\Type\Filter\UniversalFilterType;
use SistemaAcesso\SchoolBundle\Entity\Environment;
use SistemaAcesso\SchoolBundle\Entity\Schedule;
use SistemaAcesso\SchoolBundle\Entity\ScheduleRegister;
use SistemaAcesso\SchoolBundle\Entity\Semester;
use SistemaAcesso\SchoolBundle\Form\Type\ScheduleRegisterType;
use SistemaAcesso\SchoolBundle\Form\Type\ScheduleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ScheduleController
 * @package SistemaAcesso\SchoolBundle\Controller
 * @Template()
 * @Route("/schedule")
 */
class ScheduleController extends Controller
{
    /**
     * @Route("/", name="schedule_index")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function indexAction(Request $request)
    {
        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($filter->getEnvironment()){
            $environments[] = $filter->getEnvironment();
        }else{
            $environments = $em->getRepository(Environment::class)->findFilter();
        }


        if($filter->getYear() && $filter->getSemester()){
            $semester = $em->getRepository(Semester::class)->findOneBy(['year' => $filter->getYear(), 'semester' => $filter->getSemester()]);
        }else{
            $semester = $em->getRepository(Semester::class)->findOneBy(['active' => true, 'current' => true]);
            $filter
                ->setYear($semester->getYear())
                ->setSemester($semester->getSemester())
            ;

            $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
            $form->handleRequest($request);
        }

        $timeGrid = [];

        if($semester){
            foreach ($environments as $environment){
                for($i = 1; $i <= 7; $i++){
                    $timeGrid[$environment->getId()][$i] = $em->getRepository(Schedule::class)->findByEnvironmentSemesterAndWeekDay($environment, $semester, $i, true);
                }

            }
        }

        return array(
            'environments' => $environments,
            'timeGrid' => $timeGrid,
            'form' => $form->createView(),
            'semester' => $semester,
            'filter' => $filter
        );
    }

    /**
     * @Route("/new", name="schedule_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $scheduleRegister = new ScheduleRegister();
        $form = $this->createForm(new ScheduleRegisterType(), $scheduleRegister);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $semester = $em->getRepository(Semester::class)->findBy(['active' => true, 'current' => true]);
        if (count($semester) == 1) {
            $semester = $semester[0];
        } else {
            $this->addErrorMessage('Não foi encontrado nenhum sempre marcado como atual!');
            return $this->redirectToRoute('semester_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($scheduleRegister->getItemsSchedule()) {
                try {
                    foreach ($scheduleRegister->getItemsSchedule() as $item) {
                        $schedule = new Schedule();
                        $schedule
                            ->setUser($scheduleRegister->getTeacher())
                            ->setDiscipline($scheduleRegister->getDiscipline())
                            ->setEnvironment($item->getEnvironment())
                            ->setWeekDay($item->getWeekDay())
                            ->setStartTime($item->getStartTime())
                            ->setEndTime($item->getEndTime())
                            ->setSemester($semester);
                        $em->persist($schedule);
                    }
                    $em->flush();
                    $this->addSuccessMessage('schedule.new.success');
                    return $this->redirectToRoute('schedule_index');
                } catch (\Exception $e) {
                    $this->addErrorMessage('schedule.new.error');
                }

            } else {
                $this->addErrorMessage('Nenhum horário foi adicionado!');
            }
        }
        return array(
            'form' => $form->createView()
        );

    }

    /**
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="schedule_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Schedule $schedule, Request $request)
    {

        $editForm = $this->createForm(new ScheduleType(), $schedule);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($schedule);
                $em->flush();
                $this->addSuccessMessage('schedule.edit.success');

            } catch (\Exception $e) {
                $this->addErrorMessage('schedule.edit.error');

            }

            return $this->redirectToRoute('schedule_index');
        }
        return array(
            'schedule' => $schedule,
            'form' => $editForm->createView(),
        );
    }

    /**
     * @Route("/delete/{id}",
     *      requirements={"id" = "\d+"},
     *      name="schedule_delete"
     * )
     * @Method({"GET", "DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    function deleteAction(Request $request, Schedule $schedule)
    {
        try {

            $em = $this->getDoctrine()->getManager();
            $schedule->setActive(false);
            $em->persist($schedule);
            $em->flush();


            $this->addSuccessMessage('schedule.delete.success');

        } catch (\Exception $e) {

            $this->addErrorMessage('schedule.delete.error');

        }

        return $this->redirectToRoute('schedule_index', ['mode' => 2]);
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