<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Etudiant;
use App\Entity\Participation;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ParticipationController extends AbstractController
{
    public function __construct(EntityManagerInterface $em,ClubRepository $clubRepository)
    {
        $this->em = $em;
        $this->clubRepository = $clubRepository;
    }
    /**
     * permet demander une participation à un club
     * @Route("/participation/{id}/new", name="participation_new")
     * @param Activity $activity
     * @return Response
     *  @Security("(is_granted('ROLE_ETUDIANT') and user.getEtudiant().getClub() == activity.getClub()) or is_granted('ROLE_ADMIN')", message="Vous n'avez pas le droit d'accéder à ce club car ce n'est pas le votre")
     */
    public function new(Activity $activity): Response
    {
        $etudiant = $this->getUser()->getEtudiant();

        $participation = new Participation();

        $participation->setActivity($activity)
                    ->setEtudiant($etudiant)
                ;
        $this->em->persist($participation);
        $this->em->flush();

        $this->addFlash('success','Vous avez demandez à participé');
        return $this->redirectToRoute('activity_index',[
            'slug' =>$etudiant->getClub()->getSlug()
        ]);
    }

    /**
     * permet d'afficher toutes les participations à une activité d'un club
     * @Route("/participation/{id}/all", name="participation_index")
     * @param Activity $activity
     * @return Response
     *  @Security("(is_granted('ROLE_PRESIDENT_CLUB') and user.getEtudiant().getClub() == activity.getClub()) or is_granted('ROLE_ADMIN')", message="Vous n'avez pas le droit d'accéder à cette ressource")
     */
    public function index(Activity $activity){

        $club = $activity->getClub();
        return $this->render('participation/index.html.twig',[
            'club' => $club,
            'activity' => $activity
        ]);
    }

    /**
     * permet de valider une participation
     * @Route("/participation/{id}/check", name="participation_validate")
     * @param Participation $participation
     * @return Response
     */
    public function validate(Participation $participation){
        
        $participation->setState(true);
        $etudiant = $participation->getEtudiant()->getPersonne();
        $this->em->persist($participation);
        $this->em->flush();

        $this->addFlash("success","Vous avez validé la participation de ".$etudiant->getFistname()." ".$etudiant->getLastname());
        return $this->redirectToRoute('participation_index',[
            'id' => $participation->getActivity()->getId()
        ]);
    }
    /**
     * permet de valider une participation
     * @Route("/participation/{id}/invalidate", name="participation_invalidate")
     * @param Participation $participation
     * @return Response
     */
    public function invalidate(Participation $participation){
        
        $participation->setState(false);
        $this->em->persist($participation);
        $this->em->flush();
        $etudiant = $participation->getEtudiant()->getPersonne();
        $this->addFlash("danger","Vous avez invalidé la participation ".$etudiant->getFistname()." ".$etudiant->getLastname());
        return $this->redirectToRoute('participation_index',[
            'id' => $participation->getActivity()->getId()
        ]);
    }
}
