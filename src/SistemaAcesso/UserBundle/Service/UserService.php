<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 27/05/17
 * Time: 20:58
 */

namespace SistemaAcesso\UserBundle\Service;


use SistemaAcesso\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserService
{
    public function checkPassword(User $user, $password){
        $encoder = new MessageDigestPasswordEncoder('sha1');
        $password = $encoder->encodePassword($password, $user->getSalt());
        return $password == $user->PlainPassword();
    }
}