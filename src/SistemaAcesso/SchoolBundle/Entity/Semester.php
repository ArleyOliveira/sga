<?php


namespace SistemaAcesso\SchoolBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * class Semester
 * @ORM\Entity
 * @ORM\Table(name="semesters")
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\SemesterRepository")
 */
class Semester
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
     * @var integer
     *
     * @ORM\Column(type="integer", name="year")
     * @Assert\NotBlank(message="semester.blank_year")
     */
    private $year;


    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="semester")
     * @Assert\NotBlank(message="semester.blank_semester")
     */
    private $semester;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;



    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SistemaAcesso\SchoolBundle\Entity\Schedule", mappedBy="semester")
     */
    private $schedules;

    /**
     * Semestre constructor.
     */
    public function __construct()
    {
        $this->active = true;
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');
        $this->schedules = new ArrayCollection();
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
     * @return Semester
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Semester
     */
    public function setYear($year)
    {
        $this->year = $year;
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
     * @return Semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return Semester
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return Semester
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     * @param DateTime $updated
     * @return Semester
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * @param ArrayCollection $schedules
     * @return Semester
     */
    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
        return $this;
    }

    /**
     * @param Schedule $schedule
     * @return Semester
     */
    public function addSchedule(Schedule $schedule)
    {
        $this->schedules->add($schedule);
        return $this;
    }

    /**
     * @return bool
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * @param bool $current
     * @return Semester
     */
    public function setCurrent($current)
    {
        $this->current = $current;
        return $this;
    }

}