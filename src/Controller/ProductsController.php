<?php

namespace App\Controller;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function index(): Response
    {  $produits = $this->getDoctrine()
        ->getRepository(Produit::class)
        ->findAll();
        return $this->render('client/products.html.twig', [
            'controller_name' => 'ProductsController', 'produit'=>$produits
        ]);
    }



    /**
     * @Route("/affiche/{idproduit}", name="affichew" , methods={"GET"})
     *
     */

    public function show($idproduit): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produit::class);

        $aux = $produits->findOneBy(array('idproduit' => $idproduit));


        return $this->render('client/wdetails.html.twig', [
            'controller_name' => 'ProductsController',
            'produit' => $produits, 'aux' => $aux,

        ]);


    }
  
}
