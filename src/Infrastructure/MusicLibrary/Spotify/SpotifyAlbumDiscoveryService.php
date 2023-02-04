<?php

declare(strict_types=1);

namespace Saul\Infrastructure\MusicLibrary\Spotify;

use Exception;
use Saul\Core\Component\MusicLibrary\Domain\Album;
use Saul\Core\Component\MusicLibrary\Domain\Artist;
use Saul\Core\Component\MusicLibrary\Domain\ExternalAlbumId;
use Saul\Core\Component\MusicLibrary\Domain\ExternalArtistId;
use Saul\Core\Component\MusicLibrary\Domain\ReleaseDate;
use Saul\Core\Port\Http\HttpClientInterface;
use Saul\Core\Port\MusicLibrary\AlbumDiscoveryServiceInterface;
use Saul\PhpExtension\Collection\Collection;
use Saul\PhpExtension\Http\AuthorizationHttpHeader;
use Saul\PhpExtension\Http\ContentTypeHttpHeader;
use Saul\PhpExtension\Http\HttpResponseStatus;

final class SpotifyAlbumDiscoveryService implements AlbumDiscoveryServiceInterface
{
    private const BASE_URL = 'https://api.spotify.com';
    private const URL_NEW_RELEASES = self::BASE_URL . '/v1/browse/new-releases';

    public function __construct(
        private HttpClientInterface $httpClient,
        private SpotifyAuthenticationService $authenticationService
    ) {
    }

    /**
     * @return Collection<Album>
     */
    public function findLatest(int $amountToFind, int $offset = 0, string $country = 'NL'): Collection
    {
        $response = $this->httpClient->get(
            $this->buildNewReleasesUrl($amountToFind, $offset, $country),
            [
                ContentTypeHttpHeader::NAME => ContentTypeHttpHeader::VALUE_APPLICATION_JSON,
                AuthorizationHttpHeader::NAME => AuthorizationHttpHeader::bearer(
                    $this->authenticationService->getBearerToken()
                ),
            ]
        );

        $responseCode = $response->getStatusCode();

        if ($responseCode === HttpResponseStatus::UNAUTHORIZED) {
            throw new Exception('Expired authorization token');
        }

        if ($response->getStatusCode() !== HttpResponseStatus::OK) {
            throw new Exception('Failed to fetch data from spotify');
        }

        $albums = $this->parseNewReleases($response->getBody()->getContents());

        return new Collection($albums);
    }

    private function buildNewReleasesUrl(int $limit, int $offset, string $country): string
    {
        return sprintf(
            '%s?limit=%d&offset=%d&country=%s',
            self::URL_NEW_RELEASES,
            $limit,
            $offset,
            $country
        );
    }

    /**
     * @return Album[]
     */
    private function parseNewReleases(string $jsonBody): array
    {
        /**
         * @var array{
         *      albums: array{
         *          items: list<
         *              array{
         *                  artists: list<array{name: string, id: string}>,
         *                  external_urls: array{spotify: string},
         *                  id: string,
         *                  name: string,
         *                  release_date: string,
         *                  total_tracks: int
         *              }
         *          >
         *      }
         * }
         */
        $data = json_decode($jsonBody, true, 512, JSON_THROW_ON_ERROR);
        $albumData = $data['albums']['items'];
        $albums = [];

        foreach ($albumData as $album) {
            $albums[] = new Album(
                new ExternalAlbumId($album['id']),
                $album['name'],
                new ReleaseDate($album['release_date']),
                $album['total_tracks'],
                $this->parseArtists($album['artists'])
            );
        }

        return $albums;
    }

    /**
     * @param list<array{name: string, id: string}> $artistData
     *
     * @return Artist[]
     */
    private function parseArtists(array $artistData): array
    {
        return array_map(
            function (array $artist): Artist {
                return new Artist(
                    new ExternalArtistId($artist['id']),
                    $artist['name']
                );
            },
            $artistData
        );
    }
}
