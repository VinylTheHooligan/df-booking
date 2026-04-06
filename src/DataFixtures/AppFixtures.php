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
        'Matériels',
        'Véhicules',
        'Équipements divers'
    ];

    private array $resources = [
        'Salles' => [
            'Salle de réunion A',
            'Salle de réunion B',
            'Salle de conférence A',
            'Salle de conférence B',
            'Salle de formation A',
            'Salle de formation B',
            'Salle de formation C',
            'Bureau partagé A',
            'Bureau partagé B',
            'Open Space A',
            'Open Space B',
        ],
        'Matériels' => [
            'Ordinateur portable Dell Latitude',
            'Ordinateur portable HP ProBook',
            'MacBook Pro 16"',
            'Vidéoprojecteur Epson X200',
            'Vidéoprojecteur BenQ HD',
            'Écran 27" Samsung',
            'Écran 32" LG UltraWide',
            'Webcam Logitech C920',
            'Webcam 4K Insta360',
            'Micro USB Blue Yeti',
            'Casque audio Jabra Evolve',
            'Kit visioconférence Poly Studio',
        ],
        'Véhicules' => [
            'Renault Clio',
            'Peugeot 308',
            'Renault Kangoo',
        ],
        'Équipements divers' => [
            'Kit de présentation (pointeur laser + télécommande)',
            'Tableau blanc mobile',
            'Paperboard + feuilles',
        ],
    ];


    public function load(ObjectManager $manager): void
    {
        $this->loadUser();
        $this->loadRessourceType();
        $this->loadRessource();
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

    private function loadRessource(): void
    {
        foreach ($this->resources as $resourceTypeName => $resourceNames) {

            $resourceType = ResourceTypeFactory::find(['name' => $resourceTypeName]);

            foreach ($resourceNames as $name) {
                ResourceFactory::createOne([
                    'name' => $name,
                    'resourceType' => $resourceType
                ]);
            }
        }
    }

}
