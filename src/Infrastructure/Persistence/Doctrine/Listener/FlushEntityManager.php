<?php

declare(strict_types=1);

namespace Saul\Infrastructure\Persistence\Doctrine\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class FlushEntityManager implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManger
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::TERMINATE => [
                ['flushDoctrineEntityManager', 0],
            ],
        ];
    }

    public function flushDoctrineEntityManager(ConsoleTerminateEvent $event): void
    {
        $this->entityManger->flush();
    }
}
