<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/comments')]
class CommentAdminController extends AbstractController
{
    #[Route('', name: 'admin_comments_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('comment_admin/index.html.twig', [
            'pending' => $commentRepository->findBy(['isActive' => false], ['id' => 'DESC']),
            'approved' => $commentRepository->findBy(['isActive' => true], ['id' => 'DESC']),
        ]);
    }

    #[Route('/{id}/approve', name: 'admin_comments_approve', methods: ['POST'])]
    public function approve(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (!$this->isCsrfTokenValid('approve_comment_'.$comment->getId(), (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('admin_comments_index');
        }

        $comment->setIsActive(true);
        $em->flush();

        $this->addFlash('success', 'Commentaire approuvé.');
        return $this->redirectToRoute('admin_comments_index');
    }

    #[Route('/{id}/reject', name: 'admin_comments_reject', methods: ['POST'])]
    public function reject(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (!$this->isCsrfTokenValid('reject_comment_'.$comment->getId(), (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('admin_comments_index');
        }

        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', 'Commentaire refusé (supprimé).');
        return $this->redirectToRoute('admin_comments_index');
    }
}