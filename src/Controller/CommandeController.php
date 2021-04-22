<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping\Entity;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

//mailing
//require_once ('C:\Users\Dali\PhpstormProjects\Pidev\vendor\phpmailer');

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('template.html.twig', [
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
        $this->getDoctrine()->getManager()->flush();

        //mailing
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = 'mohamedali.omri@esprit.tn';
        $mail->Password = 'omriiT9141';
        $mail->SetFrom('no-reply@ignite.tn');
        $mail->Subject = 'IGNITE service client';
        $mail->Body = 'Votre Commande est validé';
        $mail->addAddress('omrixo.dali97@gmail.com');
        $mail->send();


        return $this->redirectToRoute('show-commandes');
    }

    /**
     * @Route("/cart/checkout", name="getCartInfo")
     */
    public function renderCart(){
        return $this->render('commande/cart.html.twig');
    }


    /**
     * @Route("/create-order", name="createOrderAjax")
     */
    public function createOrder(Request $request){
        // si la requete est de type ajax
        if ($request->isXmlHttpRequest()){

            $commande=new Commande();
            $commande->setPrixtotale((float)$request->request->get('total'));
            $commande->setValide(0);
            $commande->setDatecom(new \DateTime('now'));

            $user=$this->getDoctrine()->getRepository(user::class)->find(1);

            $commande->setUser($user);
            $this->getDoctrine()->getManager()->persist($commande);
            $products=$request->request->get('products');
            foreach ($products as $single)
            {
                $product=$this->getDoctrine()->getRepository(Produit::class)->find((int)$single["id"]);

                $commande->addProduit($product);
                $this->getDoctrine()->getManager()->flush();


            }
            //mailing
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->isHTML();
            $mail->Username = 'mohamedali.omri@esprit.tn';
            $mail->Password = 'omriiT9141';
            $mail->SetFrom('no-reply@ignite.tn');
            $mail->Subject = 'IGNITE service client';
            $mail->Body = 'Votre Commande est bien enregistrer, merci';
            $mail->addAddress('omrixo.dali97@gmail.com');
            $mail->send();

            $this->getDoctrine()->getManager()->persist($commande);
            return new JsonResponse(array('operation'=>'success'));
        }
        else return new Response('please use ajax');
    }

    public function showProduct(){

        $em= $this->getDoctrine()->getManager();
        $Product =$em->getRepository('App\Entity\Produit')->findAll();

        return $this->render('commande/shop-grid.html.twig',array(
            'Products'=> $Product));
    }

    /**
     * @Route("/create-pdf", name="createPdf")
     */
    public function pdf()
    {
        //$dompdf -> loadHtml("<img src='images/icon.png'>");

        $commande = $this->getDoctrine()
            ->getRepository('App\Entity\Commande')
            ->findAll();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($commande);


        $html = $this->renderView('commande/mypdf.html.twig',array(
            'commandes'=> $commande));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
    /**
     * @Route("/create-pdfPanier", name="createPdfPanier")
     */
    public function pdfPanier()
    {
        //$dompdf -> loadHtml("<img src='images/icon.png'>");

        $commande = $this->render('commande/cart.html.twig');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($commande);


        $html = $this->renderView('commande/panierPdf.html.twig',array(
            'commandes'=> $commande));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }



}