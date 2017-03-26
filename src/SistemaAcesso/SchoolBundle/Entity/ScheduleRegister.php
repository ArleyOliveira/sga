<?php


namespace SistemaAcesso\SchoolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ScheduleRegister
 * @package SistemaAcesso\SchoolBundle\Entity
 */
class ScheduleRegister
{
    /**
     * @var Discipline
     * @Assert\NotBlank(message="schedule.blank_discipline")
     */
    protected $discipline;

    /**
     * @var Teacher
     * @Assert\NotBlank(message="schedule.blank_user")
     */
    protected $teacher;

    /**
     * @var ArrayCollection|ItemSchedule
     */
    protected $itemsSchedule;

    /**
     * @return Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * @param Discipline $discipline
     * @return ScheduleRegister
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;
        return $this;
    }

    /**
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param Teacher $teacher
     * @return ScheduleRegister
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return ArrayCollection|ItemSchedule
     */
    public function getItemsSchedule()
    {
        return $this->itemsSchedule;
    }

    /**
     * @param ArrayCollection|ItemSchedule $itemsSchedule
     * @return ScheduleRegister
     */
    public function setItemsSchedule($itemsSchedule)
    {
        $this->itemsSchedule = $itemsSchedule;
        return $this;
    }


}