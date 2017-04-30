<?php

namespace SistemaAcesso\UserBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use SistemaAcesso\SchoolBundle\Entity\Schedule;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use SistemaAcesso\BaseBundle\Validator\Constraints as AssertBaseBundle;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="SistemaAcesso\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="cpf", message="user.unique_cpf")
 * @UniqueEntity(fields="email", message="user.unique_email")
 * @UniqueEntity(fields="identificationCard", message="user.unique_identification_card")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "TEACHER" = "SistemaAcesso\SchoolBundle\Entity\Teacher",
 *      "ADMIN" = "SistemaAcesso\UserBundle\Entity\User\Admin",
 *      "PERSON" = "SistemaAcesso\UserBundle\Entity\User\Person",
 * })
 * @ORM\HasLifecycleCallbacks()
 */
abstract class User extends BaseUser
{

    const USER_TEACHER = 'TEACHER';
    const USER_ADMIN = 'ADMIN';
    const USER_PERSON = 'PERSON';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="user.black_name")
     */
    private $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime $dateBirth
     * @ORM\Column(type="datetime", nullable=true, name="date_birth")
     * @Assert\NotBlank(message="user.black_date_birth")
     */
    private $dateBirth;

    /**
     * @var string
     * @ORM\Column(name="cpf", type="string", length=14, nullable=true)
     * @Assert\NotBlank(message="user.blank_cpf")
     * @AssertBaseBundle\CpfCnpj(cpf=true)
     */
    private $cpf;


    /**
     * @var string
     * @Assert\NotBlank(message="user.blank_sex")
     * @ORM\Column(type="string", length=1)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=14, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="cellphone", type="string", length=15, nullable=true)
     */
    private $cellphone;

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
     * @var DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SistemaAcesso\SchoolBundle\Entity\Schedule", mappedBy="user")
     */
    private $schedules;

    /**
     * @var string
     * @ORM\Column(name="idetification_card", type="string", options={"default":null}, unique=true, nullable=true)
     */
    private $identificationCard;

    public function __construct()
    {
        parent::__construct();
        $this->active = true;
        $this->updated = new \DateTime('now');
        $this->created = new \DateTime('now');
        $this->schedules = new ArrayCollection();
        $this->identificationCard = null;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sex' => $this->sex,
            'cpf' => $this->cpf,
            'dateBirth' => $this->dateBirth,
            'type' => $this->type,
            'phone' => $this->phone,
            'cellPhone' => $this->cellphone,
            'created' => $this->created,
            'updated' => $this->updated,
            'active' => $this->active,
        ];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::USER_ADMIN;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return User
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime('now');
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    /**
     * @param \DateTime $dateBirth
     * @return User
     */
    public function setDateBirth($dateBirth)
    {
        $this->dateBirth = $dateBirth;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return User
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
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
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
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
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param string $cellphone
     * @return User
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
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
     */
    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
    }

    /**
     * @param Schedule $schedule
     * @return User
     */
    public function addSchedule(Schedule $schedule)
    {
        $this->schedules->add($schedule);
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentificationCard()
    {
        return $this->identificationCard;
    }

    /**
     * @param string $identificationCard
     */
    public function setIdentificationCard($identificationCard)
    {
        $this->identificationCard = $identificationCard;
    }

}