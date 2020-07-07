<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Compte;
use App\Form\LoginFormType;
use App\Form\ClientFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     * 
     */
    public function login()
    {
        return $this->render('security/login.html.twig'); 
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }

     /**
     * @Route("/register", name="registration")
     */
    public function register(Request $request,ManagerRegistry $managerRegistry,UserPasswordEncoderInterface $encoder)
    {
        $compte = new Compte();
        $client = new Client();
        $formCompte = $this->createForm(LoginFormType::class,$compte);
        $formClient = $this->createForm(ClientFormType::class,$client);
        $manager = $managerRegistry->getManager();

        $formClient->handleRequest($request);
        $formCompte->handleRequest($request);
        if($formClient->isSubmitted() && $formClient->isValid()){
            
            $client->setRole('Client');
            $manager->persist($client);
            $manager->flush();
            
            if($formCompte->isSubmitted() && $formCompte->isValid())
            {
                $compte->setClient($client);
                $hash = $encoder->encodePassword($compte,$compte->getPassword());
                $compte->setPassword($hash);
                $manager->persist($compte);
                $manager->flush();
            }

            return $this->redirectToRoute('security_login');
        }
 
        return $this->render('security/register.html.twig',[
            'formCompte' => $formCompte->createView(),
            'formClient' => $formClient->createView()
    ]);
    }
}

