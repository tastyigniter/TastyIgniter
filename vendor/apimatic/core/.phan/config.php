<?php

$vendor_dir = getenv('COMPOSER_VENDOR_DIR') ?: 'vendor';

/**
 * This configuration will be read and overlaid on top of the
 * default configuration. Command line arguments will be applied
 * after this file is read.
 */
return [
    // Supported values: `'7.2'`, `'7.3'`, `'7.4'`, `'8.0'`, `'8.1'`, `null`.
    // If this is set to `null`,
    // then Phan assumes the PHP version which is closest to the minor version
    // of the php executable used to execute Phan.
    //
    // Note that the **only** effect of choosing `'7.2'` is to infer that functions removed in php 8.0 exist.
    // (See `backward_compatibility_checks` for additional options)
    'target_php_version' => '7.2',

    // A list of directories that should be parsed for class and
    // method information. After excluding the directories
    // defined in exclude_analysis_directory_list, the remaining
    // files will be statically analyzed for errors.
    //
    // Thus, both first-party and third-party code being used by
    // your application should be included in this list.
    'directory_list' => [
        'src',
        'tests',
        $vendor_dir . '/apimatic/core-interfaces',
        $vendor_dir . '/apimatic/jsonmapper',
        $vendor_dir . '/phpunit/phpunit',
        $vendor_dir . '/php-jsonpointer/php-jsonpointer'
    ],

    // A directory list that defines files that will be excluded
    // from static analysis, but whose class and method
    // information should be included.
    //
    // Generally, you'll want to include the directories for
    // third-party code (such as "vendor/") in this list.
    //
    // n.b.: If you'd like to parse but not analyze 3rd
    //       party code, directories containing that code
    //       should be added to both the `directory_list`
    //       and `exclude_analysis_directory_list` arrays.
    'exclude_analysis_directory_list' => [
        $vendor_dir
    ],

    'plugin_config' => [
        'infer_pure_methods' => true
    ],

    'plugins' => [
        'AlwaysReturnPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
        'UnreachableCodePlugin',
        'InvokePHPNativeSyntaxCheckPlugin',
        'UseReturnValuePlugin',
        'EmptyStatementListPlugin',
        'LoopVariableReusePlugin',
        'RedundantAssignmentPlugin',
        'NonBoolBranchPlugin',
        'NonBoolInLogicalArithPlugin',
        'InvalidVariableIssetPlugin',
        'NoAssertPlugin',
        'DuplicateExpressionPlugin',
        'WhitespacePlugin',
        'PHPDocToRealTypesPlugin',
        'PHPDocRedundantPlugin',
        'PreferNamespaceUsePlugin',
        'StrictComparisonPlugin',
        'EmptyMethodAndFunctionPlugin',
        'DollarDollarPlugin',
        'AvoidableGetterPlugin'
    ]
];
