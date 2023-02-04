<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

$builder->setTable('music_library__album')
    ->addField(
        'id',
        'album_id',
        ['id' => true]
    )
    ->addField(
        'externalAlbumId',
        'external_album_id'
    )
    ->addField(
        'name',
        'string'
    )
    ->addField(
        'releaseDate',
        'release_date'
    )
    ->addField(
        'totalTracks',
        'integer'
    );
