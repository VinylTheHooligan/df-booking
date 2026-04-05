<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadUser();
    }

    private function loadUser(): void
    {
        UserFactory::createOne([
                'email' => 'admin@df.fr',
                'role' => ['ROLE_ADMIN']
        ]);
        UserFactory::createMany(10, function(int $i) {
            return [
                'email' => 'user' . $i . '@df.fr',
                'role' => ['ROLE_USER']
            ];
        });
    }
}
