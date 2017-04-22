<?php


namespace SistemaAcesso\SchoolBundle\Service;

use Doctrine\ORM\EntityManager;
use SistemaAcesso\SchoolBundle\Entity\Environment;
use SistemaAcesso\SchoolBundle\Utility\Exception\EnviromentInvalidException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EnvironmentService
 * @package SistemaAcesso\SchoolBundle\Service
 */
class EnvironmentService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @param Environment $environment
     * @throws EnviromentInvalidException
     * @return bool
     */
    function checkOperation(Environment $environment, $currentTime = null)
    {
        if(!$currentTime){
            $currentTime = mktime();
        }

        if($environment->getStartTime() and $environment->getEndTime()){
            $startTime = $environment->getStartTime();
            $startTime = mktime($startTime->format('H'), $startTime->format('i'));

            $endTime = $environment->getEndTime();
            $endTime = mktime($endTime->format('H'), $endTime->format('i'));

            if ($currentTime >= $startTime && $currentTime <= $endTime) {
                return true;
            } else {
                throw new EnviromentInvalidException();
            }
        }
        return true;
    }

}