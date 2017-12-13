<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 13/11/16
 * Time: 14:56
 */

namespace SistemaAcesso\UserBundle\Entity\User;

use SistemaAcesso\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use SistemaAcesso\BaseBundle\Validator\Constraints as AssertBaseBundle;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="SistemaAcesso\UserBundle\Repository\PersonRepository")
 */
class Person extends User
{

    const ACTIVITIES = [
        1 => "Limpeza",
        2 => "Monitoria",
        3 => "Curso",
        4 => "Pelestra",
        5 => "Outros",
    ];

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="date")
     * @Assert\NotBlank(message="person.blank_expiration_date")
     */
    private $expirationDate;

    /**
     * @var integer
     * @Assert\NotBlank(message="person.blank_activity")
     * @ORM\Column(type="integer", name="activity")
     */
    private $activity;


    public function getType()
    {
        return self::USER_PERSON;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     * @return Person
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return integer
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param integer $activity
     * @return Person
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
        return $this;
    }

    public function getActivityExtensive()
    {
        return self::ACTIVITIES[$this->getActivity()];
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        $today = new \DateTime('now');
        if ($today > $this->expirationDate)
            return true;
        return false;
    }
}