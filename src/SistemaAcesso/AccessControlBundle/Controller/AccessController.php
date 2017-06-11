<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 02/04/17
 * Time: 16:22
 */

namespace SistemaAcesso\AccessControlBundle\Controller;


use mikehaertl\wkhtmlto\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SistemaAcesso\AccessControlBundle\Entity\Access;
use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\BaseBundle\Form\Type\Filter\UniversalFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function indexAction(Request $request)
    {

        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();

        $accesses = $em->getRepository(Access::class)->findFilter(true, null, $filter->isIsToday(), $filter->getEnvironment(), $filter->getUser(), $filter->getStartDate(), $filter->getEndDate());


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

    /**
     * @Route("/last-access", name="access_last")
     * @Method("GET")
     */
    public function lastAccessAction(Request $request)
    {

        $httpCode = 400;

        try {
            $em = $this->getDoctrine()->getManager();
            $accesses = $em->getRepository(Access::class)->findLast();

            $arrayAccess = [];

            foreach ($accesses as $access) {
                $arrayAccess[] = $access->toArray();
            }

            $httpCode = 200;
            $dataResult = [
                'success' => true,
                'accesses' => $arrayAccess
            ];

        } catch (\Exception $e) {
            $dataResult = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        $response = new Response(\json_encode($dataResult, true), $httpCode);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/pdf", name="access_pdf")
     * @Method("GET")
     */
    public function pdfAction(Request $request)
    {
        $filter = new UniversalFilter();
        $form = $this->createForm(new UniversalFilterType(), $filter, ['method' => 'GET']);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();

        $accesses = $em->getRepository(Access::class)->findAll();


        $pdf = new Pdf(array(
            'encoding' => 'UTF-8',  // option with argument
            'commandOptions' => array(
                'escapeArgs' => false,
                'procOptions' => array(
                    // This will bypass the cmd.exe which seems to be recommended on Windows
                    'bypass_shell' => true,
                    // Also worth a try if you get unexplainable errors
                    'suppress_errors' => true,
                ),
            ),
            'disable-smart-shrinking',
            'user-style-sheet' => '/home/arley/projetos/sistema-acesso/web/assets/style/pdf.css',
        ));


        $pdf->addPage($this->renderView('SistemaAcessoAccessControlBundle:Access:pdf.html.twig', [
            'accesses' => $accesses,
        ]));

        if($pdf->send('report1.pdf', true)){
            echo $pdf->getError();
        }

        exit();

    }

}