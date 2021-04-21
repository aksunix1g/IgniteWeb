<?php


namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('OMG MY F PAGE ALREADY');
    }

}