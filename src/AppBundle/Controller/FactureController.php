<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Facture;
use AppBundle\Entity\FactureLigne;
use AppBundle\Form\FactureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FactureController extends Controller
{
    /**
     * @Route("/factures", name="facture_liste")
     * @Template()
     */
    public function getFacturesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entitiesFacture = $em->getRepository('AppBundle:Facture')->findAll();
        return array(
            'entitiesFacture' => $entitiesFacture,
        );
    }

    /**
     * @Route("/facture", name="facture_create")
     * @Route("/facture/{id}", name="facture_edit/{id}")
     * @Template()
     */
    public function editFactureAction(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0){
            $entityFacture = $em->getRepository('AppBundle:Facture')->find($id);
            if (!$entityFacture) {
                throw $this->createNotFoundException('Opération non trouvée');
            }
        }
        else{
            $entityFacture = new Facture();
        }

        $form = $this->createForm(FactureType::class, $entityFacture);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $em->persist($entityFacture);
                $em->flush();

                $this->addFlash(
                    'success-toastr',
                    'Enregistrement effectué avec succès'
                );

                return $this->redirect($this->generateUrl('facture_edit/{id}', array('id' => $entityFacture->getId())));
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger-toastr',
                    'Une erreur s\'est produite lors de l\'enregistrement'
                );
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/suppr_facture/{id}", name="facture_delete/{id}")
     *
     */
    public function deleteFactureAction(Request $request, $id)
    {
        $suppressionPossible = true;
        $em = $this->getDoctrine()->getManager();

        $entityFacture = $em->getRepository('AppBundle:Facture')->find($id);
        if (!$entityFacture) {
            throw $this->createNotFoundException('Facture non trouvée');
        }

        // Vérifie qu'il n'y a rien d'associé à la facture
        $entitiesLigne = $em->getRepository('AppBundle:FactureLigne')->findBy(
            array(
                'facture' => $entityFacture
            )
        );
        if(count($entitiesLigne) > 0){
            $suppressionPossible = false;
            $this->addFlash(
                'danger-toastr',
                'Suppression impossible : il existe des lignes'
            );
        }

        $entitiesFidelite = $em->getRepository('AppBundle:FactureFidelite')->findBy(
            array(
                'facture' => $entityFacture
            )
        );
        if(count($entitiesFidelite) > 0){
            $suppressionPossible = false;
            $this->addFlash(
                'danger-toastr',
                'Suppression impossible : il existe des lignes de fidélité'
            );
        }

        $entitiesOperation = $em->getRepository('AppBundle:Operation')->findBy(
            array(
                'facture' => $entityFacture
            )
        );
        if(count($entitiesOperation) > 0){
            $suppressionPossible = false;
            $this->addFlash(
                'danger-toastr',
                'Suppression impossible : il existe des opérations associées'
            );
        }

        if($suppressionPossible){
            try {
                $em->remove($entityFacture);
                $em->flush();

                $this->addFlash(
                    'success-toastr',
                    'Suppression effectuée avec succès'
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger-toastr',
                    'Une erreur s\'est produite lors de la suppression : ' . $e
                );
            }
        }
        return $this->redirectToRoute('facture_liste', array(), 301);
    }

}
