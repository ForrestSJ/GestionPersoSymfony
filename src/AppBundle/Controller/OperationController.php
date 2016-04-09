<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Operation;
use AppBundle\Form\OperationType;
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

    /**
     * @Route("/operation", name="operation_create")
     * @Route("/operation/{id}", name="operation_edit/{id}")
     * @Template()
     */
    public function editOperationAction(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0){
            $entityOperation = $em->getRepository('AppBundle:Operation')->find($id);
            if (!$entityOperation) {
                throw $this->createNotFoundException('Opération non trouvée');
            }
        }
        else{
            $entityOperation = new Operation();
        }

        $form = $this->createForm(OperationType::class, $entityOperation);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $em->persist($entityOperation);
                $em->flush();

                $this->addFlash(
                    'success-toastr',
                    'Enregistrement effectué avec succès'
                );

                return $this->redirect($this->generateUrl('operation_edit/{id}', array('id' => $entityOperation->getId())));
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur s\'est produite lors de l\'enregistrement'
                );
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/suppr_operation/{id}", name="operation_delete/{id}")
     *
     */
    public function deleteOperationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityOperation = $em->getRepository('AppBundle:Operation')->find($id);
        if (!$entityOperation) {
            throw $this->createNotFoundException('Operation non trouvée');
        }

        try {
            $em->remove($entityOperation);
            $em->flush();

            $this->addFlash(
                'success-toastr',
                'Suppression effectuée avec succès'
            );
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                'Une erreur s\'est produite lors de la suppression : ' . $e
            );
        }
        return $this->redirectToRoute('operation_liste', array(), 301);
    }

}
