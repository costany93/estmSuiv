<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Information;
use App\Form\InformationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class InformationController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/information", name="information")
     */
    public function index(): Response
    {
        return $this->render('information/index.html.twig', [
            'controller_name' => 'InformationController',
        ]);
    }

    /**
     * permet d'ajouter un information relatif à un club
     * @Route("/information/{slug}/add", name="information_add")
     * @param Club $club
     * @return Response
     * @Security("(is_granted('ROLE_ETUDIANT') and user.getEtudiant().getClub() == club) or is_granted('ROLE_ADMIN')", message="Vous n'avez pas le droit d'accéder à ce club car ce n'est pas le votre")
     */
    public function add(Club $club,Request $request){
        $information = new Information();
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $information->setClub($club);
            $this->em->persist($information);
            $this->em->flush();

            $this->addFlash("success","Information ajouté avec succes, il defilera sur le fil des actualités");

            return $this->redirectToRoute("club_show",[
                'slug' => $club->getSlug()
            ]);
        }
        return $this->render('information/add.html.twig', [
            'club' => $club,
            'form' => $form->createView()
        ]);
    }
}
