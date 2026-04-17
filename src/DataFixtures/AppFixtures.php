<?php

namespace App\DataFixtures;

use App\Factory\ResourceFactory;
use App\Factory\ResourceTypeFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private array $resourceTypes = [
        'Salles de réunion',
        'Salles de conférence',
        'Salles de formation',
        'Bureau',
        'Open Space'
    ];

    private array $resources = [
        'Salles de réunion' => [
            'Salle de réunion A' => 8,
            'Salle de réunion B' => 15,
            'Salle de réunion C' => 15,
            'Salle de réunion D' => 15,
            'Salle de réunion E' => 19,
        ],
        'Salles de conférence' => [
            'Salle de conférence A' => 20,
            'Salle de conférence B' => 20,
            'Salle de conférence C' => 20,
            'Salle de conférence D' => 20,
        ],
        'Salles de formation' => [
            'Salle de formation A' => 30,
            'Salle de formation B' => 25,
            'Salle de formation C' => 30,
            'Salle de formation D' => 30,
            'Salle de formation E' => 30,
            'Salle de formation F' => 30,
            'Salle de formation G' => 30,
        ],
        'Bureau' => [
            'Bureau partagé A' => 5,
            'Bureau partagé B' => 5,
            'Bureau partagé C' => 5,
            'Bureau partagé D' => 5,
            'Bureau partagé E' => 5,
            'Bureau partagé F' => 5,
        ],
        'Open Space' => [
            'Open Space A' => 12,
            'Open Space B' => 14,
            'Open Space C' => 14,
        ],
    ];


    public function load(ObjectManager $manager): void
    {
        $this->loadUser();
        $this->loadRessourceType();        
        $this->loadRoomRessources();
    }

    private function loadUser(): void
    {
        UserFactory::createOne([
                'email' => 'admin@df.fr',
                'roles' => ['ROLE_ADMIN']
        ]);
        UserFactory::createMany(10, function(int $i) {
            return [
                'email' => 'user' . $i . '@df.fr',
                'roles' => ['ROLE_USER']
            ];
        });

    }

    private function loadRessourceType(): void
    {
        foreach ($this->resourceTypes as $resourceType) {
            ResourceTypeFactory::createOne([
                'name' => $resourceType
            ]);
        }
    }

    private function loadRoomRessources(): void
    {
        foreach ($this->resources as $resourceTypeName => $resourceNames) {

            $resourceType = ResourceTypeFactory::find(['name' => $resourceTypeName]);

            foreach ($resourceNames as $name => $capacity) {
                ResourceFactory::createOne([
                    'name'         => $name,
                    'capacity'     => $capacity,
                    'isEnabled'  => true,
                    'resourceType' => $resourceType,
                    'createdAt'    => new \DateTimeImmutable(),
                    'description'  => 'Salle dont la description reste à définir.',
                    'location'     => 'Adresse, Étage ##.',
                ]);
            }
        }
    }

}
