<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_PONCH = 'user_ponch';
    public const USER_MELL  = 'user_mell';
    public const USER_TEST  = 'user_test';
    public const USER_JULIE = 'user_julie';
    public const USER_KENZA = 'user_kenza';

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'ref' => self::USER_PONCH,
                'email' => 'ponch@mail.fr',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
                'first' => 'ponch',
                'last' => 'ponch',
                'password' => 'user1234',
            ],
            [
                'ref' => self::USER_MELL,
                'email' => 'mell@mail.fr',
                'roles' => ['ROLE_USER'],
                'first' => 'mell',
                'last' => 'biggie',
                'password' => 'user1234',
            ],
            [
                'ref' => self::USER_TEST,
                'email' => 'test@mail.fr',
                'roles' => ['ROLE_USER'],
                'first' => 'test',
                'last' => 'test',
                'password' => 'user1234',
            ],
            [
                'ref' => self::USER_JULIE,
                'email' => 'julie@mail.fr',
                'roles' => ['ROLE_USER'],
                'first' => 'Julie',
                'last' => 'Groupie',
                'password' => 'user1234',
            ],
            [
                'ref' => self::USER_KENZA,
                'email' => 'kenza@mail.fr',
                'roles' => ['ROLE_USER'],
                'first' => 'Kenza',
                'last' => 'Groupie',
                'password' => 'user1234',
            ],
        ];

        foreach ($users as $u) {
            $user = new User();
            $user->setEmail($u['email']);
            $user->setRoles($u['roles']);
            $user->setFirstName($u['first']);
            $user->setLastName($u['last']);
            $user->setProfilePicture(null);
            $user->setIsActive(true);
            $user->setCreatedAt(new \DateTimeImmutable());

            $user->setPassword($this->hasher->hashPassword($user, $u['password']));

            $manager->persist($user);
            $this->addReference($u['ref'], $user);
        }

        $manager->flush();
    }
}
