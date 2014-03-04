<?php

/**
 * @see http://docs.doctrine-project.org/en/latest/reference/php-mapping.html#php-files
 *
 * @var \Doctrine\ORM\Mapping\ClassMetadata $metadata
 */

$builder = new \Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder($metadata);

$builder
    ->setCustomRepositoryClass('Gn\Api\Repository\ClientRepository')
    ->setTable('client')
;

/** @var \Doctrine\ORM\Mapping\Builder\FieldBuilder $idField */
$builder->createField('id', 'integer')
    ->isPrimaryKey()
    ->generatedValue('AUTO')
    ->build()
;

$builder->createField('name', 'string')
    ->build();

$builder->createField('identifier', 'string')
    ->build();

$builder->createField('key', 'string')
    ->build();

//@todo add gedmo timestampable
$builder->createField('createdAt', 'datetime')
    ->columnName('created_at')
    ->build();

//@todo add gedmo timestampable
$builder->createField('updatedAt', 'datetime')
    ->columnName('updated_at')
    ->build();

$builder->addOwningManyToMany('permissions', 'Gn\Api\Domain\Permission\Permission');
