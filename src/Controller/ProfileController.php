<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}