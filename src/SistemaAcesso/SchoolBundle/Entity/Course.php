<?php


namespace SistemaAcesso\SchoolBundle\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * class Course
 * @ORM\Entity
 * @ORM\Table(name="courses")
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\CourseRepository")
 * @UniqueEntity(fields="name", message="course.unique_name")
 */
class Course
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
     * @Assert\NotBlank(message="semester.blank_name")
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(type="string", name="knowledge_area")
     * @Assert\NotBlank(message="semester.blank_knowledge_area")
     */
    private $knowledgeArea;


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
     * @return Course
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
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Course
     */
    public function setKnowledgeArea($knowledgeArea)
    {
        $this->knowledgeArea = $knowledgeArea;
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
     * @return Course
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
     * @return Course
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
     * @return Course
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

}