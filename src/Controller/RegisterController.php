<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\Registration\Service;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/register", name="user-register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        VerifyEmailHelperInterface $verifyEmailHelper
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Rejestracja przebiegła pomyślnie!');
            $signatureComponents = $verifyEmailHelper->generateSignature(
                'registration_confirmation_route',
                (string) $user->getId(),
                $user->getEmail()
            );

            $view = $this->renderView(
                'registration/confirmation_email.html.twig',
                ['signedUrl' => $signatureComponents->getSignedUrl()]
            );
            $email = (new Email())
                ->from('wsb.projekt.z.glowa@gmail.com')
                ->to($user->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Potwierdź adres e-mail')
                ->text($view)
                ->html($view)
            ;

            $transport = new GmailSmtpTransport('wsb.projekt.z.glowa@gmail.com', 'Zglowa321@');
            $mailer = new Mailer($transport);

            $mailer->send($email);
        } else {
            /** @var FormError $error */
            foreach ($form->getErrors() as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/verify", name="registration_confirmation_route")
     */
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        // Do not get the User's Id or Email Address from the Request object.
        try {
            $verifyEmailHelper->validateEmailConfirmation($request->getUri(), (string) $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('verify_email_error', $e->getReason());

            return $this->redirectToRoute('app_register');
        }

        $em = $this->getDoctrine()->getManager();
        $user->addRole("ROLE_USER_CONFIRMED");
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Twój email został potwierdzony!');

        return $this->redirectToRoute('home');
    }
}
