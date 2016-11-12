<?php

namespace SistemaAcesso\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * {@inheritDoc}
 */
class SecurityXController extends BaseController {


    /**
     * {@inheritDoc}
     */
    public function renderLogin(array $data) {

    }

}