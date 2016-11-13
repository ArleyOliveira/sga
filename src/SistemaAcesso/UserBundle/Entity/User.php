<?php

namespace SistemaAcesso\UserBundle\Entity;

use DateTime;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use SistemaAcesso\BaseBundle\Validator\Constraints as AssertBaseBundle;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="SistemaAcesso\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="cpf", message="user.unique")
 */
class User extends BaseUser
{

    const USER_DEFAULT = 'USER_DEFAULT';
    const USER_ADMIN = 'USER_ADMIN';

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
     * @Assert\NotBlank(message="user.blank_sexy")
     * @ORM\Column(type="string", length=1)
     */
    private $sexy;

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


    public function __construct()
    {
        parent::__construct();
        $this->active = true;
        $this->updated = new \DateTime('now');
        $this->created = new \DateTime('now');
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
     * @param DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
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
    public function getSexy()
    {
        return $this->sexy;
    }

    /**
     * @param string $sexy
     * @return User
     */
    public function setSexy($sexy)
    {
        $this->sexy = $sexy;
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


}