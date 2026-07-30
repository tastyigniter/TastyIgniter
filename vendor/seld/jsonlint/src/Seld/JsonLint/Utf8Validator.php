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
 * Validates that a string is well-formed UTF-8 as defined by RFC 3629.
 *
 * @author Laurent Lyaudet <laurent.lyaudet@gmail.com>
 */
class Utf8Validator
{
    /**
     * Lowest value a continuation octet (10xxxxxx) may take.
     *
     * @private
     */
    const CONTINUATION_OCTET_MINIMUM = 128;

    /**
     * Highest value a continuation octet (10xxxxxx) may take.
     *
     * @private
     */
    const CONTINUATION_OCTET_MAXIMUM = 191;

    /**
     * Validates that the whole input string is valid UTF-8.
     *
     * @param  string $input
     * @return void
     * @throws InvalidEncodingException if the input is not valid UTF-8
     */
    public static function validate($input)
    {
        // Fast-path
        // But before PHP 5.4 Unicode support has bugs.
        $useFastPath = PHP_VERSION_ID >= 50400;
        if ($useFastPath) {
            if (function_exists("mb_check_encoding")) {
                if (mb_check_encoding($input, 'UTF-8')) {
                    return;
                }
            } else {
                if (preg_match('//u', $input) === 1) {
                    return;
                }
            }
        }

        $currentOctet = null;
        $continuationOctetNeeded = 0;
        $offsetInOctetsFromStringStart = 0;
        $offsetInCharactersFromStringStart = -1;
        $characterStartPositionFromStringStart = 0;
        $currentLineNumber = 1;
        $offsetInOctetsFromLineStart = -1;
        $offsetInCharactersFromLineStart = -1;
        $characterStartPositionFromLineStart = -1;

        // For the second octet of a character, hence first continuation octet,
        // further restriction may apply.
        $currentContinuationOctetMinimum = self::CONTINUATION_OCTET_MINIMUM;
        $currentContinuationOctetMaximum = self::CONTINUATION_OCTET_MAXIMUM;
        $messageForContinuationOctetAboveMaximum = null;

        for ($i = 0, $max = strlen($input); $i < $max; ++$i) {
            $currentOctet = ord($input[$i]);
            $offsetInOctetsFromStringStart = $i;
            ++$offsetInOctetsFromLineStart;

            /*
            The octet values C0, C1, F5 to FF never appear.
            C0 = 12*16      = 192 = 11000000
            C1 = 12*16 + 1  = 193 = 11000001
            F5 = 15*16 + 5  = 245 = 11110101
            FF = 15*16 + 15 = 255 = 11111111
            */
            if (
                $currentOctet === 192
                || $currentOctet === 193
                || $currentOctet === 245
                || $currentOctet === 255
            ) {
                throw self::createException(
                    " which is one of the four forbidden values (C0, C1, F5, FF).",
                    (string) $currentOctet,
                    array(
                        'current_octet' => $currentOctet,
                        'continuation_octet_needed' => $continuationOctetNeeded,
                        'offset_in_octets_from_string_start' => $offsetInOctetsFromStringStart,
                        'offset_in_characters_from_string_start' => $offsetInCharactersFromStringStart,
                        'character_start_position_from_string_start' => $characterStartPositionFromStringStart,
                        'line' => $currentLineNumber,
                        'offset_in_octets_from_line_start' => $offsetInOctetsFromLineStart,
                        'offset_in_characters_from_line_start' => $offsetInCharactersFromLineStart,
                        'character_start_position_from_line_start' => $characterStartPositionFromLineStart,
                        'current_continuation_octet_minimum' => $currentContinuationOctetMinimum,
                        'current_continuation_octet_maximum' => $currentContinuationOctetMaximum,
                    )
                );
            }

            /*
            UTF8-octets = *( UTF8-char )
            UTF8-char   = UTF8-1 / UTF8-2 / UTF8-3 / UTF8-4
            UTF8-1      = %x00-7F
            UTF8-2      = %xC2-DF UTF8-tail
              Notice that values C0 and C1 are forbidden, hence %xC2
            UTF8-3      = %xE0 %xA0-BF UTF8-tail / %xE1-EC 2( UTF8-tail ) /
                          %xED %x80-9F UTF8-tail / %xEE-EF 2( UTF8-tail )
              Notice that E0 = 224 adds a restriction on second octet.
              Notice that ED = 237 adds a restriction on second octet.
            UTF8-4      = %xF0 %x90-BF 2( UTF8-tail ) / %xF1-F3 3( UTF8-tail ) /
                          %xF4 %x80-8F 2( UTF8-tail )
              Notice that F0 = 240 adds a restriction on second octet.
              Notice that F4 = 244 adds a restriction on second octet.
            UTF8-tail   = %x80-BF
            */
            if ($continuationOctetNeeded > 0) {
                if (
                    $currentOctet < $currentContinuationOctetMinimum
                    || $currentOctet > $currentContinuationOctetMaximum
                ) {
                    $reason =
                        $messageForContinuationOctetAboveMaximum !== null
                        && $currentOctet > $currentContinuationOctetMaximum
                        ? $messageForContinuationOctetAboveMaximum
                        : " which is not a continuation octet.";
                    throw self::createException(
                        $reason,
                        (string) $currentOctet,
                        array(
                            'current_octet' => $currentOctet,
                            'continuation_octet_needed' => $continuationOctetNeeded,
                            'offset_in_octets_from_string_start' => $offsetInOctetsFromStringStart,
                            'offset_in_characters_from_string_start' => $offsetInCharactersFromStringStart,
                            'character_start_position_from_string_start' => $characterStartPositionFromStringStart,
                            'line' => $currentLineNumber,
                            'offset_in_octets_from_line_start' => $offsetInOctetsFromLineStart,
                            'offset_in_characters_from_line_start' => $offsetInCharactersFromLineStart,
                            'character_start_position_from_line_start' => $characterStartPositionFromLineStart,
                            'current_continuation_octet_minimum' => $currentContinuationOctetMinimum,
                            'current_continuation_octet_maximum' => $currentContinuationOctetMaximum,
                        )
                    );
                }
                --$continuationOctetNeeded;
                $currentContinuationOctetMinimum = self::CONTINUATION_OCTET_MINIMUM;
                $currentContinuationOctetMaximum = self::CONTINUATION_OCTET_MAXIMUM;
                $messageForContinuationOctetAboveMaximum = null;
                continue;
            }

            ++$offsetInCharactersFromStringStart;
            ++$offsetInCharactersFromLineStart;
            $characterStartPositionFromStringStart = $offsetInOctetsFromStringStart;
            $characterStartPositionFromLineStart = $offsetInOctetsFromLineStart;

            if ($currentOctet < 128) { // 0xxxxxxx ASCII
                // if ($input[$i] === "\n") {
                if ($currentOctet === 10) {
                    ++$currentLineNumber;
                    $offsetInOctetsFromLineStart = -1;
                    $offsetInCharactersFromLineStart = -1;
                }
                continue;
            }

            if (/*$currentOctet >= 128 &&*/$currentOctet < 192) {
                throw self::createException(
                    " which is a continuation octet.",
                    (string) $currentOctet,
                    array(
                        'current_octet' => $currentOctet,
                        'continuation_octet_needed' => $continuationOctetNeeded,
                        'offset_in_octets_from_string_start' => $offsetInOctetsFromStringStart,
                        'offset_in_characters_from_string_start' => $offsetInCharactersFromStringStart,
                        'character_start_position_from_string_start' => $characterStartPositionFromStringStart,
                        'line' => $currentLineNumber,
                        'offset_in_octets_from_line_start' => $offsetInOctetsFromLineStart,
                        'offset_in_characters_from_line_start' => $offsetInCharactersFromLineStart,
                        'character_start_position_from_line_start' => $characterStartPositionFromLineStart,
                        'current_continuation_octet_minimum' => $currentContinuationOctetMinimum,
                        'current_continuation_octet_maximum' => $currentContinuationOctetMaximum,
                    )
                );
            }

            if (/*$currentOctet >= 192 &&*/$currentOctet < 224) {
                // 110xxxxx 10xxxxxx
                $continuationOctetNeeded = 1;
                continue;
            }
            if (/*$currentOctet >= 224 &&*/$currentOctet < 240) {
                // 1110xxxx 10xxxxxx 10xxxxxx
                $continuationOctetNeeded = 2;
                /*
                UTF8-3 = %xE0 %xA0-BF UTF8-tail / %xE1-EC 2( UTF8-tail ) /
                         %xED %x80-9F UTF8-tail / %xEE-EF 2( UTF8-tail )
                Notice that E0 = 224 adds a restriction on second octet.
                Notice that ED = 237 adds a restriction on second octet.

                The definition of UTF-8 prohibits encoding character numbers between
                U+D800 and U+DFFF.
                D8 = 13*16 + 8  = 216 = 11010100
                DF = 13*16 + 15 = 223 = 11010101
                216*256 = 55296       = 1101 1000 0000 0000 = D800
                to
                223*256 + 255 = 57343 = 1101 1111 1111 1111 = DFFF

                1110xxxx
                11101101 = 237 = ED

                237,160,128
                237,191,191
                Thus, the whole "continuation range" is forbidden if start
                is 237 and second octet, first continuation octet,
                is >= 160.
                */
                if ($currentOctet === 224) {
                    $currentContinuationOctetMinimum = 160;
                    $currentContinuationOctetMaximum = 191;  // Normal value
                }
                if ($currentOctet === 237) {
                    $currentContinuationOctetMinimum = 128;  // Normal value
                    $currentContinuationOctetMaximum = 159;
                    $messageForContinuationOctetAboveMaximum =
                        " which is into the forbidden range of surrogate pairs.";
                }
                continue;
            }
            if (/*$currentOctet >= 240 &&*/$currentOctet < /*248*/ 245) {
                // 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
                $continuationOctetNeeded = 3;
                /*
                UTF8-4 = %xF0 %x90-BF 2( UTF8-tail ) / %xF1-F3 3( UTF8-tail ) /
                         %xF4 %x80-8F 2( UTF8-tail )
                Notice that F0 = 240 adds a restriction on second octet.
                Notice that F4 = 244 adds a restriction on second octet.
                */
                if ($currentOctet === 240) {
                    $currentContinuationOctetMinimum = 144;
                    $currentContinuationOctetMaximum = 191;  // Normal value
                }
                if ($currentOctet === 244) {
                    $currentContinuationOctetMinimum = 128;  // Normal value
                    $currentContinuationOctetMaximum = 143;
                }
                continue;
            }
            throw self::createException(
                " which is invalid.",
                (string) $currentOctet,
                array(
                    'current_octet' => $currentOctet,
                    'continuation_octet_needed' => $continuationOctetNeeded,
                    'offset_in_octets_from_string_start' => $offsetInOctetsFromStringStart,
                    'offset_in_characters_from_string_start' => $offsetInCharactersFromStringStart,
                    'character_start_position_from_string_start' => $characterStartPositionFromStringStart,
                    'line' => $currentLineNumber,
                    'offset_in_octets_from_line_start' => $offsetInOctetsFromLineStart,
                    'offset_in_characters_from_line_start' => $offsetInCharactersFromLineStart,
                    'character_start_position_from_line_start' => $characterStartPositionFromLineStart,
                    'current_continuation_octet_minimum' => $currentContinuationOctetMinimum,
                    'current_continuation_octet_maximum' => $currentContinuationOctetMaximum,
                )
            );
        }
        if ($continuationOctetNeeded > 0) {
            throw self::createException(
                "",
                "0",
                array(
                    'current_octet' => $currentOctet,
                    'continuation_octet_needed' => $continuationOctetNeeded,
                    'offset_in_octets_from_string_start' => $offsetInOctetsFromStringStart,
                    'offset_in_characters_from_string_start' => $offsetInCharactersFromStringStart,
                    'character_start_position_from_string_start' => $characterStartPositionFromStringStart,
                    'line' => $currentLineNumber,
                    'offset_in_octets_from_line_start' => $offsetInOctetsFromLineStart,
                    'offset_in_characters_from_line_start' => $offsetInCharactersFromLineStart,
                    'character_start_position_from_line_start' => $characterStartPositionFromLineStart,
                    'current_continuation_octet_minimum' => $currentContinuationOctetMinimum,
                    'current_continuation_octet_maximum' => $currentContinuationOctetMaximum,
                ),
                true
            );
        }
        // The fast-path flagged this input as invalid UTF-8, yet the manual RFC 3629
        // scan above found no fault. The two must always agree, so reaching here means
        // the fast-path caught something the scan missed - surface it rather than
        // silently accepting the input as valid.
        if ($useFastPath) {
            throw new InvalidEncodingException(
                "Fast-path detected an error that the manual scan could not find. "
                ."Please report it at https://github.com/Seldaek/jsonlint/issues.",
                "0",
                array(
                    'current_octet' => $currentOctet,
                    'continuation_octet_needed' => $continuationOctetNeeded,
                    'offset_in_octets_from_string_start' => $offsetInOctetsFromStringStart,
                    'offset_in_characters_from_string_start' => $offsetInCharactersFromStringStart,
                    'character_start_position_from_string_start' => $characterStartPositionFromStringStart,
                    'line' => $currentLineNumber,
                    'offset_in_octets_from_line_start' => $offsetInOctetsFromLineStart,
                    'offset_in_characters_from_line_start' => $offsetInCharactersFromLineStart,
                    'character_start_position_from_line_start' => $characterStartPositionFromLineStart,
                    'current_continuation_octet_minimum' => $currentContinuationOctetMinimum,
                    'current_continuation_octet_maximum' => $currentContinuationOctetMaximum,
                )
            );
        }
    }

    /**
     * Builds the InvalidEncodingException thrown by validate().
     *
     * The message scaffold is shared by every detection branch; only the
     * "$reason" fragment (appended after "has value N") and the end-of-string
     * wording differ between call sites.
     *
     * @param  string $reason     explanation appended after the octet value (ignored when $endOfInput is true)
     * @param  string $key        the offending octet value, as a string
     * @param  bool   $endOfInput whether the input ended in the middle of a multi-octet character
     * @return InvalidEncodingException
     *
     * @phpstan-param array{current_octet: int|null, continuation_octet_needed: int, offset_in_octets_from_string_start: int, offset_in_characters_from_string_start: int, character_start_position_from_string_start: int, line: int, offset_in_octets_from_line_start: int, offset_in_characters_from_line_start: int, character_start_position_from_line_start: int, current_continuation_octet_minimum: int, current_continuation_octet_maximum: int} $details
     */
    private static function createException($reason, $key, array $details, $endOfInput = false)
    {
        if ($endOfInput) {
            $middle =
                "; at octet "
                .($details['offset_in_octets_from_line_start'] + 1)
                .", part of the character "
                .($details['offset_in_characters_from_line_start'] + 1)
                .", end of string was found instead of a continuation octet.";
        } else {
            $middle =
                "; the octet "
                .($details['offset_in_octets_from_line_start'] + 1)
                .", part of the character "
                .($details['offset_in_characters_from_line_start'] + 1)
                .", has value "
                .$details['current_octet']
                .$reason;
        }

        $message =
            "Non-UTF8 character found on line "
            .$details['line']
            .$middle
            ." This character starts at octet "
            .($details['character_start_position_from_line_start'] + 1)
            ." of the current line."
            ." (Sequential positions without line splitting:"
            ." This is at character "
            .($details['offset_in_characters_from_string_start'] + 1)
            ." and octet "
            .($details['offset_in_octets_from_string_start'] + 1)
            ."."
            ." This character starts at octet "
            .($details['character_start_position_from_string_start'] + 1)
            .".)";

        return new InvalidEncodingException($message, $key, $details);
    }
}
