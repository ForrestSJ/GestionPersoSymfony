<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Form\CategorieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    /**
     * @Route("/categories", name="categorie_liste")
     * @Template()
     */
    public function getCategorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entitiesCategorie = $em->getRepository('AppBundle:Categorie')->findAll();
        return array(
            'entitiesCategorie' => $entitiesCategorie,
        );
    }

    /**
     * @Route("/categorie", name="categorie_create")
     * @Route("/categorie/{id}", name="categorie_edit/{id}")
     * @Template()
     */
    public function editCategorieAction(Request $request, $id = 0)
    {
        $em = $this->getDoctrine()->getManager();

        if ($id > 0){
            $entityCategorie = $em->getRepository('AppBundle:Categorie')->find($id);
            if (!$entityCategorie) {
                throw $this->createNotFoundException('Catégorie non trouvée');
            }
        }
        else{
            $entityCategorie = new Categorie();
        }

        $form = $this->createForm(CategorieType::class, $entityCategorie);

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $em->persist($entityCategorie);
                $em->flush();

                $this->addFlash(
                    'success-toastr',
                    'Enregistrement effectué avec succès'
                );

                return $this->redirect($this->generateUrl('categorie_edit/{id}', array('id' => $entityCategorie->getId())));
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
     * @Route("/supprcategorie/{id}", name="categorie_delete/{id}")
     *
     */
    public function deleteCategorieAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

            $entityCategorie = $em->getRepository('AppBundle:Categorie')->find($id);
            if (!$entityCategorie) {
                throw $this->createNotFoundException('Catégorie non trouvée');
            }

        try {
            $em->remove($entityCategorie);
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
        return $this->redirectToRoute('categorie_liste', array(), 301);
    }

}
