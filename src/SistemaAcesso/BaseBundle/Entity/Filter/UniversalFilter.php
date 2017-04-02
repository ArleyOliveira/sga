<?php


namespace SistemaAcesso\BaseBundle\Entity\Filter;


use SistemaAcesso\SchoolBundle\Entity\Course;
use SistemaAcesso\SchoolBundle\Entity\Environment;
use SistemaAcesso\UserBundle\Entity\User;

class UniversalFilter
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $year;

    /**
     * @var string
     */
    protected $knowledgeArea;

    /**
     * @var Course
     */
    protected $course;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var integer
     */
    protected $semester;

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var integer
     */
    protected $mode;

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var boolean
     */
    protected $isToday;

    /**
     * @var User
     */
    protected $user;

    /**
     * UniversalFilter constructor.
     */
    public function __construct()
    {
        $this->active = true;
        $this->mode = 1;
        $this->isToday = true;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UniversalFilter
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return UniversalFilter
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UniversalFilter
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return UniversalFilter
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string
     */
    public function getKnowledgeArea()
    {
        return $this->knowledgeArea;
    }

    /**
     * @param string $knowledgeArea
     * @return UniversalFilter
     */
    public function setKnowledgeArea($knowledgeArea)
    {
        $this->knowledgeArea = $knowledgeArea;
        return $this;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     * @return UniversalFilter
     */
    public function setCourse($course)
    {
        $this->course = $course;
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
     * @return UniversalFilter
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return int
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param int $semester
     * @return UniversalFilter
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
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
     * @return UniversalFilter
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     * @return UniversalFilter
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return UniversalFilter
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return UniversalFilter
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsToday()
    {
        return $this->isToday;
    }

    /**
     * @param bool $isToday
     * @return UniversalFilter
     */
    public function setIsToday($isToday)
    {
        $this->isToday = $isToday;
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
     * @return UniversalFilter
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


}