<?php

declare(strict_types=1);

namespace JsonSchema\Constraints\Drafts\Draft2019;

use DateTimeZone;
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
                if (!$this->validateDateTime($value, 'H:i:sp') && !$this->validateDateTime($value, 'H:i:s.up')) {
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
            case 'idn-hostname':
                if (!$this->validateInternationalizedHostname($value)) {
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
        $datetime = strtoupper($datetime); // Cleanup for lowercase z
        $isLeap = substr($datetime, 6, 2) === '60';
        $input = $datetime;

        // Correct for leap second
        if ($isLeap) {
            $input = sprintf('%s59%s', substr($datetime, 0, 6), substr($datetime, 8));
        }

        $dt = \DateTimeImmutable::createFromFormat($format, $input);
        if (!$dt) {
            return false;
        }

        // Handle invalid timezone offsets
        $timezoneOffset = $dt->getTimezone()->getOffset($dt);
        if ($timezoneOffset >= 86400 || $timezoneOffset <= -86400) {
            return false;
        }

        $expected = $dt->format($format);
        // Correct for trailing zeros on microseconds
        if ($format === 'H:i:s.up') {
            $expected = sprintf(
                '%s%s',
                rtrim($dt->format('H:i:s.u'), '0'),
                $dt->format('p')
            );
        }
        // Correct back for leap seconds
        if ($isLeap) {
            // Only when 23:59:59 in UTC
            $utcDT = $dt->setTimezone(new DateTimeZone('UTC'));
            if ($utcDT->format('H:i:s') !== '23:59:59') {
                return false;
            }

            $expected = sprintf('%s60%s', substr($expected, 0, 6), substr($expected, 8));
        }

        return $datetime === $expected;
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

    private function validateInternationalizedHostname(string $host): bool
    {
        if ($host === '') {
            return false;
        }
        $host = rtrim($host, '.');
        $labels = explode('.', $host);
        $asciiLabels = [];

        foreach ($labels as $label) {
            if ($label === '') {
                return false;
            }

            // CONTEXTJ / CONTEXTO checks
            if (
                // Greek KERAIA U+0375
                preg_match('/\x{0375}/u', $label) &&
                !preg_match('/\x{0375}[\x{0370}-\x{03FF}]/u', $label)
            ) {
                return false;
            }

            // Hebrew GERESH / GERSHAYIM U+05F3 / U+05F4
            if (preg_match('/[\x{05F3}\x{05F4}]/u', $label) &&
                !preg_match('/[\x{0590}-\x{05FF}][\x{05F3}\x{05F4}]/u', $label)
            ) {
                return false;
            }

            // Katakana middle dot U+30FB
            if (str_contains($label, "\u{30FB}") &&
                !preg_match('/[\x{30A0}-\x{30FF}]/u', $label)
            ) {
                return false;
            }

            // Arabic digit mixing
            $hasArabicIndic = preg_match('/[\x{0660}-\x{0669}]/u', $label);
            $hasExtArabicIndic = preg_match('/[\x{06F0}-\x{06F9}]/u', $label);
            if ($hasArabicIndic && $hasExtArabicIndic) {
                return false;
            }

            // Devanagari danda U+0964 / U+0965
            if (preg_match('/[\x{0964}\x{0965}]/u', $label) &&
                !preg_match('/[\x{0900}-\x{097F}]/u', $label)
            ) {
                return false;
            }

            // ZWNJ / ZWJ U+200C / U+200D
            if (preg_match('/[\x{200C}\x{200D}]/u', $label)) {
                return false;
            }

            $ascii = idn_to_ascii($label);
            if ($ascii === false) {
                return false;
            }
            // DNS label length
            if (strlen($ascii) > 63) {
                return false;
            }
            // LDH rule (after IDNA)
            if (!preg_match('/^[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i', $ascii)) {
                return false;
            }
            $asciiLabels[] = $ascii;
        }

        // Total hostname length (ASCII)
        $asciiHost = implode('.', $asciiLabels);

        return strlen($asciiHost) <= 253;
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
