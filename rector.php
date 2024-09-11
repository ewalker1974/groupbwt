<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Symfony\CodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withSymfonyContainerXml(__DIR__.'/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withSets([
        SymfonySetList::SYMFONY_64,
        SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
        DoctrineSetList::DOCTRINE_BUNDLE_210,
        DoctrineSetList::DOCTRINE_COLLECTION_22,
        DoctrineSetList::DOCTRINE_DBAL_30,
        DoctrineSetList::DOCTRINE_ORM_29,
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
        SetList::PRIVATIZATION,
        SetList::STRICT_BOOLEANS,
        SetList::TYPE_DECLARATION,
    ])
    ->withSkip([
        EventListenerToEventSubscriberRector::class,
        EncapsedStringsToSprintfRector::class,
        NullToStrictStringFuncCallArgRector::class,
        DisallowedEmptyRuleFixerRector::class,
        RemoveUnusedPrivateMethodRector::class,
        CatchExceptionNameMatchingTypeRector::class,
    ])
    ->withImportNames()
    ->withParallel(120, 16, 10);
