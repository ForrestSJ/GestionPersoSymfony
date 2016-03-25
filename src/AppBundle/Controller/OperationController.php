<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OperationController extends Controller
{
    /**
     * @Route("/operations", name="operation_liste")
     * @Template()
     */
    public function getOperationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entitiesOperation = $em->getRepository('AppBundle:Operation')->findAll();
        return array(
            'entitiesOperation' => $entitiesOperation,
        );
    }
}
