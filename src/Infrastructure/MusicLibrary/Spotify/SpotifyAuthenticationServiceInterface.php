<?php

declare(strict_types=1);

namespace Saul\Infrastructure\MusicLibrary\Spotify;

interface SpotifyAuthenticationServiceInterface
{
    public function getBearerToken(): string;
}
