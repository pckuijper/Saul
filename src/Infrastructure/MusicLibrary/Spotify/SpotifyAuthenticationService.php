<?php

declare(strict_types=1);

namespace Saul\Infrastructure\MusicLibrary\Spotify;

use Exception;
use Saul\Core\Port\Http\HttpClientInterface;
use Saul\PhpExtension\Http\AcceptHttpHeader;
use Saul\PhpExtension\Http\AuthorizationHttpHeader;
use Saul\PhpExtension\Http\ContentTypeHttpHeader;
use Saul\PhpExtension\Http\HttpResponseStatus;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class SpotifyAuthenticationService implements SpotifyAuthenticationServiceInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache,
        private string $apiKey,
        private string $apiSecret
    ) {
    }

    public function getBearerToken(): string
    {
        $bearerToken = $this->cache->get(
            'spotify_bearer_token',
            function (ItemInterface $item): string {
                $apiResponse = $this->httpClient->post(
                    'https://accounts.spotify.com/api/token',
                    http_build_query([
                        'grant_type' => 'client_credentials',
                    ]),
                    [
                        AcceptHttpHeader::NAME => AcceptHttpHeader::VALUE_APPLICATION_JSON,
                        ContentTypeHttpHeader::NAME => ContentTypeHttpHeader::VALUE_APPLICATION_X_WWW_FORM_URLENCODED,
                        AuthorizationHttpHeader::NAME => AuthorizationHttpHeader::basic($this->apiKey, $this->apiSecret),
                    ]
                );

                $responseCode = $apiResponse->getStatusCode();
                if ($responseCode !== HttpResponseStatus::OK) {
                    throw new Exception('Invalid spotify credentials');
                }

                /** @var array{access_token: string, expires_in: int} */
                $responseBody = json_decode($apiResponse->getBody()->getContents(), true);

                $item->expiresAfter($responseBody['expires_in']);

                return $responseBody['access_token'];
            }
        );

        if (is_string($bearerToken) === false) {
            throw new Exception('Bearer token is not a string');
        }

        return $bearerToken;
    }
}
