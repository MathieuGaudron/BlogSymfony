<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public const POST_1 = 'post_1';
    public const POST_2 = 'post_2';
    public const POST_3 = 'post_3';

    public function load(ObjectManager $manager): void
    {

        $p1 = new Post();
        $p1->setTitle('DOFUS RETRO');
        $p1->setContent('Screenshot sadida pandala');
        $p1->setPublishedAt(new \DateTimeImmutable('2026-02-12 09:05:31'));
        $p1->setPicture('Capture-d-ecran-2026-01-31-214723-698d97db1e81f.png');
        $p1->setAuthor($this->getReference(UserFixtures::USER_PONCH));
        $p1->setCategory($this->getReference(CategoryFixtures::CAT_JEU_VIDEO));
        $manager->persist($p1);
        $this->addReference(self::POST_1, $p1);

        $p2 = new Post();
        $p2->setTitle('Mr. Canac  BD');
        $p2->setContent('Le plus bg de sa géné toujours le chouchou des nanas');
        $p2->setPublishedAt(new \DateTimeImmutable('2026-02-12 13:34:49'));
        $p2->setPicture('Capture-d-ecran-2026-02-13-084407-698ed68e03c3e.png');
        $p2->setAuthor($this->getReference(UserFixtures::USER_MELL));
        $p2->setCategory($this->getReference(CategoryFixtures::CAT_PEOPLE));
        $manager->persist($p2);
        $this->addReference(self::POST_2, $p2);

        $p3 = new Post();
        $p3->setTitle('Tawanchai ONE CHAMPIONSHIP');
        $p3->setContent('Tawanchai remporte la ceinture des -70kg Muay Thai au ONE CHAMPIONSHIP');
        $p3->setPublishedAt(new \DateTimeImmutable('2026-02-12 15:37:54'));
        $p3->setPicture('ceinture-tawanchai-698df3d258bfd.jpg');
        $p3->setAuthor($this->getReference(UserFixtures::USER_PONCH));
        $p3->setCategory($this->getReference(CategoryFixtures::CAT_SPORT));
        $manager->persist($p3);
        $this->addReference(self::POST_3, $p3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
