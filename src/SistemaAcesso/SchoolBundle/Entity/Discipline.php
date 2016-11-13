<?php


namespace SistemaAcesso\SchoolBundle\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * class Discipline
 * @ORM\Entity
 * @ORM\Table(name="disciplines")
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\DisciplineRepository")
 */
class Discipline
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
     * @var string
     *
     * @ORM\Column(type="string", name="name")
     * @Assert\NotBlank(message="discipline.blank_name")
     */
    private $name;

    /**
     * @var Course
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\SchoolBundle\Entity\Course", inversedBy="disciplines")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     * @Assert\NotBlank(message="discipline.blank_course")
     */
    private $course;

    /**
     * @var DateTime
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
     * @var DateTime
     *
     * @ORM\Column(name="updated", type="date")
     */
    private $updated;

    /**
     * Semestre constructor.
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
     * @return Discipline
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return Discipline
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Discipline
     */
    public function setCourse($course)
    {
        $this->course = $course;
        $course->addDiscipline($this);
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
     * @return Discipline
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
     * @return Discipline
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
     * @param DateTime $updated
     * @return Discipline
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }



}