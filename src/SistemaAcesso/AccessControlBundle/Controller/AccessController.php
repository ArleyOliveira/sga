<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 02/04/17
 * Time: 16:22
 */

namespace SistemaAcesso\AccessControlBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SistemaAcesso\AccessControlBundle\Entity\Access;
use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\BaseBundle\Form\Type\Filter\UniversalFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AccessController
 * @package SistemaAcesso\AccessControlController\Controller
 * @Template()
 * @Route("/access")
 */
class AccessController extends Controller
{
    /**
     * @Route("/", name="access_index")
     * @Method("GET")
     */
    public function indexAction(Request $request){

        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();

        $accesses = $em->getRepository(Access::class)->findFilter(true, $filter->isActive(), $filter->isIsToday(), $filter->getEnvironment(), $filter->getUser(), $filter->getStartDate(), $filter->getEndDate());


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $accesses,
            $request->query->get('page', 1),
            10
        );


        return array(
            'accesses' => $pagination,
            'form' => $form->createView(),
        );
    }

}