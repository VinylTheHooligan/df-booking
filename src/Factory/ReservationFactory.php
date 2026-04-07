<?php

namespace App\Factory;

use App\Entity\Reservation;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Reservation>
 */
final class ReservationFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Reservation::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $start = \DateTimeImmutable::createFromMutable(self::faker()->dateTime());
        $end = $start->modify('+'.self::faker()->numberBetween(1, 5).' days');

        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'startAt' => $start,
            'endAt' => $end,
            'resource' => ResourceFactory::random(),
            'status' => self::faker()->text(50),
            'user' => UserFactory::random(),
        ];
    }

    public function reserved(): self
    {
        return $this->afterInstantiate(function(Reservation $reservation) {
            $resource = $reservation->getResource();
    
            if ($resource->getQuantity() !== null && $resource->isQuantityAvailable(1)) {
                $resource->reserveQuantity(1);
            }
        });
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this->afterInstantiate(function(Reservation $reservation) {
    
            $resource = $reservation->getResource();
    
            if ($resource->getQuantity() !== null) {
                $resource->reserveQuantity(1);
            }
        });
    }

}
