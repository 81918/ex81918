<?php

namespace App\Controller;

use App\Entity\Poule;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("admin/user")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="user_index")
     */
    public function index(UserRepository $userRepository) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add_user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new Email())
                ->from('kelvinjwz14@gmail.com')
                ->to(new Address($form->get('Email')->getData()))
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Important Notification')
                ->html('
<h1>Bedankt voor het meedoen aan onze voorspellings poule</h1>
<table>
    <tr>
    <td>Username: </td>
    <td>'. $user->getUsername() .'</td>
    </tr>
    <tr>
        <td>Wachtwoord: </td>
        <td>'. $form->get('plainPassword')->getData() .'</td>
    </tr>
</table>
                ');

            // verzend email
            $transport = new GmailSmtpTransport($_SERVER['EMAIL'], $_SERVER['EMAIL_PASSWORD']);
            $mailer = new Mailer($transport);
            $mailer->send($email);

            // weergeef melding
            $this->addFlash(
                'success',
                'User: ' . $user->getUsername(). 'is toegevoegd!'
            );
            return $this->redirectToRoute('add_user');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete")
     */
    public function delete(Request $request, Poule $poule): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poule->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($poule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poule_index');
    }
}
