<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{

    /**
     * @Route("/about", name="about")
     */
    public function about(Request $request, \Swift_Mailer $mailer)
    {


        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $message = (new \Swift_Message('You Got Mail!'))
                ->setFrom($contactFormData['email'])
                ->setTo('r.vandegraaf45@gmail.com')
                ->setBody(
                    $this->renderView('email/index.html.twig', $contactFormData),
                    'text/html');


            $mailer->send($message);

            $this->addFlash('success', 'Het bericht is verzonden');

            return $this->redirectToRoute('about');
        }

        return $this->render('about/index.html.twig', [
            'our_form' => $form->createView(),
        ]);


    }
}
