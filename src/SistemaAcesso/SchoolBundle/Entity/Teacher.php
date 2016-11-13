<?php


namespace SistemaAcesso\SchoolBundle\Entity;

use SistemaAcesso\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Teacher
 *
 * @ORM\Table(name="teachers")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="SistemaAcesso\SchoolBundle\Repository\TeacherRepository")
 */
class Teacher extends User
{

    /**
     * @var integer
     * @ORM\Column(type="integer", name="siape", nullable=true)
     */
    private $siape;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getSiape()
    {
        return $this->siape;
    }

    /**
     * @param int $siape
     * @return Teacher
     */
    public function setSiape($siape)
    {
        $this->siape = $siape;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::USER_TEACHER;
    }
}