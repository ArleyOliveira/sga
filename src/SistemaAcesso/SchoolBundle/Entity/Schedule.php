<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 11/12/16
 * Time: 10:56
 */

namespace SistemaAcesso\SchoolBundle\Entity;

use SistemaAcesso\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Schedule
 * @ORM\Entity
 * @ORM\Table(name="schedules")
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\ScheduleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Schedule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\UserBundle\Entity\User", inversedBy="schedules")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Assert\NotBlank(message="schedule.blank_user")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="activity", type="string", nullable=true)
     */
    private $activity;

    /**
     * @var Discipline
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\SchoolBundle\Entity\Discipline", inversedBy="schedules")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id")
     */
    private $discipline;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var Assert\Time
     *
     * @ORM\Column(type="time",nullable=true, name="start_time")
     * @Assert\NotBlank(message="schedule.blank_start_time")
     */
    private $startTime;

    /**
     * @var Assert\Time
     *
     * @ORM\Column(type="time",nullable=true, name="end_time")
     * @Assert\NotBlank(message="schedule.blank_end_time")
     */
    private $endTime;

    /**
     * @var Environment
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\SchoolBundle\Entity\Environment", inversedBy="schedules")
     * @ORM\JoinColumn(name="environment_id", referencedColumnName="id")
     * @Assert\NotBlank(message="schedule.blank_environment")
     */
    private $environment;

    /**
     * @var Semester
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\SchoolBundle\Entity\Semester", inversedBy="semester")
     * @ORM\JoinColumn(name="semester_id", referencedColumnName="id")
     */
    private $semester;

    /**
     * @var integer
     * @ORM\Column(name="week_day", type="integer")
     * @Assert\NotBlank(message="schedule.blank_week_day")
     */
    private $weekDay;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="date")
     */
    private $updated;

    /**
     * Schedule constructor.
     */
    public function __construct()
    {
        $this->active = true;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Schedule
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Schedule
     */
    public function setUser($user)
    {
        $this->user = $user;
        $user->addSchedule($this);
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Schedule
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Schedule
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return Schedule
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime('now');
        return $this;
    }

    /**
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     * @return Schedule
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
        return $this;
    }

    /**
     * @return Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * @param Discipline $discipline
     * @return Schedule
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;
        $discipline->addSchedule($this);
        return $this;
    }

    /**
     * @return Assert\Time
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param Assert\Time $startTime
     * @return Schedule
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @return Assert\Time
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param Assert\Time $endTime
     * @return Schedule
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        return $this;
    }


    /**
     * @return int
     */
    public function getWeekDay()
    {
        return $this->weekDay;
    }

    /**
     * @param int $weekDay
     * @return Schedule
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;
        return $this;
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param Environment $environment
     * @return Schedule
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        $environment->addSchedule($this);
        return $this;
    }

    /**
     * @return Semester
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param Semester $semester
     * @return Schedule
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
        $semester->addSchedule($this);
        return $this;
    }


}