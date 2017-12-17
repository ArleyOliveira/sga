<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 02/04/17
 * Time: 16:10
 */

namespace SistemaAcesso\AccessControlBundle\Entity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SistemaAcesso\SchoolBundle\Entity\Environment;
use SistemaAcesso\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * class Access
 * @ORM\Entity
 * @ORM\Table(name="accesses")
 * @ORM\Entity(repositoryClass="SistemaAcesso\AccessControlBundle\Repository\AccessRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Access
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
     * @var User
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry_date", type="datetime")
     */
    private $entryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_out", type="boolean")
     */
    private $isOut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="out_date", type="datetime", nullable=true)
     */
    private $outDate;


    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var Environment
     * @ORM\ManyToOne(targetEntity="SistemaAcesso\SchoolBundle\Entity\Environment")
     * @ORM\JoinColumn(name="environment_id", referencedColumnName="id")
     */
    private $environment;

    /**
     * Access constructor.
     */
    public function __construct()
    {
        $this->active = true;
        $this->isOut = false;
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
        $this->entryDate = new \DateTime('now');
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'entryDate' => $this->entryDate,
            'isOut' => $this->isOut,
            'active' => $this->active,
            'outDate' => $this->outDate,
            'user' => $this->user->toArray(),
            'environment' => $this->environment->toArray(),
            'created' => $this->created->format('Y/m/d/ H:i:s'),
            'updated' => $this->updated->format('Y/m/d/ H:i:s')
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
     * @return Access
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Access
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return Access
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
     * @return Access
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * @return Access
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return Access
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime('now');
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsOut()
    {
        return $this->isOut;
    }

    /**
     * @param bool $isOut
     * @return Access
     */
    public function setIsOut($isOut)
    {
        $this->isOut = $isOut;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * @param DateTime $entryDate
     * @return Access
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getOutDate()
    {
        return $this->outDate;
    }

    /**
     * @param DateTime $outDate
     * @return Access
     */
    public function setOutDate($outDate)
    {
        $this->outDate = $outDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getDiffInAndOut(){
        $in = $this->entryDate;
        $out = ($this->isIsOut()) ? $this->outDate : new DateTime('now');

        $diff = $out->diff($in);

        $str  = "";

        if($diff->y){
            $str .= "{$diff->y} ano(s) ";
        }

        if($diff->m){
            $str .= "{$diff->m} mes(es) ";
        }

        if($diff->d){
            $str .= "{$diff->d} dia(s) ";
        }

        if($diff->h){
            $str .= "{$diff->h} hora(s) ";
        }

        if($diff->i){
            $str .= "{$diff->i} minutos(s) ";
        }

        return $str;
    }
}