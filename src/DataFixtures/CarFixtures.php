<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CarFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            $car = new Car();
            $car->setBrand($this->faker->word());
            $car->setModel($this->faker->word());
            $car->setSeats($this->faker->numberBetween(1, 7));
            $car->setCreated($this->faker->dateTime());

            // Pour définir la catégorie en relation avec mon produit j'utilise la méthode getReference
            $car->setOwner($this->getReference("owner_" . $this->faker->numberBetween(0, 9)));

            $manager->persist($car);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}