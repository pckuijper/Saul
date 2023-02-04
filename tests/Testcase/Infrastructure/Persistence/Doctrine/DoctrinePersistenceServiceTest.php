<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Saul\Core\Component\MusicLibrary\Domain\Album;
use Saul\Core\Component\MusicLibrary\Domain\Artist;
use Saul\Core\Component\MusicLibrary\Domain\ExternalAlbumId;
use Saul\Core\Component\MusicLibrary\Domain\ExternalArtistId;
use Saul\Core\Component\MusicLibrary\Domain\ReleaseDate;
use Saul\Core\Port\Persistence\PersistenceServiceInterface;
use Saul\Infrastructure\Persistence\Doctrine\DoctrinePersistenceService;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\TestApp;

/**
 * @small
 *
 * @integration
 */
final class DoctrinePersistenceServiceTest extends AbstractSaulTestcase
{
    private TestApp $testApp;

    private EntityManagerInterface $entityManager;

    private DoctrinePersistenceService $persistenceService;

    protected function setUp(): void
    {
        $this->testApp = new TestApp();

        $this->entityManager = $this->getEntityManger();
        $this->persistenceService = $this->getDoctrinePersistenceServiceService();

        $this->testApp->setContainerService(
            PersistenceServiceInterface::class,
            $this->persistenceService
        );
    }

    /**
     * @test
     */
    public function it_can_persist_an_entity(): void
    {
        $entity = $this->createAlbum();

        $this->persistenceService->upsert($entity);
        $this->entityManager->flush();
        $this->entityManager->clear();

        /** @var EntityRepository<Album> */
        $repository = $this->entityManager->getRepository(Album::class);

        self::assertSame(
            1,
            $repository->count(['externalAlbumId' => 'external-id'])
        );
    }

    /**
     * @test
     */
    public function it_can_find_entities(): void
    {
        $this->persistEntity($this->createAlbum());

        $entities = $this->persistenceService->findEntity(Album::class);

        self::assertCount(1, $entities);
    }

    private function persistEntity(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    private function createAlbum(): Album
    {
        return new Album(
            new ExternalAlbumId('external-id'),
            'Random name',
            new ReleaseDate('2022-02-01'),
            mt_rand(10, 20),
            [
                new Artist(
                    new ExternalArtistId('external-id'),
                    'Random name'
                ),
            ]
        );
    }

    private function getEntityManger(): EntityManagerInterface
    {
        /** @var EntityManagerInterface */
        return $this->testApp->container->get(EntityManagerInterface::class) ?? throw new Exception('Failed to get EntityManager');
    }

    private function getDoctrinePersistenceServiceService(): DoctrinePersistenceService
    {
        /** @var DoctrinePersistenceService */
        return $this->testApp->container->get(DoctrinePersistenceService::class) ?? throw new Exception('Failed to get DoctrinePersistenceService');
    }
}
