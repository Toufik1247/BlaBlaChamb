<?php

namespace App\DataFixtures;

use App\Entity\Ride;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RideFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            $ride = new Ride();
            $ride->setDeparture($this->faker->city());
            $ride->setDestination($this->faker->city());
            $ride->setSeats($this->faker->numberBetween(1, 7));
            $ride->setPrice($this->faker->randomFloat(1, 50));
            $ride->setDate($this->faker->dateTime());
            $ride->setCreated($this->faker->dateTime());


            // Pour définir la catégorie en relation avec mon produit j'utilise la méthode getReference
            $ride->setDriver($this->getReference("owner_" . $this->faker->numberBetween(0, 9)));
            for ($y = 0; $y < $this->faker->numberBetween(1, 3); $y++) {
                $ride->addRule($this->getReference("rule_" . $this->faker->numberBetween(0, 9)));
            }


            $manager->persist($ride);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            RuleFixtures::class,
        ];
    }
}