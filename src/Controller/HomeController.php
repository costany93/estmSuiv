<?php

namespace App\Controller;

use App\Repository\InformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
   public function __construct(InformationRepository $infRep)
    {
        $this->infRep = $infRep;
    }
    /**
     * @Route("/", name="home_index")
     */
    public function index(): Response
    {
        $information = $this->infRep->findBy([],['id' => 'DESC'], 6,0);
        return $this->render('home/index.html.twig', [
            'informations' => $information,
        ]);
    }
}
