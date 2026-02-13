<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $comments = [
            ['Super screen', '2026-02-12 09:27:30', UserFixtures::USER_PONCH, PostFixtures::POST_1],
            ['Jolie', '2026-02-12 09:29:16', UserFixtures::USER_MELL, PostFixtures::POST_1],
            ['Un MONSTRE !', '2026-02-12 15:38:25', UserFixtures::USER_TEST, PostFixtures::POST_3],
            ['WAAAW TROP BG MON CHOUCHOU', '2026-02-13 07:47:48', UserFixtures::USER_JULIE, PostFixtures::POST_2],
            ['Maxi bg Mell marie moi', '2026-02-13 07:48:47', UserFixtures::USER_KENZA, PostFixtures::POST_2],
        ];

        foreach ($comments as [$content, $created, $authorRef, $postRef]) {
            $c = new Comment();
            $c->setContent($content);
            $c->setCreatedAt(new \DateTimeImmutable($created));
            $c->setIsActive(true);

            $c->setAuthor($this->getReference($authorRef, User::class));
            $c->setPost($this->getReference($postRef, Post::class));

            $manager->persist($c);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            PostFixtures::class,
        ];
    }
}
