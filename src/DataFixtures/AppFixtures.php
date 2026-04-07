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
        'Salles',
    ];

    private array $resources = [
        'Salles' => [
            'Salle de réunion A' => 8,
            'Salle de réunion B' => 15,
            'Salle de conférence A' => 20,
            'Salle de conférence B' => 20,
            'Salle de formation A' => 30,
            'Salle de formation B' => 25,
            'Salle de formation C' => 30,
            'Bureau partagé A' => 5,
            'Bureau partagé B' => 5,
            'Open Space A' => 12,
            'Open Space B' => 14,
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
                    'isAvailable'  => true,
                    'resourceType' => $resourceType,
                    'createdAt'    => new \DateTimeImmutable(),
                ]);
            }
        }
    }

}
