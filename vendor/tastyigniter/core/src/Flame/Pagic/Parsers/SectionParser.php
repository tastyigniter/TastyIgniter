<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Parsers;

use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class SectionParser
{
    public const SOURCE_SEPARATOR = '---';

    /**
     * Parses a page or layout file content.
     * The expected file format is following:
     * <pre>
     * ---
     * Data (frontmatter) section
     * ---
     * PHP code section
     * ---
     * Html markup section
     * </pre>
     * If the content has only 2 sections they are considered as Data and Html.
     * If there is only a single section, it is considered as Html.
     *
     * @param string $content The file content.
     *
     * @return array Returns an array with the following indexes: 'data', 'markup', 'code'.
     * The 'markup' and 'code' elements contain strings. The 'settings' element contains the
     * parsed Data as array. If the content string does not contain a section, the corresponding
     * result element has null value.
     */
    public static function parse(?string $content): array
    {
        $separator = static::SOURCE_SEPARATOR;

        // Split the document into three sections.
        $doc = explode($separator, (string)$content);

        $count = count($doc);

        $result = [
            'settings' => null,
            'code' => null,
            'markup' => null,
        ];

        // Data, code and markup
        if ($count === 4) {
            $frontMatter = trim($doc[1]);
            $result['settings'] = self::parseSettings($frontMatter);
            $result['code'] = trim($doc[2]);
            $result['markup'] = $doc[3];
        } // Data and markup
        elseif ($count === 3) {
            $frontMatter = trim($doc[1]);
            $result['settings'] = self::parseSettings($frontMatter);
            $result['markup'] = $doc[2];
        } // Only markup
        elseif ($count === 2) {
            $result['code'] = trim($doc[0]);
            $result['markup'] = $doc[1];
        } // Only markup, no separator
        elseif ($count === 1 && !is_null($content)) {
            $result['markup'] = $doc[0];
        }

        return $result;
    }

    /**
     * Renders a page or layout object as file content.
     */
    public static function render(array $data): string
    {
        $code = trim((string)array_get($data, 'code'));
        $markup = trim((string)array_get($data, 'markup'));
        $settings = array_get($data, 'settings', []);

        // Build content
        $content = [];

        if ($settings) {
            $content[] = self::renderSettings($settings);
        }

        if (!empty($code)) {
            $code = preg_replace('/^\<\?php/', '', $code);
            $code = preg_replace('/^\<\?/', '', (string)preg_replace('/\?>$/', '', (string)$code));

            $code = trim((string)$code, PHP_EOL);
            $content[] = '<?php'.PHP_EOL.$code.PHP_EOL.'?>';
        }

        $content[] = $markup;

        return trim(implode(PHP_EOL.self::SOURCE_SEPARATOR.PHP_EOL, $content));
    }

    protected static function parseSettings(string $frontMatter): array
    {
        $settings = Yaml::parse($frontMatter);

        foreach ($settings ?? [] as $setting => $value) {
            preg_match('/\[(.*?)\]/', (string)$setting, $match);
            if (!isset($match[1])) {
                continue;
            }

            $settings['components'][$match[1]] = is_array($value) ? $value : [];
            unset($settings[$setting]);
        }

        return $settings;
    }

    protected static function renderSettings(array $settings): string
    {
        foreach ($settings['components'] ?? [] as $name => $component) {
            $settings[Str::of($name)->start('[')->finish(']')->toString()] = $component;
        }

        unset($settings['components']);

        $content = Yaml::dump($settings, 3, 4,
            Yaml::DUMP_OBJECT_AS_MAP
            | Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE
            | Yaml::DUMP_NUMERIC_KEY_AS_STRING
            | Yaml::DUMP_NULL_AS_TILDE,
        );

        return self::SOURCE_SEPARATOR.PHP_EOL.trim($content, PHP_EOL);
    }
}
