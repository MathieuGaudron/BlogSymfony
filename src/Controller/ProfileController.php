<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('profile/index.html.twig');
    }

    #[Route('/profile/posts', name: 'app_profile_posts')]
    public function myPosts(PostRepository $postRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        $posts = $postRepository->findBy(
            ['author' => $user],
            ['publishedAt' => 'DESC']
        );

        return $this->render('profile/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/profile/infos', name: 'app_profile_infos')]
    public function myInfos(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('profile/infos.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile/infos/edit', name: 'app_profile_infos_edit')]
    public function editInfos(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Infos mises à jour');
            return $this->redirectToRoute('app_profile_infos');
        }

        return $this->render('profile/edit_infos.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
