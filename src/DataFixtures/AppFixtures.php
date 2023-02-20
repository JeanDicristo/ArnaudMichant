<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use App\Entity\ProfilUser;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
      /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr-FR');
    }
    public function load(ObjectManager $manager): void
    {
        // Plat
        $plats = [];
        for ($i = 0; $i < 20; $i++) {
            $plat = new Plat();
            $plat->setTitle($this->faker->word(2))
                ->setPrice(mt_rand(0, 30))
                ->setDescription($this->faker->text(40));

            $plats[] = $plat;
            $manager->persist($plat);

        }

        // Users
        for ($i=0; $i < 10; $i++) { 
            $user = new ProfilUser();
            $user->setEmail($this->faker->email())
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('password');


            $manager->persist($user);

        }

        $manager->flush();
}
}
