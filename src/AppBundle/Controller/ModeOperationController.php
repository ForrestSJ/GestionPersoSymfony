<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ModeOperation;
use AppBundle\Form\ModeOperationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ModeOperationController extends Controller
{
    /**
     * @Route("/modes_operation", name="mode_operation_liste")
     * @Template()
     */
    public function getModesOperationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entitiesModeOperation = $em->getRepository('AppBundle:ModeOperation')->findAll();
        return array(
            'entitiesModeOperation' => $entitiesModeOperation,
        );
    }

    /**
     * @Route("/mode_operation", name="mode_operation_create")
     * @Route("/mode_operation/{id}", name="mode_operation_edit/{id}")
     * @Template()
     */
    public function editModeOperationAction(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0){
            $entityModeOperation = $em->getRepository('AppBundle:ModeOperation')->find($id);
            if (!$entityModeOperation) {
                throw $this->createNotFoundException('Mode opération non trouvée');
            }
        }
        else{
            $entityModeOperation = new ModeOperation();
        }

        $form = $this->createForm(ModeOperationType::class, $entityModeOperation);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $em->persist($entityModeOperation);
                $em->flush();

                $this->addFlash(
                    'success-toastr',
                    'Enregistrement effectué avec succès'
                );

                return $this->redirect($this->generateUrl('mode_operation_edit/{id}', array('id' => $entityModeOperation->getId())));
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
     * @Route("/suppr_mode_operation/{id}", name="mode_operation_delete/{id}")
     *
     */
    public function deleteModeOperationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityModeOperation = $em->getRepository('AppBundle:ModeOperation')->find($id);
        if (!$entityModeOperation) {
            throw $this->createNotFoundException('Mode d\'opération non trouvé');
        }

        try {
            $em->remove($entityModeOperation);
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
        return $this->redirectToRoute('mode_operation_liste', array(), 301);
    }

}
