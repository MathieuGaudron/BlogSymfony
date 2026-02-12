<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/posts/{id}/comment', name: 'post_add_comment', methods: ['POST'])]
    public function add(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isCsrfTokenValid('add_comment_'.$post->getId(), (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_home');
        }

        $content = trim((string) $request->request->get('content'));
        if ($content === '') {
            $this->addFlash('error', 'Commentaire vide.');
            return $this->redirectToRoute('app_home');
        }

        $comment = new Comment();
        $comment->setContent($content);
        $comment->setPost($post);
        $comment->setAuthor($this->getUser());

        if (method_exists($comment, 'setCreatedAt')) {
            $comment->setCreatedAt(new \DateTimeImmutable());
        }

        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
}