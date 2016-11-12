<?php

namespace SistemaAcesso\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SistemaAcessoUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
