<?php


namespace SistemaAcesso\SchoolBundle\Entity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @Assert\NotBlank(message="course.blank_name")
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(type="string", name="knowledge_area")
     * @Assert\NotBlank(message="course.blank_knowledge_area")
     */
    private $knowledgeArea;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SistemaAcesso\SchoolBundle\Entity\Discipline", mappedBy="course")
     */
    private $disciplines;


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
     * @var DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
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
        $this->disciplines = new ArrayCollection();
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
     * @ORM\PreUpdate
     * @ORM\PrePersist
     * @param DateTime $updated
     * @return Course
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * @param ArrayCollection $disciplines
     * @return Course
     */
    public function setDisciplines($disciplines)
    {
        $this->disciplines = $disciplines;
        return $this;
    }

    /**
     * @param Discipline $discipline
     * @return Course
     */
    public function addDiscipline(Discipline $discipline){
        $this->disciplines->add($discipline);
        return $this;
    }

    /**
     * @param Discipline $discipline
     * @return Course
     */
    public function removeDiscipline(Discipline $discipline){
        $this->disciplines->removeElement($discipline);
        return $this;
    }
}