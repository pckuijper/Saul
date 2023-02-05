<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

$builder->setTable('music_library__artist')
    ->addField(
        'id',
        'artist_id',
        ['id' => true]
    )
    ->addField(
        'externalArtistId',
        'external_artist_id'
    )
    ->addField(
        'name',
        'string'
    );
