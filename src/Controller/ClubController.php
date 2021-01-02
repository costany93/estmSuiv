<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Etudiant;
use App\Repository\ActivityRepository;
use App\Repository\ClubRepository;
use App\Repository\EtudiantRepository;
use App\Repository\InformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    public function __construct(ClubRepository $clubRepository,EntityManagerInterface $em,EtudiantRepository $er, InformationRepository $ir,ActivityRepository $activityRepository)
    {
        $this->clubRepository = $clubRepository;
        $this->em = $em;
        $this->er = $er;
        $this->ir = $ir;
        $this->activityRepository = $activityRepository;
    }
    /**
     * affiche les clubs
     * @Route("/club", name="club_index")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        $clubs = $this->clubRepository->findAll();
        return $this->render('club/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }

    /**
     * permet d'accéder à son club
     * @route("/club/{slug}", name="club_show")
     * @param Club $club
     * @return Response
     * @Security("(is_granted('ROLE_ETUDIANT') and user.getEtudiant().getClub() == club) or is_granted('ROLE_ADMIN')", message="Vous n'avez pas le droit d'accéder à ce club car ce n'est pas le votre")
     */
    public function show(Club $club){
        $user = $this->getUser();
        $informations = $this->ir->findBy(['club' => $club->getId()],['id' => 'DESC'],3,0);
        $activities = $this->activityRepository->findBy(['club' => $club->getId()],['id' => 'DESC'], 4,0);
        return $this->render('club/show.html.twig', [
            'club' => $club,
            'user' => $user,
            'informations' => $informations,
            'activities' => $activities
        ]);
    }

    /**
     * permet de voir tout les participants d'un clubs
     * @Route("/club/{slug}/participants", name="club_students")
     * @param Club $club
     * @return Response
     * @Security("(is_granted('ROLE_ETUDIANT') and user.getEtudiant().getClub() == club) or is_granted('ROLE_ADMIN')", message="Vous n'avez pas le droit d'accéder à ce club car ce n'est pas le votre")
     */
    public function allStudent(Club $club){

        //$etudiants = $this->er->findBy(['club_id' => $club->getId()]);
        return $this->render('club/students.html.twig', [
            'club' => $club,
        ]);
    }

    /**
     * permet à un étudiant d'adhérer à un club
     * @Route("/club/check/{id}", name="club_check_etudiant")
     * @param Etudiant $etudiant
     * @return Response
     * @Security("(is_granted('ROLE_PRESIDENT_CLUB') and user.getEtudiant().getClub() == etudiant.getClub()) or is_granted('ROLE_ADMIN')", message="Vous avez pas accès à cette ressources")
     */
    public function checkEtudiantClub(Etudiant $etudiant){
        $club = $etudiant->getMembership()->getClub();
        $adhesion = $etudiant->getMembership();
        //ici on met à jour les informations de l'étudiant
                $etudiant->setPersonne($etudiant->getPersonne())
                        ->setClasse($etudiant->getClasse())
                        ->setFiliere($etudiant->getFiliere())
                        ->setClub($club)
                ;
                $club->addEtudiant($etudiant);
                $this->em->persist($etudiant);
                $this->em->persist($club);

                $etudiantFictif = new Etudiant();
                $clubFictif = new Club();
                $adhesion->setEtudiant($etudiantFictif)
                        ->setClub($clubFictif)
                ;
                $this->em->remove($adhesion);

                $this->em->flush();

                $this->addFlash("success","Féliciation! ".$etudiant->getPersonne()->getFistname()." a rejoint le club ".$club->getNom());
        return $this->redirectToRoute('club_show', [
            'club' => $club,
            'user' => $etudiant->getPersonne(),
            'slug' => $club->getSlug()
        ]);
    }

    /**
     * permet de sortir d'un club
     * 	marechal.laure@live.com
     * @Route("/club/quit/{id}", name="club_quit_etudiant")
     * @param Etudiant $etudiant
     * @return Response
     * @Security("(is_granted('ROLE_PRESIDENT_CLUB') and user.getEtudiant().getClub() == etudiant.getClub()) or is_granted('ROLE_ADMIN')", message="Vous avez pas accès à cette ressources")
     */

     public function quit(Etudiant $etudiant){
                $adhesion = $etudiant->getMembership();
                $etudiant->setPersonne($etudiant->getPersonne())
                        ->setClasse($etudiant->getClasse())
                        ->setFiliere($etudiant->getFiliere())
                        ->setClub(null)
                ;
        $this->em->persist($etudiant);

        $etudiantFictif = new Etudiant();
        $clubFictif = new Club();
        $adhesion->setEtudiant($etudiantFictif)
                ->setClub($clubFictif)
        ;
        $this->em->remove($adhesion);
                $this->em->flush();
                $this->addFlash("warning","Vous avez acceptez de sortir ".$etudiant->getPersonne()->getFistname()." du club");
        $clubs = $this->clubRepository->findAll();
        return $this->redirectToRoute('club_index',['clubs' => $clubs]);
     }
}
