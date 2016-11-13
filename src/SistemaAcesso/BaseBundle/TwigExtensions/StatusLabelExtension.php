<?php

namespace SistemaAcesso\BaseBundle\TwigExtensions;

use \Twig_Extension;

class StatusLabelExtension extends Twig_Extension
{
    public function getName()
    {
        return 'status_label';
    }

    public function getFilters() {
        return array(
            'status_label' => new \Twig_Filter_Method(
                $this,
                'statusLabel',
                array(
                    'is_safe' => array('html')
                )
            ),
        );
    }

    public function statusLabel($status) {
        return ($status) ?
                '<span class="label label-success">Ativo</span>' :
                '<span class="label label-danger">Inativo</span>';
    }
}