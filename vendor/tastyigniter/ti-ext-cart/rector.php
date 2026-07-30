<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return RectorConfig::configure()
    ->withImportNames(removeUnusedImports: true)
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withRules([
        DeclareStrictTypesRector::class,
    ])
    ->withSkip([
        ReturnTypeFromStrictNewArrayRector::class,
        NewlineBeforeNewAssignSetRector::class,
    ])
    ->withPhpSets(php83: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
    );
