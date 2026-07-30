<?php
/**
 * Part of JsonMapper
 *
 * PHP version 5
 *
 * @category Apimatic
 * @package  JsonMapper
 * @author   Asad Ali <asad.ali@apimatic.io>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://www.apimatic.io/
 */
namespace apimatic\jsonmapper;

/**
 * Data class to hold the groups of multiple types.
 *
 * @category Apimatic
 * @package  JsonMapper
 * @author   Asad Ali <asad.ali@apimatic.io>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://www.apimatic.io/
 */
class TypeCombination
{
    /**
     * String format of this typeCombinator group.
     *
     * @var string
     */
    private $_format;

    /**
     * Name of this typeCombinator group i.e. oneOf/anyOf.
     *
     * @var string
     */
    private $_groupName;

    /**
     * Name of discriminator field for this typeCombinator group.
     *
     * @var string
     */
    private $_discriminatorField;

    /**
     * Mapping of each discriminator value on types in this typeCombinator group.
     * i.e. [typeName => discriminatorValues]
     *
     * @var array
     */
    private $_discriminatorMapping = [];

    /**
     * Array of string types or TypeCombination objects
     *
     * @var array
     */
    private $_types;

    /**
     * A list of factory methods to deserialize the given object,
     * for one of the wrapped types in this group
     *
     * @var string[]
     */
    private $_deserializers;

    /**
     * Private constructor for TypeCombination class
     *
     * @param string   $format        string format value
     * @param string   $groupName     group name value
     * @param array    $types         types value
     * @param string[] $deserializers deserializers value
     */
    private function __construct($format, $groupName, $types, $deserializers)
    {
        $this->_format = $format;
        $this->_groupName = $groupName;
        $this->_types = $types;
        $this->_deserializers = $deserializers;
        $this->_insertDiscriminators();
    }

    /**
     * String format of this typeCombinator group.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->_format;
    }

    /**
     * Name of this typeCombinator group i.e. oneOf/anyOf/array/map.
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->_groupName;
    }

    /**
     * Array of string types or TypeCombination objects
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->_types;
    }

    /**
     * A list of factory methods to deserialize the given object,
     * for one of the wrapped types in this group
     *
     * @return string[]
     */
    public function getDeserializers()
    {
        return $this->_deserializers;
    }

    /**
     * Get discriminator info as an array (if exists)
     *
     * @param string               $type              String type to search
     *                                                discriminators
     * @param array<string,string> $discriminatorSubs Map of actual discriminator
     *                                                values where keys contain
     *                                                substituted values in the
     *                                                typeGroup string, Default: []
     *
     * @return array|null An array with format: discriminatorFieldName
     *                    as element 1 and discriminatorValues as
     *                    element 2
     */
    public function getDiscriminator($type, $discriminatorSubs = [])
    {
        if (!isset($this->_discriminatorField)
            || !isset($this->_discriminatorMapping[$type])
        ) {
            return null;
        }
        $fieldName = $this->_discriminatorField;
        if (isset($discriminatorSubs[$fieldName])) {
            $fieldName = $discriminatorSubs[$fieldName];
        }
        $discValues = array_map(
            function ($value) use ($discriminatorSubs) {
                if (isset($discriminatorSubs[$value])) {
                    return $discriminatorSubs[$value];
                }
                return $value;
            },
            $this->_discriminatorMapping[$type]
        );
        return [$fieldName, $discValues];
    }

    /**
     * Extract innermost oneof/anyof group hidden inside array/map
     * type group
     *
     * @return TypeCombination
     */
    public function extractOneOfAnyOfGroup()
    {
        $innerType = $this->getTypes()[0];
        if (in_array($this->getGroupName(), ["array", "map"])
            && $innerType instanceof TypeCombination
        ) {
            return $innerType->extractOneOfAnyOfGroup();
        }
        return $this;
    }

    /**
     * Extract all internal groups similar to the given group as a list of
     * TypeCombination objects, it will only return similar array/map groups
     *
     * @param TypeCombination $group All inner groups similar to this array/map
     *                               type group will be extracted
     *
     * @return TypeCombination[] A list of similar TypeCombination objects
     */
    public function extractSimilar($group)
    {
        $result = [];
        if (!in_array($this->getGroupName(), ["array", "map"])) {
            // if group is neither array nor map then call extractSimilar for
            // each of the internal groups
            foreach ($this->getTypes() as $typ) {
                if ($typ instanceof TypeCombination) {
                    $result = array_merge($result, $typ->extractSimilar($group));
                }
            }
        } elseif ($group->getGroupName() == $this->getGroupName()) {
            // if groupName is same then check inner group type
            $internal = $this->getTypes()[0];
            $group = $group->getTypes()[0];
            if (in_array($group->getGroupName(), ["array", "map"])) {
                // if inner group is array/map then return result after
                // extraction of groups similar to innerGroup
                $result = $internal->extractSimilar($group);
            } else {
                // if inner group is oneof/anyof then only extract $internal
                $result = [$internal];
            }
        }
        return $result;
    }

    /**
     * Extract type info like: isMap, isArray, and inner type for maps/arrays.
     *
     * @param string $type Type to be checked and extracted for information.
     *
     * @return array An array with type info in the format:
     *               (bool isMap, bool isArray, string $internalType).
     */
    public static function extractTypeInfo($type)
    {
        // Check if the type is map, i.e. wrapped in array<string,...>
        if (preg_match('/^array<string,.*>$/', $type)) {
            return [true, false, substr($type, strlen('array<string,'), -1)];
        }

        // Check if the type is array, i.e. ends with '[]'
        if (preg_match('/\[]$/', $type)) {
            return [false, true, substr($type, 0, -2)];
        }

        // Check if the type is array, i.e. wrapped in 'array<...>'
        if (preg_match('/^array<.*>$/', $type)) {
            return [false, true, substr($type, strlen('array<'), -1)];
        }

        // If the type does not match the array formats, return the original type
        return [false, false, $type];
    }

    /**
     * Create an oneof/anyof TypeCombination instance, by specifying inner types
     *
     * @param array  $types i.e. (TypeCombination,string)[]
     * @param string $gName group name value (anyof, oneof),
     *                      Default: anyof
     *
     * @return TypeCombination
     */
    public static function with($types, $gName = 'anyof')
    {
        $format = join(
            ',',
            array_map(
                function ($t) {
                    return is_string($t) ? $t : $t->getFormat();
                },
                $types
            )
        );
        return new self(
            "$gName($format)",
            $gName,
            $types,
            []
        );
    }

    /**
     * Wrap the given typeGroup string in the TypeCombination class,
     * i.e. getTypes() method will return all the grouped types,
     * while deserializing factory methods can be obtained by
     * getDeserializers() and group name can be obtained from getGroupName()
     *
     * @param string   $typeGroup     Format of multiple types i.e oneOf(int,bool)[],
     *                                onyOf(int[], bool,anyOf(string,float)[],...),
     *                                array<string,oneOf(int,float)[]> here []
     *                                represents array types, and array<string,T>
     *                                represents map types, oneOf/anyOf are group
     *                                names, while default group name is anyOf.
     * @param string[] $deserializers Callable factory methods for the property,
     *                                Default: []
     *
     * @return TypeCombination
     */
    public static function withFormat($typeGroup, $deserializers = [])
    {
        $groupName = 'anyOf';
        $start = strpos($typeGroup, '(');
        $end = strrpos($typeGroup, ')');
        if ($start !== false && $end !== false) {
            list($isMap, $isArray, $innerType) = self::extractTypeInfo($typeGroup);
            if ($isMap || $isArray) {
                return self::_createTypeGroup(
                    $isMap ? 'map' : 'array',
                    $innerType,
                    $deserializers
                );
            }
            $name = substr($typeGroup, 0, $start);
            $groupName = empty($name) ? $groupName : $name;
            $typeGroup = substr($typeGroup, $start + 1, -1);
        }
        $format = "($typeGroup)";
        $types = [];
        $type = '';
        $groupCount = 0;
        foreach (str_split($typeGroup) as $c) {
            if ($c == '(' || $c == '<') {
                $groupCount++;
            }
            if ($c == ')' || $c == '>') {
                $groupCount--;
            }
            if ($c == ',' && $groupCount == 0) {
                self::_insertType($types, $type, $deserializers);
                $type = '';
                continue;
            }
            $type .= $c;
        }
        self::_insertType($types, $type, $deserializers);
        return new self($format, $groupName, $types, $deserializers);
    }

    /**
     * Creates a TypeCombination object with the given name and inner
     * types group that must be another typeCombination object
     *
     * @param string   $name          Group name for the typeCombination object.
     * @param string   $type          typeGroup to be created and inserted.
     * @param string[] $deserializers deserializer for the type group.
     *
     * @return TypeCombination
     */
    private static function _createTypeGroup($name, $type, $deserializers)
    {
        $format = $name == 'map' ? "array<string,$type>" : $type . '[]';
        return new self(
            $format,
            $name,
            [self::withFormat($type, $deserializers)],
            $deserializers
        );
    }

    /**
     * Insert the type in the types array which is passed by reference,
     * Also check if type is not empty
     *
     * @param array    $types         types array reference
     * @param string   $type          type to be inserted
     * @param string[] $deserializers deserializer for the type group
     *
     * @return void
     */
    private static function _insertType(&$types, $type, $deserializers)
    {
        $type = trim($type);
        if (strpos($type, '(') !== false && strrpos($type, ')') !== false) {
            // If type is Grouped, creating TypeCombination instance for it
            $type = self::withFormat($type, $deserializers);
        }
        if (!empty($type)) {
            $types[] = $type;
        }
    }

    /**
     * Insert discriminator and discriminators mapping from group and
     * type names.
     *
     * @return void
     */
    private function _insertDiscriminators()
    {
        list($this->_groupName, $this->_discriminatorField)
            = self::_extractDiscriminator($this->_groupName);
        $this->_types = $this->_filterUniqueTypes(
            array_map(
                function ($type) {
                    if (!is_string($type)) {
                        return $type;
                    }
                    list($type, $discriminator)
                        = self::_extractDiscriminator($type);
                    if (array_key_exists($type, $this->_discriminatorMapping)) {
                        $this->_discriminatorMapping[$type][] = $discriminator;
                    } else {
                        $this->_discriminatorMapping[$type] = [$discriminator];
                    }
                    return $type;
                },
                $this->_types
            )
        );
        if (isset($this->_discriminatorField)) {
            $this->_format .= '{' . $this->_discriminatorField . '}';
        }
    }

    /**
     * Filter out the same types.
     *
     * @param array $types Types to be checked for uniqueness.
     *
     * @return array An array with all the unique types
     */
    private function _filterUniqueTypes($types)
    {
        $seenTypes = [];
        $uniqueTypes = [];
        foreach ($types as $type) {
            if (is_string($type)) {
                if (in_array($type, $seenTypes, true)) {
                    continue;
                }
                $seenTypes[] = $type;
            }
            $uniqueTypes[] = $type;
        }
        return $uniqueTypes;
    }

    /**
     * Extract type discriminator.
     *
     * @param string $type Type to be checked and extracted for discriminator.
     *
     * @return array An array with type info in the format:
     *               (string $typeWithoutDiscriminator, string? discriminator).
     */
    private function _extractDiscriminator($type)
    {
        $start = strpos($type, '{');
        $end = strpos($type, '}');
        $discriminator = null;
        if ($start !== false && $end !== false) {
            $discriminator = substr($type, $start + 1, $end - strlen($type));
            $type = substr($type, 0, $start) . substr($type, $end + 1);
        }
        return [$type, $discriminator];
    }
}
