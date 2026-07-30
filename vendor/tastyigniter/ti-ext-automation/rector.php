<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanConstReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictConstantReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return RectorConfig::configure()
    ->withImportNames(removeUnusedImports: true)
    ->withPaths([
        __DIR__.'/database',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withRules([
        DeclareStrictTypesRector::class,
    ])
    ->withSkip([
        CatchExceptionNameMatchingTypeRector::class,
        NewlineBeforeNewAssignSetRector::class,
        BoolReturnTypeFromBooleanConstReturnsRector::class => [
            __DIR__.'/src/Classes/BaseCondition.php',
        ],
        ReturnNeverTypeRector::class => [
            __DIR__.'/src/Classes/BaseAction.php',
        ],
        ReturnTypeFromStrictConstantReturnRector::class => [
            __DIR__.'/src/Classes/BaseCondition.php',
        ],
        ReturnTypeFromStrictNewArrayRector::class,
        ReturnTypeFromReturnDirectArrayRector::class => [
            __DIR__.'/src/Classes/BaseAction.php',
            __DIR__.'/src/Classes/BaseCondition.php',
            __DIR__.'/src/Classes/BaseEvent.php',
            __DIR__.'/src/Classes/BaseModelAttributesCondition.php',
        ],
        RemoveUselessReturnTagRector::class => [
            __DIR__.'/src/Classes/BaseAction.php',
            __DIR__.'/src/Classes/BaseCondition.php',
            __DIR__.'/src/Classes/BaseEvent.php',
        ],
    ])
    ->withPhpSets(php83: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
    );
