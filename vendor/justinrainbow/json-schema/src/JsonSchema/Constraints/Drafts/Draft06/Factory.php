<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

class Factory extends \JsonSchema\Constraints\Factory
{
    /**
     * @var array<string, class-string>
     */
    protected $constraintMap = [
        'schema' => Draft06Constraint::class,
        'additionalProperties' => AdditionalPropertiesConstraint::class,
        'additionalItems' => AdditionalItemsConstraint::class,
        'dependencies' => DependenciesConstraint::class,
        'type' => TypeConstraint::class,
        'const' => ConstConstraint::class,
        'enum' => EnumConstraint::class,
        'uniqueItems' => UniqueItemsConstraint::class,
        'minItems' => MinItemsConstraint::class,
        'minProperties' => MinPropertiesConstraint::class,
        'maxProperties' => MaxPropertiesConstraint::class,
        'minimum' => MinimumConstraint::class,
        'maximum' => MaximumConstraint::class,
        'exclusiveMinimum' => ExclusiveMinimumConstraint::class,
        'minLength' => MinLengthConstraint::class,
        'maxLength' => MaxLengthConstraint::class,
        'maxItems' => MaxItemsConstraint::class,
        'exclusiveMaximum' => ExclusiveMaximumConstraint::class,
        'multipleOf' => MultipleOfConstraint::class,
        'required' => RequiredConstraint::class,
        'format' => FormatConstraint::class,
        'anyOf' => AnyOfConstraint::class,
        'allOf' => AllOfConstraint::class,
        'oneOf' => OneOfConstraint::class,
        'not' => NotConstraint::class,
        'contains' => ContainsConstraint::class,
        'propertyNames' => PropertiesNamesConstraint::class,
        'patternProperties' => PatternPropertiesConstraint::class,
        'pattern' => PatternConstraint::class,
        'properties' => PropertiesConstraint::class,
        'items' => ItemsConstraint::class,
        'ref' => RefConstraint::class,
    ];
}
