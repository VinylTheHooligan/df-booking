<?php

namespace App\Service;

use App\Assembler\LogEntryAssembler;
use App\Entity\Resource;
use App\Entity\User;
use App\Enum\LogState;
use Doctrine\ORM\EntityManagerInterface;

class ResourceServiceManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private ActionLogger $al,
    )
    {}

    public function modify(Resource $resource, User $user): void
    {
        // Resource to save
        $this->em->persist($resource);
        $this->em->flush();

        // Log entry
        $logDTO = LogEntryAssembler::fromEntity($resource, LogState::UPDATED, [], $user);
        $this->al->LogToDatabase($logDTO);
    }
}