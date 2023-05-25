<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture
{
    // La méthode "load" est imposé par la classe Fixture que la classe AbstractFixture étend
    // C'est cette méthode qui permet de créer des fixtures
    public function load(ObjectManager $manager)
    {
        // Une boucle de 10 pour générer 10 produits
        for ($i = 0; $i < 10; $i++) {

            // Instancie un objet Product avec un nom
            $user = new User();
            // $product->setName($this->faker->word());
            $user->setEmail($this->faker->email());
            $user->setPassword($this->faker->password());
            $user->setRoles($this->faker->word());
            $user->setFirstName($this->faker->firstName());
            $user->setLastName($this->faker->lastName());
            $user->setPhone($this->faker->phoneNumber());
            $user->setCreated($this->faker->dateTime());

            // Enregistre le produit fraîchement créé, à faire à chaque tour de boucle
            $manager->persist($user);
            $this->setReference('owner_' . $i, $user);
        }

        // Une fois la boucle terminée je persiste les produits fraîchement créés
        $manager->flush();
    }
}