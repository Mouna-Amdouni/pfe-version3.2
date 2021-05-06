<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
     {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
      if ($form->isSubmitted() && $form->isValid()) {

          $contactFormData = $form->getData();
          $message = (new \Swift_Message('Vous avez un email'))
               ->setFrom($contactFormData['email'])
               ->setTo('skander5majdoub@gmail.com')
               ->setBody(
                   $contactFormData['message'],
                   'text/plain'
               )
           ;

           $mailer->send($message);
           $this->addFlash('success', 'Votre message a été envoyé!');
           return $this->redirectToRoute('contact');

           dump($contactFormData);

           // do something interesting here
       }
        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView(),
            ]);
    }
}
