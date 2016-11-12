<?php

namespace SistemaAcesso\BaseBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CpfCnpj extends Constraint
{
    public $cpf     = false;
    public $cnpj    = false;
    public $message = 'O {{ type }} informado é inválido.';
}