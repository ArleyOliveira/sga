<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 12/12/16
 * Time: 11:00
 */

namespace SistemaAcesso\BaseBundle\TwigExtensions;


class LabelCountElementExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'label_count_element';
    }


    public function getFilters() {
        return array(
            'label_count_element' => new \Twig_Filter_Method($this, 'labelCountElement',  array(
                'is_safe' => array('html')
            ))
        );
    }

    public function labelCountElement($count) {
        if($count <= 0)
            return '<span class="badge title" title="Nenhum item encontrado!" style="background: #FF5722; color: white">0</span>';
        return '<span class="badge title" style="color: white"  title="Total de Itens: '.$count.'">'.$count.'</span>';
    }
}