<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(
        Request $request,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $categoryId = $request->query->get('category'); 

        $criteria = [];
        if ($categoryId) {
            $criteria['category'] = (int) $categoryId;
        }

        $posts = $postRepository->findBy($criteria, ['publishedAt' => 'DESC']);
        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
        ]);
    }
}