<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $comments = [
            // id 1
            ['Super screen', '2026-02-12 09:27:30', UserFixtures::USER_PONCH, PostFixtures::POST_1],
            // id 2
            ['Jolie', '2026-02-12 09:29:16', UserFixtures::USER_MELL, PostFixtures::POST_1],
            // id 4
            ['Un MONSTRE !', '2026-02-12 15:38:25', UserFixtures::USER_TEST, PostFixtures::POST_3],
            // id 6
            ['WAAAW TROP BG MON CHOUCHOU', '2026-02-13 07:47:48', UserFixtures::USER_JULIE, PostFixtures::POST_2],
            // id 7
            ['Maxi bg Mell marie moi', '2026-02-13 07:48:47', UserFixtures::USER_KENZA, PostFixtures::POST_2],
        ];

        foreach ($comments as [$content, $created, $authorRef, $postRef]) {
            $c = new Comment();
            $c->setContent($content);
            $c->setCreatedAt(new \DateTimeImmutable($created));
            $c->setIsActive(true);

            $c->setAuthor($this->getReference($authorRef));
            $c->setPost($this->getReference($postRef));

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
