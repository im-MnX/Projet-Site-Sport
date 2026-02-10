<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(\Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new \App\Entity\Utilisateur();
        $admin->setEmail('admin@club.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        
        $manager->persist($admin);
        $manager->flush();
    }
}
