<?php

/**
 * @see http://docs.doctrine-project.org/en/latest/reference/php-mapping.html#php-files
 *
 * @var \Doctrine\ORM\Mapping\ClassMetadata $metadata
 */

$builder = new \Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder($metadata);

$builder
    // ->setCustomRepositoryClass('Gn\Api\Repository\PermissionRepository')
    ->setTable('permission')
;

$builder->createField('id', 'integer')
    ->isPrimaryKey()
    ->generatedValue('AUTO')
    ->build()
;

$builder->createField('identifier', 'string')
    ->unique(true)
    ->build()
;

$builder->createField('createdAt', 'datetime')
    ->columnName('created_at')
    ->build();

$builder->createField('updatedAt', 'datetime')
    ->columnName('updated_at')
    ->build();
