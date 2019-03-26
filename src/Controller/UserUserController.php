<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\PassChanger;
use App\Form\MeUserType;
use App\Form\MeUserPassType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/me/user")
 */
class UserUserController extends AbstractController
{


    /**
     * @Route("/", name="self_user_show", methods="GET")
     * @return Response
     */
    public function show(): Response
    {
        $user = $this->getUser();
        return $this->render('me_user/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/edit", name="self_user_edit", methods="GET|POST")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(MeUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('self_user_edit', [
            ]);
        }

        return $this->render('me_user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/change_pass", name="self_user_change_pass", methods="GET|POST")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $passChanger = new PassChanger();
        $form = $this->createForm(MeUserPassType::class, $passChanger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($passChanger->getNewPassword() == $passChanger->getNewPassword2()) {
                $user = $this->getUser();
                $plainPassword = $passChanger->getNewPassword();
                $encoded = $encoder->encodePassword($user, $plainPassword);
                $user->setPassword($encoded);

                $this->getDoctrine()
                    ->getManager()
                    ->flush();

                $this->addFlash('success', 'Password changed.');
            } else {
                $this->addFlash('danger', 'New passwords not match.');
            }
            return $this->redirectToRoute('self_user_change_pass', [
            ]);
        }

        return $this->render('me_user/change_pass.html.twig', [
            'passChanger' => $passChanger,
            'form' => $form->createView()
        ]);
    }

}
