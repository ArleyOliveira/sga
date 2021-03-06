<?php


namespace SistemaAcesso\SchoolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Events;

/**
 * class Environment
 * @ORM\Entity
 * @ORM\Table(name="environments")
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\EnvironmentRepository")
 * @UniqueEntity(fields="name", message="environment.unique_name")
 * @UniqueEntity(fields="identification", message="environment.unique_identification")
 * @ORM\HasLifecycleCallbacks()
 */
class Environment
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
     * @Assert\NotBlank(message="environment.blank_name")
     */
    private $name;

    /**
     * @var Assert\Time
     *
     * @ORM\Column(type="time",nullable=true, name="start_time")
     * @Assert\NotBlank(message="environment.blank_start_time")
     */
    private $startTime;

    /**
     * @var Assert\Time
     *
     * @ORM\Column(type="time",nullable=true, name="end_time")
     * @Assert\NotBlank(message="environment.blank_end_time")
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="identification")
     * @Assert\NotBlank(message="environment.blank_identification")
     */
    private $identification;

    /**
     * @var \DateTime
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
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SistemaAcesso\SchoolBundle\Entity\Schedule", mappedBy="environment")
     */
    private $schedules;

    /**
     * Environment constructor.
     */
    public function __construct()
    {
        $this->active = true;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
        $this->schedules = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'identification' => $this->identification,
            'created' => $this->created,
            'updated' => $this->updated,
            'active' => $this->active,
        ];
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
     * @return Environment
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
     * @return Environment
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Environment
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
     * @return Environment
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * @param string $identification
     * @return Environment
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
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
     * @return Environment
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
     * @return Environment
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated = new \DateTime('now');
    }

    /**
     * @ORM\PrePersist
     * @return Environment
     */
    public function setUpdated()
    {

        $this->updated = new \DateTime('now');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * @param mixed $schedules
     * @return Environment
     */
    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
        return $this;
    }

    /**
     * @param Schedule $schedule
     * @return Environment
     */
    public function addSchedule(Schedule $schedule)
    {
        $this->schedules->add($schedule);
        return $this;
    }
}