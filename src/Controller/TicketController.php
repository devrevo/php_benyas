<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ticket;
use App\Entity\Personel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\PersonelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TicketController extends AbstractController
{
    /**
     * @Route("/", name="ticket_list")
     */
    public function index() {
      if($this->getUser()== null)
      {
        return $this->render('security/login.html.twig');

      }else
      {
        $tickets= $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        return $this->render('ticket/index.html.twig', [
          'tickets' => $tickets
          ]);
      }
    }
    
    /**
     * @Route("/ticket/new", name="new_ticket")
     */
    public function new(Request $request) {
        $ticket = new Ticket();
  
        $form = $this->createFormBuilder($ticket)
          ->add('Titre', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('Description', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))
          ->add('Priorite', ChoiceType::class, array(
            'choices'  => array(
                'Basse' => 'Basse',
                'Normale' => 'Normale',
                'Elevee' => 'Elevee',
            ),
            ))
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $ticket = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $ticket -> setDatecreation(new \DateTime('@'.strtotime('now')));
          $ticket -> setStatut("Nouveau");
          $entityManager->persist($ticket);
          $entityManager->flush();
  
          return $this->redirectToRoute('ticket_list');
        }
  
        return $this->render('ticket/new.html.twig', array(
          'form' => $form->createView()
        ));
      }
  
      /**
       * @Route("/ticket/edit/{id_ticket}", name="edit_ticket")
       */   
      public function edit(Request $request, $id_ticket) {
        $ticket = new Ticket();
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id_ticket);
  
        $form = $this->createFormBuilder($ticket)
          ->add('titre', TextType::class, array(
            'attr' => array('class' => 'form-control')
          ))
          ->add('Description', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))
          ->add('Priorite', ChoiceType::class, array(
            'choices'  => array(
                'Basse' => 'Basse',
                'Normale' => 'Normale',
                'Elevee' => 'Elevee',
            ),
            ))
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('ticket_list');
        }
  
        return $this->render('ticket/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }
  
      /**
       * @Route("/ticket/{id_ticket}", name="ticket_show")
       */
      public function show($id_ticket) {
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id_ticket);
  
        return $this->render('ticket/show.html.twig', array('ticket' => $ticket));
      }
  
      /**
       * @Route("/ticket/delete/{id_ticket}")
       * @Method({"DELETE"})
       */
      public function delete(Request $request, $id_ticket) {
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id_ticket);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($ticket);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('ticket_list');
    }

      /**
       * @Route("/ticket/affect/{id_ticket}", name="affect")
       * Method({"GET", "POST"})
       */   
      public function affect(Request $request, $id_ticket) {
        $ticket = new Ticket();
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->find($id_ticket);
  
        $form = $this->createFormBuilder($ticket)
            
    
       
          ->add('matricule', ChoiceType::class, [
            'choices' => $this->personelRepository->findBy($id_ticket),
          ])
          
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('ticket_list');
        }
  
        return $this->render('ticket/affectation.html.twig', array(
          'form' => $form->createView()
        ));
      }
      

}


      