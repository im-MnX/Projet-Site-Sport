<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $telephone = $request->request->get('telephone');
            $sujet = $request->request->get('sujet');
            $message = $request->request->get('message');

            $emailMessage = (new Email())
                ->from('site@activite-sport.fr') // Sender address (configured in env usually, but this is fine for now)
                ->to('LuCtiNy29@outlook.fr')
                ->subject('Nouveau message de contact : ' . $sujet)
                ->text("Nom: $nom\nEmail: $email\nTéléphone: $telephone\n\nMessage:\n$message")
                ->html("
                    <h3>Nouveau message de contact</h3>
                    <p><strong>Nom:</strong> $nom</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Téléphone:</strong> $telephone</p>
                    <p><strong>Sujet:</strong> $sujet</p>
                    <hr>
                    <p><strong>Message:</strong><br>$message</p>
                ");

            try {
                $mailer->send($emailMessage);
                $this->addFlash('success', 'Votre message a bien été envoyé !');
            } catch (\Exception $e) {
                $this->addFlash('error', "Une erreur est survenue lors de l'envoi du message : " . $e->getMessage());
            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
