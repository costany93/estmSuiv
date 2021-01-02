<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Role;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\EtudiantType;
use App\Repository\RoleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder,RoleRepository $roleRepository)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->roleRepository = $roleRepository;
    }
    /**
     * permet d'ajouter un utilisateur
     * @Route("/account/create", name="account_create")
     */
    public function create(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $this->encoder->encodePassword($user, $user->getHashPassword());
            $user->setHashPassword($password);
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash("success", "Utilisateur ajouter avec success");
            return $this->redirectToRoute('home_index');
        }
        return $this->render('account/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * permet d'ajouter un nouvel étudiant
     * @Route("/account/etudiant", name="account_create_etudiant")
     */
    public function createEtudiant(Request $request): Response
    {
        //récupération du role étudiant
        $role = $this->roleRepository->findOneBy(['title' => 'ROLE_ETUDIANT']);
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $fistname = $request->request->get('etudiant')['fistname'];
            $lastname = $request->request->get('etudiant')['lastname'];
            $sexe = $request->request->get('etudiant')['sexe'];
            $dateNaiss = $request->request->get('etudiant')['dateNaiss'];
            $email = $request->request->get('etudiant')['email'];
            $phone = $request->request->get('etudiant')['phone'];
            $hash = $request->request->get('etudiant')['hashPassword'];
            $date = DateTime::createFromFormat('Y-m-d', '2020-12-12');
            /*dump($dateNaiss);
            die();*/
            $user = new User();
            
            $password = $this->encoder->encodePassword($user, $hash);
            $user->setFistname($fistname)
                ->setLastname($lastname)
                ->setSexe($sexe)
                ->setDateNaiss(new DateTime())
                ->setEmail($email)
                ->setPhone($phone)
                ->setHashPassword($password)
                ->addUserRole($role)
            ;
            $this->em->persist($user);

            $etudiant->setPersonne($user);
            $this->em->persist($etudiant);
            $this->em->flush();

            $this->addFlash("success", "Etudiant ajouter avec success");
            return $this->redirectToRoute('home_index');
        }
        return $this->render('account/createEtudiant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * permet de se connecter
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils){
        $error = $utils->getLastAuthenticationError();
        $lastname = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error != null,
            'lastname' => $lastname
        ]);
    }
    /**
     * permet de se déconnecter
     * @Route("/logout", name="account_logout")
     */
    public function logout(){
        
    }
}
