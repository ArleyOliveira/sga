<?php


namespace SistemaAcesso\BaseBundle\Entity\Filter;


use SistemaAcesso\SchoolBundle\Entity\Course;

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
     * UniversalFilter constructor.
     */
    public function __construct()
    {
        $this->active = true;
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
}