<?php

declare(strict_types=1);

namespace Igniter\Flame\Mail;

/**
 * This class parses Mail templates.
 * Returns the structured file information.
 */
class MailParser
{
    public const SECTION_SEPARATOR = '==';

    /**
     * Parses Mail template content.
     * The expected file format is following:
     * <pre>
     * Settings section
     * ==
     * Plain-text content section
     * ==
     * HTML content section
     * </pre>
     * If the content has only 2 sections they are considered as settings and HTML.
     * If there is only a single section, it is considered as HTML.
     * @param string $content Specifies the file content.
     * @return array Returns an array with the following indexes: 'settings', 'html', 'text'.
     * The 'html' and 'text' elements contain strings. The 'settings' element contains the
     * parsed INI file as array. If the content string doesn't contain a section, the corresponding
     * result element has null value.
     */
    public static function parse($content): array
    {
        $sections = preg_split('/^={2,}\s*/m', $content, -1);
        $count = count($sections);
        $sections = array_map('trim', $sections);

        $result = [
            'settings' => [],
            'html' => null,
            'text' => null,
        ];

        if ($count >= 3) {
            $result['settings'] = parse_ini_string($sections[0], true);
            $result['text'] = $sections[1];
            $result['html'] = $sections[2];
        } elseif ($count === 2) {
            $result['settings'] = parse_ini_string($sections[0], true);
            $result['html'] = $sections[1];
        } elseif ($count === 1) {
            $result['html'] = $sections[0];
        }

        return $result;
    }
}
