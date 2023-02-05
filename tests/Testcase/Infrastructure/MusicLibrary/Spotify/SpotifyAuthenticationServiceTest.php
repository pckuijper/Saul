<?php

declare(strict_types=1);

namespace Saul\Test\Testcase\Infrastructure\MusicLibrary\Spotify;

use Saul\Infrastructure\Http\Nyholm\NyholmResponseFactory;
use Saul\Infrastructure\MusicLibrary\Spotify\SpotifyAuthenticationService;
use Saul\Test\Framework\AbstractSaulTestcase;
use Saul\Test\Framework\MockHttpClient;
use Symfony\Component\Cache\Adapter\NullAdapter;

/**
 * @small
 *
 * @micro
 */
final class SpotifyAuthenticationServiceTest extends AbstractSaulTestcase
{
    /**
     * @test
     */
    public function it_should_return_a_valid_bearer_token(): void
    {
        $responseFactory = new NyholmResponseFactory();
        $httpClient = new MockHttpClient();
        $cache = new NullAdapter();

        $authService = new SpotifyAuthenticationService(
            $httpClient,
            $cache,
            'valid-api-key',
            'valid-api-secret'
        );
        $validBearerToken = 'VALID_BEARER_TOKEN';

        $httpClient->setupNextResponse($responseFactory->create(
            json_encode([
                'access_token' => $validBearerToken,
                'expires_in' => 3600,
            ], JSON_THROW_ON_ERROR)
        ));

        $actualBearerToken = $authService->getBearerToken();
        self::assertSame($validBearerToken, $actualBearerToken);
    }
}
