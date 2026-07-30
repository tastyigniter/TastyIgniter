<?php
namespace Rs\Json;

use Rs\Json\Pointer\InvalidJsonException;
use Rs\Json\Pointer\InvalidPointerException;
use Rs\Json\Pointer\NonexistentValueReferencedException;
use Rs\Json\Pointer\NonWalkableJsonException;

class Pointer
{
    const POINTER_CHAR = '/';
    const LAST_ARRAY_ELEMENT_CHAR = '-';

    /**
     * @var array
     */
    private $json;

    /**
     * @var string
     */
    private $pointer;

    /**
     * @param  string $json The Json structure to point through.
     * @throws \Rs\Json\Pointer\InvalidJsonException
     * @throws \Rs\Json\Pointer\NonWalkableJsonException
     */
    public function __construct($json)
    {
        $this->json = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException('Cannot operate on invalid Json.');
        }

        if (!$this->isWalkableJson()) {
            throw new NonWalkableJsonException('Non walkable Json to point through');
        }
    }

    /**
     * @param  string $pointer The Json Pointer.
     * @throws \Rs\Json\Pointer\InvalidPointerException
     * @throws \Rs\Json\Pointer\NonexistentValueReferencedException
     *
     * @return mixed
     */
    public function get($pointer)
    {
        if ($pointer === '') {
            $output = json_encode($this->json, JSON_UNESCAPED_UNICODE);
            // workaround for https://bugs.php.net/bug.php?id=46600
            return str_replace('"_empty_"', '""', $output);
        }

        $this->validatePointer($pointer);

        $this->pointer = $pointer;

        $plainPointerParts = array_slice(
            array_map('urldecode', explode('/', $pointer)),
            1
        );
        return $this->traverse($this->json, $this->evaluatePointerParts($plainPointerParts));
    }

    /**
     * @return string
     */
    public function getPointer()
    {
        return $this->pointer;
    }

    /**
     * @param  array|\stdClass $json The json_decoded Json structure.
     * @param  array $pointerParts   The parts of the fed pointer.
     *
     * @throws \Rs\Json\Pointer\NonexistentValueReferencedException
     *
     * @return mixed
     */
    private function traverse(&$json, array $pointerParts)
    {
        $pointerPart = array_shift($pointerParts);

        if (is_array($json) && isset($json[$pointerPart])) {
            if (count($pointerParts) === 0) {
                return $json[$pointerPart];
            }
            if ((is_array($json[$pointerPart]) || is_object($json[$pointerPart])) && is_array($pointerParts)) {
                return $this->traverse($json[$pointerPart], $pointerParts);
            }
        } elseif (is_object($json) && in_array($pointerPart, array_keys(get_object_vars($json)))) {
            if (count($pointerParts) === 0) {
                return $json->{$pointerPart};
            }
            if ((is_object($json->{$pointerPart}) || is_array($json->{$pointerPart})) && is_array($pointerParts)) {
                return $this->traverse($json->{$pointerPart}, $pointerParts);
            }
        } elseif (is_object($json) && empty($pointerPart) && array_key_exists('_empty_', get_object_vars($json))) {
            $pointerPart = '_empty_';
            if (count($pointerParts) === 0) {
                return $json->{$pointerPart};
            }
            if ((is_object($json->{$pointerPart}) || is_array($json->{$pointerPart})) && is_array($pointerParts)) {
                return $this->traverse($json->{$pointerPart}, $pointerParts);
            }
        } elseif ($pointerPart === self::LAST_ARRAY_ELEMENT_CHAR && is_array($json)) {
            return end($json);
        } elseif (is_array($json) && count($json) < $pointerPart) {
            // Do nothing, let Exception bubble up
        } elseif (is_array($json) && array_key_exists($pointerPart, $json) && $json[$pointerPart] === null) {
            return $json[$pointerPart];
        }
        $exceptionMessage = sprintf(
            "Json Pointer '%s' references a nonexistent value",
            $this->getPointer()
        );
        throw new NonexistentValueReferencedException($exceptionMessage);
    }

    /**
     * @return boolean
     */
    private function isWalkableJson()
    {
        if ($this->json !== null && (is_array($this->json) || $this->json instanceof \stdClass)) {
            return true;
        }
        return false;
    }

    /**
     * @param  string $pointer The Json Pointer to validate.
     * @throws \Rs\Json\Pointer\InvalidPointerException
     */
    private function validatePointer($pointer)
    {
        if ($pointer !== '' && !is_string($pointer)) {
            throw new InvalidPointerException('Pointer is not a string');
        }

        $firstPointerCharacter = substr($pointer, 0, 1);

        if ($firstPointerCharacter !== self::POINTER_CHAR) {
            throw new InvalidPointerException('Pointer starts with invalid character');
        }
    }

    /**
     * @param  array $pointerParts The Json Pointer parts to evaluate.
     *
     * @return array
     */
    private function evaluatePointerParts(array $pointerParts)
    {
        $searchables = array('~1', '~0');
        $evaluations = array('/', '~');

        $parts = array();
        array_filter($pointerParts, function ($v) use (&$parts, &$searchables, &$evaluations) {
            return $parts[] = str_replace($searchables, $evaluations, $v);
        });
        return $parts;
    }
}
