<?php


namespace SistemaAcesso\SchoolBundle\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * class Discipline
 * @ORM\Entity
 * @ORM\Table(name="disciplines")
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\DisciplineRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @var string
     * @ORM\Column(name="sigla", type="string", nullable=false)
     * @Assert\NotBlank(message="discipline.blank_sigla")
     */
    private $sigla;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SistemaAcesso\SchoolBundle\Entity\Schedule", mappedBy="discipline")
     */
    private $schedules;

    /**
     * Discipline constructor.
     */
    public function __construct()
    {
        $this->active = true;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
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
        if($course){
            $course->addDiscipline($this);
        }
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
     * @ORM\PreUpdate
     * @ORM\PrePersist
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
        $this->updated = ($updated) ? $updated : new \DateTime('now');
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
     */
    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
    }


    /**
     * @param Schedule $schedule
     * @return Discipline
     */
    public function addSchedule(Schedule $schedule)
    {
        $this->schedules->add($schedule);
        return $this;
    }

    /**
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param string $sigla
     * @return Discipline
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }


}