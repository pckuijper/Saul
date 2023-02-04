<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Infrastructure\MusicLibrary\Spotify;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Saul\Core\Port\Http\ResponseFactoryInterface;
use Saul\Infrastructure\Http\Nyholm\NyholmResponseFactory;
use Saul\Infrastructure\MusicLibrary\Spotify\SpotifyAlbumDiscoveryService;
use Saul\Infrastructure\MusicLibrary\Spotify\SpotifyAuthenticationService;
use Saul\PhpExtension\Http\ContentTypeHttpHeader;
use Saul\PhpExtension\Http\HttpResponseStatus;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\MockHttpClient;

/**
 * @small
 */
final class SpotifyAlbumDiscoveryServiceTest extends AbstractSaulTestcase
{
    private ResponseFactoryInterface $responseFactory;

    protected function setUp(): void
    {
        $this->responseFactory = new NyholmResponseFactory();
    }

    /**
     * @test
     */
    public function it_should_find_latest_albums(): void
    {
        $mockHttpClient = new MockHttpClient();
        $albumDiscovery = new SpotifyAlbumDiscoveryService(
            $mockHttpClient,
            new SpotifyAuthenticationService()
        );
        $mockHttpClient->setupNextResponse($this->getLatestAlbumResponse());

        $albumCollection = $albumDiscovery->findLatest(2);

        self::assertCount(2, $albumCollection);
    }

    private function getLatestAlbumResponse(): ResponseInterface
    {
        $jsonBody = file_get_contents(__DIR__ . '/fixtures/album_new_releases.json');
        if ($jsonBody === false) {
            throw new Exception('Failed to find album fixtures');
        }

        return $this->responseFactory->create(
            $jsonBody,
            HttpResponseStatus::OK,
            [
                ContentTypeHttpHeader::NAME => ContentTypeHttpHeader::VALUE_APPLICATION_JSON,
            ]
        );
    }
}
