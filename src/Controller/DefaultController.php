<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/ajax/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): JsonResponse
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');

        $email = (new Email())
            ->from($email)
            ->to("public.quentin.0101@gmail.com")
            ->priority(Email::PRIORITY_HIGHEST)
            ->subject("contact site web : ".$subject)
            ->text("name: ".$name."         email: ".$email."       content: ".$message);

        $mailer->send($email);


        $this->addFlash('success', "Mail bien envoyé");
        return new JsonResponse(['error' => []], 200);

    }
}
