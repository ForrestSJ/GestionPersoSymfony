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
                    'danger',
                    'Une erreur s\'est produite lors de l\'enregistrement'
                );
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

}
