<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft06;

use JsonSchema\ConstraintError;
use JsonSchema\Constraints\ConstraintInterface;
use JsonSchema\Constraints\Factory;
use JsonSchema\Entity\ErrorBagProxy;
use JsonSchema\Entity\JsonPointer;
use JsonSchema\Rfc3339;
use JsonSchema\Tool\Validator\RelativeReferenceValidator;
use JsonSchema\Tool\Validator\UriValidator;

class FormatConstraint implements ConstraintInterface
{
    use ErrorBagProxy;

    public function __construct(?Factory $factory = null)
    {
        $this->initialiseErrorBag($factory ?: new Factory());
    }

    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null): void
    {
        if (!property_exists($schema, 'format')) {
            return;
        }

        if (!is_string($value)) {
            return;
        }

        switch ($schema->format) {
            case 'date':
                if (!$this->validateDateTime($value, 'Y-m-d')) {
                    $this->addError(ConstraintError::FORMAT_DATE(), $path, ['date' => $value, 'format' => $schema->format]);
                }
                break;
            case 'time':
                if (!$this->validateDateTime($value, 'H:i:s')) {
                    $this->addError(ConstraintError::FORMAT_TIME(), $path, ['time' => $value, 'format' => $schema->format]);
                }
                break;
            case 'date-time':
                if (!$this->validateRfc3339DateTime($value)) {
                    $this->addError(ConstraintError::FORMAT_DATE_TIME(), $path, ['dateTime' => $value, 'format' => $schema->format]);
                }
                break;
            case 'utc-millisec':
                if (!$this->validateDateTime($value, 'U')) {
                    $this->addError(ConstraintError::FORMAT_DATE_UTC(), $path, ['value' => $value, 'format' => $schema->format]);
                }
                break;
            case 'regex':
                if (!$this->validateRegex($value)) {
                    $this->addError(ConstraintError::FORMAT_REGEX(), $path, ['value' => $value, 'format' => $schema->format]);
                }
                break;
            case 'ip-address':
            case 'ipv4':
                if (filter_var($value, FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE | FILTER_FLAG_IPV4) === null) {
                    $this->addError(ConstraintError::FORMAT_IP(), $path, ['format' => $schema->format]);
                }
                break;
            case 'ipv6':
                if (filter_var($value, FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE | FILTER_FLAG_IPV6) === null) {
                    $this->addError(ConstraintError::FORMAT_IP(), $path, ['format' => $schema->format]);
                }
                break;
            case 'color':
                if (!$this->validateColor($value)) {
                    $this->addError(ConstraintError::FORMAT_COLOR(), $path, ['format' => $schema->format]);
                }
                break;
            case 'style':
                if (!$this->validateStyle($value)) {
                    $this->addError(ConstraintError::FORMAT_STYLE(), $path, ['format' => $schema->format]);
                }
                break;
            case 'phone':
                if (!$this->validatePhone($value)) {
                    $this->addError(ConstraintError::FORMAT_PHONE(), $path, ['format' => $schema->format]);
                }
                break;
            case 'uri':
                if (!UriValidator::isValid($value)) {
                    $this->addError(ConstraintError::FORMAT_URL(), $path, ['format' => $schema->format]);
                }
                break;

            case 'uriref':
            case 'uri-reference':
                if (!(UriValidator::isValid($value) || RelativeReferenceValidator::isValid($value))) {
                    $this->addError(ConstraintError::FORMAT_URL(), $path, ['format' => $schema->format]);
                }
                break;
            case 'uri-template':
                if (!$this->validateUriTemplate($value)) {
                    $this->addError(ConstraintError::FORMAT_URI_TEMPLATE(), $path, ['format' => $schema->format]);
                }
                break;

            case 'email':
                if (filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE | FILTER_FLAG_EMAIL_UNICODE) === null) {
                    $this->addError(ConstraintError::FORMAT_EMAIL(), $path, ['format' => $schema->format]);
                }
                break;
            case 'host-name':
            case 'hostname':
                if (!$this->validateHostname($value)) {
                    $this->addError(ConstraintError::FORMAT_HOSTNAME(), $path, ['format' => $schema->format]);
                }
                break;
            case 'json-pointer':
                if (!$this->validateJsonPointer($value)) {
                    $this->addError(ConstraintError::FORMAT_JSON_POINTER(), $path, ['format' => $schema->format]);
                }
                break;
            default:
                break;
        }
    }

    private function validateDateTime(string $datetime, string $format): bool
    {
        $dt = \DateTime::createFromFormat($format, $datetime);

        if (!$dt) {
            return false;
        }

        return $datetime === $dt->format($format);
    }

    private function validateRegex(string $regex): bool
    {
        return preg_match(self::jsonPatternToPhpRegex($regex), '') !== false;
    }

    /**
     * Transform a JSON pattern into a PCRE regex
     */
    private static function jsonPatternToPhpRegex(string $pattern): string
    {
        return '~' . str_replace('~', '\\~', $pattern) . '~u';
    }

    private function validateColor(string $color): bool
    {
        if (in_array(strtolower($color), ['aqua', 'black', 'blue', 'fuchsia',
            'gray', 'green', 'lime', 'maroon', 'navy', 'olive', 'orange', 'purple',
            'red', 'silver', 'teal', 'white', 'yellow'])) {
            return true;
        }

        return preg_match('/^#([a-f0-9]{3}|[a-f0-9]{6})$/i', $color) === 1;
    }

    private function validateStyle(string $style): bool
    {
        $properties     = explode(';', rtrim($style, ';'));
        $invalidEntries = preg_grep('/^\s*[-a-z]+\s*:\s*.+$/i', $properties, PREG_GREP_INVERT);

        return empty($invalidEntries);
    }

    private function validatePhone(string $phone): bool
    {
        return preg_match('/^\+?(\(\d{3}\)|\d{3}) \d{3} \d{4}$/', $phone) === 1;
    }

    private function validateHostname(string $host): bool
    {
        $hostnameRegex = '/^(?!-)(?!.*?[^A-Za-z0-9\-\.])(?:(?!-)[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?\.)*(?!-)[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?$/';

        return preg_match($hostnameRegex, $host) === 1;
    }

    private function validateJsonPointer(string $value): bool
    {
        // Must be empty or start with a forward slash
        if ($value !== '' && $value[0] !== '/') {
            return false;
        }

        // Split into reference tokens and check for invalid escape sequences
        $tokens = explode('/', $value);
        array_shift($tokens); // remove leading empty part due to leading slash

        foreach ($tokens as $token) {
            // "~" must only be followed by "0" or "1"
            if (preg_match('/~(?![01])/', $token)) {
                return false;
            }
        }

        return true;
    }

    private function validateRfc3339DateTime(string $value): bool
    {
        $dateTime = Rfc3339::createFromString($value);
        if (is_null($dateTime)) {
            return false;
        }

        // Compare value and date result to be equal
        return true;
    }

    private function validateUriTemplate(string $value): bool
    {
        return preg_match(
            '/^(?:[^\{\}]*|\{[a-zA-Z0-9_:%\/\.~\-\+\*]+\})*$/',
            $value
        ) === 1;
    }
}
