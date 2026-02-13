<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CAT_JEU_VIDEO = 'cat_jeu_video';
    public const CAT_SPORT     = 'cat_sport';
    public const CAT_PEOPLE    = 'cat_people';

    public function load(ObjectManager $manager): void
    {
        $data = [
            [self::CAT_JEU_VIDEO, 'Jeu Vidéo', null],
            [self::CAT_SPORT, 'Sport', null],
            [self::CAT_PEOPLE, 'People', null],
        ];

        foreach ($data as [$ref, $name, $desc]) {
            $cat = new Category();
            $cat->setName($name);
            $cat->setDescription($desc);

            $manager->persist($cat);
            $this->addReference($ref, $cat);
        }

        $manager->flush();
    }
}
