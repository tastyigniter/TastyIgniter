<?php

/*
 * This file is part of the JSON Lint package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seld\JsonLint;

/**
 * @author Laurent Lyaudet <laurent.lyaudet@gmail.com>
 */
class InvalidEncodingException extends ParsingException
{
    /**
     * @var array{key: string, current_octet: int|null, continuation_octet_needed: int, offset_in_octets_from_string_start: int, offset_in_characters_from_string_start: int, character_start_position_from_string_start: int, line: int, offset_in_octets_from_line_start: int, offset_in_characters_from_line_start: int, character_start_position_from_line_start: int, current_continuation_octet_minimum: int, current_continuation_octet_maximum: int}
     */
    protected $details;

    /**
     * @param string $message
     * @param string $key
     * @phpstan-param array{current_octet: int|null, continuation_octet_needed: int, offset_in_octets_from_string_start: int, offset_in_characters_from_string_start: int, character_start_position_from_string_start: int, line: int, offset_in_octets_from_line_start: int, offset_in_characters_from_line_start: int, character_start_position_from_line_start: int, current_continuation_octet_minimum: int, current_continuation_octet_maximum: int} $details
     */
    public function __construct($message, $key, array $details)
    {
        $details['key'] = $key;
        parent::__construct($message, $details);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->details['key'];
    }

    /**
     * @phpstan-return array{key: string, current_octet: int|null, continuation_octet_needed: int, offset_in_octets_from_string_start: int, offset_in_characters_from_string_start: int, character_start_position_from_string_start: int, line: int, offset_in_octets_from_line_start: int, offset_in_characters_from_line_start: int, character_start_position_from_line_start: int, current_continuation_octet_minimum: int, current_continuation_octet_maximum: int}
     */
    public function getDetails()
    {
        return $this->details;
    }
}
