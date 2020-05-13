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
        // stuur user naar inlog als hij niet de goede rol heeft
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // render template
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add_user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        // stuur user naar inlog als hij niet de goede rol heeft
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // maak een nieuwe user aan en maak daar van een form
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // check of het is op gestuurd is en klopt
        if ($form->isSubmitted() && $form->isValid()) {

            // encode the onaangepaste password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // laat doctrine user opslaan
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // verstuur mail
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

            // render redirect
            return $this->redirectToRoute('add_user');
        }

        // render form
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete")
     */
    public function delete(Request $request, Poule $poule): Response
    {
        // check of crsf token klopt
        if ($this->isCsrfTokenValid('delete'.$poule->getId(), $request->request->get('_token'))) {

            // laat doctrine het verwijderen
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($poule);
            $entityManager->flush();
        }

        // redirect 
        return $this->redirectToRoute('poule_index');
    }
}
