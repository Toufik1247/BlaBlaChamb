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
            $cities = ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille', 'Rennes', 'Reims', 'Le Havre', 'Cergy-Pontoise', 'Saint-Étienne', 'Toulon', 'Angers', 'Grenoble', 'Dijon', 'Nîmes', 'Aix-en-Provence', 'Saint-Quentin-en-Yvelines', 'Brest', 'Limoges', 'Tours', 'Amiens', 'Perpignan', 'Metz'];
            $ride->setDeparture($this->faker->randomElement($cities));
            $ride->setDestination($this->faker->randomElement($cities));
            $ride->setSeats($this->faker->numberBetween(1, 7));
            $ride->setPrice($this->faker->randomFloat(2, 1, 50));
            $ride->setDate($this->faker->dateTimeBetween('+1 day', '+10 day'));
            $ride->setCreated($this->faker->dateTime());
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