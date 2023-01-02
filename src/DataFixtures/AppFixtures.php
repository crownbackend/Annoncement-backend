<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $user1 = new User();
        $user1->setEmail($faker->email);
        $user1->setFirstName($faker->firstName);
        $user1->setLastName($faker->lastName);
        $password = $this->hasher->hashPassword($user1, 'pass_1234');
        $user1->setPassword($password);
        $user1->setBirthday(\DateTimeImmutable::createFromMutable($faker->dateTime));
        $manager->persist($user1);

        $category1 = new Category();
        $category1->setName($faker->word);
        $manager->persist($category1);

        $user2 = new User();
        $user2->setEmail($faker->email);
        $user2->setFirstName($faker->firstName);
        $user2->setLastName($faker->lastName);
        $password = $this->hasher->hashPassword($user2, 'pass_1234');
        $user2->setPassword($password);
        $user2->setBirthday(\DateTimeImmutable::createFromMutable($faker->dateTime));
        $manager->persist($user1);

        $category1 = new Category();
        $category1->setName($faker->word);
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName($faker->word);
        $manager->persist($category2);

        for ($i = 0; $i < 500; $i++) {
            $ad = new Ad();
            $ad->setName($faker->sentence($nbWords = 6, $variableNbWords = true));
            $ad->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime));
            $ad->setCategory($category1);
            $ad->setDescription($faker->paragraph(200, true));
            $ad->setPrice($faker->randomFloat());
            $ad->setDisabled($faker->boolean());
            $ad->setTelephone($faker->phoneNumber);
            $image = new Image();
            $image->setName('https://picsum.photos/1000/700');
            $ad->addImage($image);
            $ad->setUser($user1);

            $manager->persist($ad);
        }

        for ($i = 0; $i < 500; $i++) {
            $ad = new Ad();
            $ad->setName($faker->sentence($nbWords = 10, $variableNbWords = true));
            $ad->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime));
            $ad->setCategory($category2);
            $ad->setDescription($faker->paragraph(200, true));
            $ad->setPrice($faker->randomFloat());
            $ad->setDisabled($faker->boolean());
            $ad->setTelephone($faker->phoneNumber);
            $image = new Image();
            $image->setName('https://picsum.photos/1000/700');
            $ad->addImage($image);
            $ad->setUser($user2);

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
