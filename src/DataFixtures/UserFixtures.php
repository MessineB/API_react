<?php

namespace App\DataFixtures;
use Faker;
use Faker\Factory;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder
        ){}
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@essai.fr');
        $admin->setLastname('admin1');
        $admin->setName('Gérard');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i < 5; $i++) { 
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setName($faker->name);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'user')
            );
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
