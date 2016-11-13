<?php


namespace SistemaAcesso\UserBundle\Entity\User;


use SistemaAcesso\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
/**
 * Admin
 *
 * @ORM\Table(name="admins")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="SistemaAcesso\UserBundle\Repository\AdminRepository")
 */
class Admin extends User
{
    public function getType()
    {
        return self::USER_ADMIN;
    }
}