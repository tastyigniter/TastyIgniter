<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withRules([
        DeclareStrictTypesRector::class,
    ])
    ->withSkip([
        CatchExceptionNameMatchingTypeRector::class,
        ReturnNeverTypeRector::class,
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
