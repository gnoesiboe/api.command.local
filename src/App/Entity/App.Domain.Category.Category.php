<?php

/**
 * @see http://docs.doctrine-project.org/en/latest/reference/php-mapping.html#php-files
 *
 * @var \Doctrine\ORM\Mapping\ClassMetadata $metadata
 */

$builder = new \Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder($metadata);

$builder
    ->setCustomRepositoryClass('App\Repository\CategoryRepository')
    ->setTable('category')
;

$builder->createField('id', 'integer')
    ->isPrimaryKey()
    ->generatedValue('AUTO')
    ->build();

$builder->createField('title', 'string')
    ->build();

//@todo add gedmo timestampable
$builder->createField('createdAt', 'datetime')
        ->columnName('created_at')
        ->build();

//@todo add gedmo timestampable
$builder->createField('updatedAt', 'datetime')
        ->columnName('updated_at')
        ->build();
