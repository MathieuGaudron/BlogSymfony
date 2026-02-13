<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUserFixtures extends Fixture
{
    public const PROF_USER = 'user_prof';

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $prof = new User();
        $prof->setEmail('prof@demo.fr');
        $prof->setRoles(['ROLE_ADMIN']);
        $prof->setFirstName('Prof');
        $prof->setLastName('Admin');
        $prof->setProfilePicture(null);
        $prof->setIsActive(true);
        $prof->setCreatedAt(new \DateTimeImmutable());

        $prof->setPassword($this->hasher->hashPassword($prof, 'prof1234'));

        $manager->persist($prof);

        $this->addReference(self::PROF_USER, $prof);

        $manager->flush();
    }
}
