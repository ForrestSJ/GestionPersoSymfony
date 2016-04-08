<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Compte;
use AppBundle\Form\CompteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompteController extends Controller
{
    /**
     * @Route("/comptes", name="compte_liste")
     * @Template()
     */
    public function getCompteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entitiesCompte = $em->getRepository('AppBundle:Compte')->findAll();
        return array(
            'entitiesCompte' => $entitiesCompte,
        );
    }

    /**
     * @Route("/compte", name="compte_create")
     * @Route("/compte/{id}", name="compte_edit/{id}")
     * @Template()
     */
    public function editCompteAction(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0){
            $entityCompte = $em->getRepository('AppBundle:Compte')->find($id);
            if (!$entityCompte) {
                throw $this->createNotFoundException('Compte non trouvée');
            }
        }
        else{
            $entityCompte = new Compte();
        }

        $form = $this->createForm(CompteType::class, $entityCompte);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $em->persist($entityCompte);
                $em->flush();

                $this->addFlash(
                    'success-toastr',
                    'Enregistrement effectué avec succès'
                );

                return $this->redirect($this->generateUrl('compte_edit/{id}', array('id' => $entityCompte->getId())));
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
     * @Route("/supprcompte/{id}", name="compte_delete/{id}")
     *
     */
    public function deleteCompteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entityCompte = $em->getRepository('AppBundle:Compte')->find($id);
        if (!$entityCompte) {
            throw $this->createNotFoundException('Compte non trouvé');
        }

        try {
            $em->remove($entityCompte);
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
        return $this->redirectToRoute('compte_liste', array(), 301);
    }

}
