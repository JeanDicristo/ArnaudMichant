<?php

namespace App\Controller;

use App\Entity\ProfilUser;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Ce contrôleur nous permet de nous connecter
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
    /**
     *  Ce contrôleur nous permet de nous déconnecter
     *
     * @return void
     */
    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
        // Rien a faire ici 
    }

    /**
 *  Ce contrôleur nous permet de nous enregistré
 *
 * @param Request $request
 * @param EntityManagerInterface $manager
 * @return Response
 */
#[Route('/inscription', 'security.registration',  methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager) : Response 
    {
        $user = new ProfilUser();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->addFlash(
                'success',
                'Votre compte a bien été créer'
            );

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security.login');
        }
        
        return $this->render('pages/security/registration.html.twig', [
                'form' => $form->createView()
        ]) 
        ;
    }
}
