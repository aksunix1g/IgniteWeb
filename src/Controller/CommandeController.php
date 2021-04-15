<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('commande/shows.html.twig', [
            'controller_name' => 'CommandeController',
        ]);


    }

    /**
     * @Route("/delete-commande", name="delete-commande")
     */
    public function deleteCommande(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $Commande = $this->getDoctrine()->getRepository(Commande::class)->find(
                $request->request->getInt('command')
            );
            if ($Commande instanceof Commande && $Commande != null) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($Commande);
                $manager->flush();
                return new JsonResponse(array('operation' => 'succes'));

            } else {
                return new JsonResponse(array('operation' => 'failure'));
            }
        } else return new Response('please use ajax');
    }

    /**
     * @Route("/show-commandes", name="show-commandes")
     */
    public function showCommandes()
    {
        $commande = $this->getDoctrine()
            ->getRepository('App\Entity\Commande')
            ->findAll();

        return $this->render(
            'commande/shows.html.twig',
            array('commandes' => $commande)
        );
    }

    /**
     * @Route("/update-commande/id", name="update-commande")
     */
    public function updateCommande(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('App\Entity\Commande')->find($id);

        if (!$commande) {
            throw $this->createNotFoundException(
                'There are no commandes with the following id: ' . $id
            );
        }

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $commande = $form->getData();
            $em->flush();
            return $this->redirect('/view-commande/' . $id);
        }

        return $this->render(
            'edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/create-commande", name="create-commande")
     */
    public function createCommande(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $commande = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirect('/view-commande/' . $commande->getId());

        }

        return $this->render(
            'create.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/view-commande/id", name="view-commande")
     */
    public function viewCommande($id)
    {
        $commande = $this->getDoctrine()
            ->getRepository('App\Entity\Commande')
            ->find($id);

        if (!$commande) {
            throw $this->createNotFoundException(
                'There are no commandes with the following id: ' . $id
            );
        }

        return $this->render(
            'view.html.twig',
            array('commande' => $commande)
        );
    }


    /**
     * @Route("/valider-commande/{id}", name="valider-commande")
     */
    public function validationCommande($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('App\Entity\Commande')->find($id);
        $commande->setValide(1);
        $em->flush();
        $this->addFlash(
            'info',
            'Valider Avec Succès'
        );
        $this->getDoctrine()->getManager()->flush();



        return $this->redirectToRoute('show-commandes');



    }

}