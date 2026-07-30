<?php

declare(strict_types=1);

/**
 * Igniter System Helpers
 */
use Carbon\Carbon;
use Igniter\Admin\Helpers\AdminHelper;
use Igniter\Flame\Currency\Currency;
use Igniter\Flame\Currency\Facades\Currency as CurrencyFacade;
use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Flash\FlashBag;
use Igniter\Flame\Support\StringParser;
use Igniter\Local\Models\Location;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\MediaLibrary;
use Igniter\Main\Helpers\ImageHelper;
use Igniter\Main\Helpers\MainHelper;
use Igniter\System\Models\Settings;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('current_url')) {
    /**
     * Current URL
     * Returns the full URL (including segments and query string) of the page where this
     * function is placed
     */
    function current_url(): string
    {
        return resolve(UrlGenerator::class)->current();
    }
}

if (!function_exists('assets_url')) {
    /**
     * Assets URL
     * Returns the full URL (including segments) of the assets directory
     * @codeCoverageIgnore
     * @deprecated Remove before v5
     */
    function assets_url(?string $uri = null, ?bool $secure = null): void
    {
        traceLog('assets_url() has been deprecated. Use $model->getThumb().');
    }
}

if (!function_exists('igniter_path')) {
    function igniter_path(string $path = ''): string
    {
        return dirname(__DIR__, 4).(!empty($path) ? '/'.$path : $path);
    }
}

if (!function_exists('uploads_path')) {
    /**
     * Get the path to the uploads folder.
     */
    function uploads_path(string $path = ''): string
    {
        return resolve('path.uploads').(!empty($path) ? '/'.$path : $path);
    }
}

if (!function_exists('image_url')) {
    /**
     * Image Assets URL
     * Returns the full URL (including segments) of the assets image directory
     *
     * @codeCoverageIgnore
     * @deprecated Remove before v5
     */
    function image_url(?string $uri = null, ?bool $protocol = null): string
    {
        traceLog('image_url() has been deprecated, use asset() instead.');

        return asset('assets/images/'.$uri, $protocol);
    }
}

if (!function_exists('image_path')) {
    /**
     * Get the path to the assets image folder.
     *
     * @codeCoverageIgnore
     * @deprecated Remove before v5
     */
    function image_path(string $path = ''): string
    {
        traceLog('image_path() has been deprecated, use asset() instead.');

        return asset('images').(!empty($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('theme_url')) {
    /**
     * Theme URL
     * Create a local URL based on your theme path.
     * Segments can be passed in as a string.
     */
    function theme_url(string $uri = '', ?bool $secure = null): string
    {
        return asset(trim((string)config('igniter-system.themesDir'), '/').'/'.$uri, $secure);
    }
}

if (!function_exists('theme_path')) {
    /**
     * Theme Path
     * Create a local URL based on your theme path.
     * Segments can be passed in as a string.
     */
    function theme_path(string $path = ''): string
    {
        return resolve('path.themes').(!empty($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('referrer_url')) {
    /**
     * Referrer URL
     * Returns the full URL (including segments) of the page where this
     * function is placed
     */
    function referrer_url(): string
    {
        return resolve(UrlGenerator::class)->previous();
    }
}

if (!function_exists('root_url')) {
    /**
     * Root URL
     * Create a local URL based on your root path.
     * Segments can be passed in as a string.
     *
     * @codeCoverageIgnore
     * @deprecated Remove in v5
     */
    function root_url(string $uri = '', array $params = []): string
    {
        traceLog('root_url() has been deprecated, use url() instead. Remove in v5');

        return resolve(UrlGenerator::class)->to($uri, $params);
    }
}

if (!function_exists('extension_path')) {
    /**
     * Get the path to the extensions folder.
     *
     * @codeCoverageIgnore
     * @deprecated Remove in v5
     */
    function extension_path(string $path = ''): string
    {
        traceLog('Deprecated function. No longer supported. Use __DIR__, remove in v5');

        return $path;
    }
}

if (!function_exists('assets_path')) {
    /**
     * Get the path to the assets folder.
     *
     * @codeCoverageIgnore
     * @deprecated Remove in v5
     */
    function assets_path(string $path = ''): string
    {
        traceLog('assets_path() has been deprecated, use url() instead. Remove in v5');

        return resolve('path.assets').(!empty($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('temp_path')) {
    /**
     * Get the path to the downloads temp folder.
     */
    function temp_path(string $path = ''): string
    {
        return resolve('path.temp').(!empty($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('setting')) {
    function setting(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return new Settings;
        }

        return Settings::get($key, $default);
    }
}

if (!function_exists('params')) {
    function params(?string $key = null, mixed $default = null): mixed
    {
        return Settings::get($key, $default, 'prefs');
    }
}

if (!function_exists('parse_values')) {
    /**
     * Determine if a given string contains a given substring.
     */
    function parse_values(array $columns, string $string): string
    {
        return (new StringParser)->parse($string, $columns);
    }
}

if (!function_exists('input')) {
    /**
     * Returns an input parameter or the default value.
     * Supports HTML Array names.
     * <pre>
     * $value = input('value', 'not found');
     * $name = input('contact[name]');
     * $name = input('contact[location][city]');
     * </pre>
     * Booleans are converted from strings
     */
    function input(?string $name = null, mixed $default = null): mixed
    {
        $inputData = request()->input();
        if (is_null($name)) {
            return $inputData;
        }

        // Array field name, eg: field[key][key2][key3]
        $name = implode('.', name_to_array($name));

        return array_get($inputData, $name, $default);
    }
}

if (!function_exists('post')) {
    /**
     * Identical function to input(), however restricted to $_POST values.
     */
    function post(?string $name = null, mixed $default = null): mixed
    {
        $postData = request()->post();
        if (is_null($name)) {
            return $postData;
        }

        // Array field name, eg: field[key][key2][key3]
        $name = implode('.', name_to_array($name));

        return array_get($postData, $name, $default);
    }
}

if (!function_exists('get')) {
    /**
     * Identical function to input(), however restricted to $_GET values.
     */
    function get($name = null, mixed $default = null): mixed
    {
        $inputData = request()->input();
        if (is_null($name)) {
            return $inputData;
        }

        // Array field name, eg: field[key][key2][key3]
        $name = implode('.', name_to_array($name));

        return array_get($inputData, $name, $default);
    }
}

if (!function_exists('lang')) {
    /**
     * Get the translation for the given key.
     */
    function lang(string $key, array $replace = [], ?string $locale = null, bool $fallback = true): string
    {
        return Lang::get($key, $replace, $locale, $fallback);
    }
}

if (!function_exists('get_class_id')) {
    /**
     * Generates a class ID from either an object or a string of the class name.
     */
    function get_class_id(string $name): string
    {
        return Str::getClassId($name);
    }
}

if (!function_exists('normalize_class_name')) {
    /**
     * Removes the starting slash from a class namespace \
     */
    function normalize_class_name(string $name): string
    {
        return Str::normalizeClassName($name);
    }
}

if (!function_exists('currency')) {
    /**
     * Convert given number.
     */
    function currency(
        float|string|null $amount = null,
        ?string $from = null,
        ?string $to = null,
        bool $format = true,
    ): Currency|string {
        if (is_null($amount)) {
            return resolve(Currency::class);
        }

        return CurrencyFacade::convert($amount, $from, $to, $format);
    }
}

if (!function_exists('currency_format')) {
    /**
     * Append or Prepend the default currency symbol to amounts
     */
    function currency_format(
        float|string|null $amount = null,
        ?string $currency = null,
        bool $include_symbol = true,
    ): string {
        return CurrencyFacade::format($amount, $currency, $include_symbol);
    }
}

if (!function_exists('currency_json')) {
    /**
     * Convert value to a currency array
     */
    function currency_json(float|string|null $amount = null, ?string $currency = null): array
    {
        return CurrencyFacade::formatToJson($amount, $currency);
    }
}

if (!function_exists('flash')) {
    /**
     * Arrange for a flash message.
     */
    function flash(?string $message = null, string $level = 'info'): FlashBag
    {
        $flashBag = resolve('flash');

        if (!is_null($message)) {
            return $flashBag->message($message, $level);
        }

        return $flashBag;
    }
}

if (!function_exists('normalize_uri')) {
    /**
     * Adds leading slash from a URL.
     */
    function normalize_uri(string $uri): string
    {
        if (empty($uri)) {
            $uri = '/';
        }

        if (!str_starts_with($uri, '/')) {
            $uri = '/'.$uri;
        }

        return $uri;
    }
}

if (!function_exists('array_undot')) {
    function array_undot(array $array): array
    {
        return Arr::undot($array);
    }
}

if (!function_exists('controller')) {
    /**
     * Get the page controller
     */
    function controller(): MainController
    {
        return MainController::getController();
    }
}

if (!function_exists('page_url')) {
    /**
     * Page URL
     * Returns the full URL (including segments) of the page where this
     * function is placed
     */
    function page_url(?string $uri = null, array $params = []): string
    {
        return MainHelper::pageUrl($uri, $params);
    }
}

if (!function_exists('site_url')) {
    /**
     * Site URL
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @deprecated Remove in v5
     * @codeCoverageIgnore
     */
    function site_url(?string $uri = null, array $params = []): string
    {
        return page_url($uri, $params);
    }
}

if (!function_exists('restaurant_url')) {
    /**
     * Restaurant URL
     * Returns the full URL (including segments) of the local restaurant if any,
     * else locations URL is returned
     */
    function restaurant_url(?string $uri = null, array $params = []): string
    {
        return MainHelper::pageUrl($uri, $params);
    }
}

if (!function_exists('admin_url')) {
    /**
     * Admin URL
     * Create a local URL based on your admin path.
     * Segments can be passed in as a string.
     */
    function admin_url(string $uri = '', array $params = []): string
    {
        return AdminHelper::url($uri, $params);
    }
}

if (!function_exists('uploads_url')) {
    /**
     * Media Uploads URL
     * Returns the full URL (including segments) of the assets media uploads directory
     *
     * @deprecated Remove in v5
     * @codeCoverageIgnore
     */
    function uploads_url(?string $path = null): string
    {
        traceLog('uploads_url() has been deprecated, use media_url() instead. Remove in v5');

        return media_url($path);
    }
}

if (!function_exists('media_url')) {
    /**
     * Media URL
     * Returns the full URL (including segments) of the assets media uploads directory
     */
    function media_url(?string $path = null): string
    {
        return resolve(MediaLibrary::class)->getMediaUrl($path);
    }
}

if (!function_exists('media_thumb')) {
    /**
     * Media thumbnail
     * Returns the full thumbnail (including segments) of the assets media uploads directory
     */
    function media_thumb(mixed $path, array $options = []): string
    {
        if ($path instanceof Media) {
            return $path->getThumb($options);
        }

        return ImageHelper::resize(is_string($path) ? $path : 'no_photo.png', $options);
    }
}

if (!function_exists('strip_class_basename')) {
    function strip_class_basename(mixed $class, ?string $chop = null): string
    {
        $basename = class_basename($class);

        if (is_null($chop)) {
            return $basename;
        }

        if (!ends_with($basename, $chop)) {
            return $basename;
        }

        return substr($basename, 0, -strlen($chop));
    }
}

if (!function_exists('mdate')) {
    /**
     * Convert MySQL Style Datecodes
     * This function is identical to PHPs date() function,
     * except that it allows date codes to be formatted using
     * the MySQL style, where each code letter is preceded
     * with a percent sign:  %Y %m %d etc...
     * The benefit of doing dates this way is that you don't
     * have to worry about escaping your text letters that
     * match the date codes.
     */
    function mdate(null|int|string $format = null, null|int|string $time = null): ?string
    {
        if (is_null($time) && $format) {
            $time = $format;
            $format = null;
        }

        if (is_null($format)) {
            $format = lang('igniter::system.php.date_format');
        }

        if (is_null($time)) {
            return null;
        }

        if (empty($time)) {
            $time = time();
        }

        if (str_contains((string)$format, '%')) {
            $format = str_replace(
                '%\\',
                '',
                preg_replace('/([a-z]+?)/i', '\\\\\\1', (string)$format),
            );
        }

        return date($format, $time);
    }
}

if (!function_exists('convert_php_to_moment_js_format')) {
    /**
     * Convert PHP Date formats to Moment JS Date Formats
     */
    function convert_php_to_moment_js_format(string $format): string
    {
        $replacements = [
            'd' => 'DD',
            'D' => 'ddd',
            'j' => 'D',
            'l' => 'dddd',
            'N' => 'E',
            'S' => 'o',
            'w' => 'e',
            'z' => 'DDD',
            'W' => 'W',
            'F' => 'MMMM',
            'm' => 'MM',
            'M' => 'MMM',
            'n' => 'M',
            't' => '',
            'L' => '',
            'o' => 'YYYY',
            'Y' => 'YYYY',
            'y' => 'YY',
            'a' => 'a',
            'A' => 'A',
            'B' => '',
            'g' => 'h',
            'G' => 'H',
            'h' => 'hh',
            'H' => 'HH',
            'i' => 'mm',
            's' => 'ss',
            'u' => 'SSS',
            'e' => 'zz',
            'I' => '',
            'O' => '',
            'P' => '',
            'T' => '',
            'Z' => '',
            'c' => '',
            'r' => '',
            'U' => 'X',
        ];

        foreach (array_keys($replacements) as $from) {
            $replacements['\\'.$from] = '['.$from.']';
        }

        return strtr($format, $replacements);
    }
}

if (!function_exists('time_elapsed')) {
    /**
     * Get time elapsed
     * Returns a time elapsed of seconds, minutes, hours, days in this format:
     *    10 days, 14 hours, 36 minutes, 47 seconds, now
     */
    function time_elapsed(mixed $datetime): string
    {
        return make_carbon($datetime)->diffForHumans();
    }
}

if (!function_exists('day_elapsed')) {
    /**
     * Get day elapsed
     * Returns a day elapsed as today, yesterday or date d/M/y:
     *    Today or Yesterday or 12 Jan 15
     */
    function day_elapsed(mixed $datetime, bool $full = true): string
    {
        $datetime = make_carbon($datetime);
        $time = $datetime->isoFormat(lang('igniter::system.moment.time_format'));
        $date = $datetime->isoFormat(lang('igniter::system.moment.date_format'));

        if ($datetime->isToday()) {
            $date = lang('igniter::system.date.today');
        } elseif ($datetime->isYesterday()) {
            $date = lang('igniter::system.date.yesterday');
        } elseif ($datetime->isTomorrow()) {
            $date = lang('igniter::system.date.tomorrow');
        }

        return $full ? sprintf(lang('igniter::system.date.full'), $date, $time) : $date;
    }
}

if (!function_exists('time_range')) {
    /**
     * Date range
     * Returns a list of time within a specified period.
     */
    function time_range(mixed $unix_start, mixed $unix_end, string|int $interval, string $time_format = '%H:%i'): ?array
    {
        if ($unix_start == '' || $unix_end == '' || $interval == '') {
            return null;
        }

        $interval = ctype_digit((string)$interval) ? $interval.' mins' : $interval;

        $start_time = strtotime((string)$unix_start);
        $end_time = strtotime((string)$unix_end);

        $current = time();
        $add_time = strtotime('+'.$interval, $current);
        $diff = $add_time - $current;

        $times = [];
        while ($start_time < $end_time) {
            $times[] = mdate($time_format, $start_time);
            $start_time += $diff;
        }

        $times[] = mdate($time_format, $start_time);

        return $times;
    }
}

if (!function_exists('parse_date_format')) {
    function parse_date_format(string $format): string
    {
        if (str_contains($format, '%')) {
            $format = str_replace(
                '%\\',
                '',
                preg_replace('/([a-z]+?)/i', '\\\\\\1', $format),
            );
        }

        return $format;
    }
}

if (!function_exists('make_carbon')) {
    /**
     * Converts mixed inputs to a Carbon object.
     */
    function make_carbon(mixed $value, bool $throwException = true): ?Carbon
    {
        try {
            if (!$value instanceof Carbon && $value instanceof DateTime) {
                $value = Carbon::instance($value);
            } elseif (is_numeric($value)) {
                $value = Carbon::createFromTimestamp($value);
            } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', (string)$value)) {
                $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
            } else {
                try {
                    $value = Carbon::parse($value);
                } catch (Exception) {
                }
            }

            if (!$value instanceof Carbon) {
                throw new InvalidArgumentException('Invalid date value supplied to DateTime helper.');
            }
        } catch (Exception $exception) {
            $throwException ? throw $exception : $value = null;
        }

        return $value;
    }
}

if (!function_exists('is_single_location')) {
    /**
     * Is Single Location Mode
     * Test to see system config multi location mode is set to single.
     */
    function is_single_location(): bool
    {
        return config('igniter-system.locationMode', setting('site_location_mode')) === Location::LOCATION_CONTEXT_SINGLE;
    }
}

if (!function_exists('log_message')) {
    /**
     * Error Logging Interface
     * We use this as a simple mechanism to access the logging
     * class and send messages to be logged.
     */
    function log_message(string $level, string $message): void
    {
        Log::$level($message);
    }
}

if (!function_exists('traceLog')) {
    function traceLog(...$messages): void
    {
        foreach ($messages as $message) {
            $level = 'info';

            if ($message instanceof Exception) {
                $level = 'error';
            } elseif (is_array($message) || is_object($message)) {
                $message = print_r($message, true);
            }

            Log::$level($message);
        }
    }
}

if (!function_exists('sort_array')) {
    /**
     * Sort an array by key
     */
    function sort_array(array $array = [], string $sort_key = 'priority', int $option = SORT_ASC): array
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $sort_array[$key] = $value[$sort_key] ?? 0;
            }

            array_multisort($sort_array, $option, $array);
        }

        return $array;
    }
}

if (!function_exists('name_to_id')) {
    /**
     * Converts a HTML array string to an identifier string.
     * HTML: user[location][city]
     * Result: user-location-city
     */
    function name_to_id(string $string): string
    {
        return rtrim(str_replace('--', '-', str_replace(['[', ']'], '-', str_replace('_', '-', $string))), '-');
    }
}

if (!function_exists('name_to_array')) {
    /**
     * Converts a HTML named array string to a PHP array. Empty values are removed.
     * HTML: user[location][city]
     * PHP:  ['user', 'location', 'city']
     */
    function name_to_array(string $string): array
    {
        $result = [$string];

        if (strpbrk($string, '[]') === false) {
            return $result;
        }

        if (preg_match('/^([^\]]+)(?:\[(.+)\])+$/', $string, $matches) && count($matches) >= 2) {
            $result = explode('][', $matches[2]);
            array_unshift($result, $matches[1]);
        }

        return array_filter($result, fn($val): bool => (bool)strlen((string) $val));
    }
}

if (!function_exists('name_to_dot_string')) {
    /**
     * Determine if a given string matches a language key.
     */
    function name_to_dot_string(string $name): string
    {
        return implode('.', name_to_array($name));
    }
}

if (!function_exists('is_lang_key')) {
    /**
     * Determine if a given string matches a language key.
     */
    function is_lang_key(string $line): bool
    {
        if (starts_with($line, 'lang:')) {
            return true;
        }

        return str_contains($line, '::');
    }
}

if (!function_exists('generate_extension_icon')) {
    function generate_extension_icon(string|array $icon): array
    {
        if (is_string($icon)) {
            $icon = starts_with($icon, ['//', 'http://', 'https://'])
                ? ['url' => $icon]
                : ['class' => 'fa '.$icon];
        }

        $icon = array_merge([
            'class' => 'fa fa-plug',
            'color' => '',
            'image' => null,
            'backgroundColor' => '',
            'backgroundImage' => null,
        ], $icon);

        $styles = [];
        if (!empty($color = array_get($icon, 'color'))) {
            $styles[] = sprintf('color:%s;', $color);
        }

        if (!empty($backgroundColor = array_get($icon, 'backgroundColor'))) {
            $styles[] = sprintf('background-color:%s;', $backgroundColor);
        }

        if (is_array($backgroundImage = array_get($icon, 'backgroundImage'))) {
            $styles[] = sprintf("background-image:url('data:%s;base64,%s');", $backgroundImage[0], $backgroundImage[1]);
        }

        $icon['styles'] = implode(' ', $styles);

        return $icon;
    }
}

if (!function_exists('array_replace_key')) {
    function array_replace_key($array, $oldKey, $newKey): array
    {
        $keys = array_keys($array);

        if (($keyIndex = array_search($oldKey, $keys, true)) !== false) {
            $keys[$keyIndex] = $newKey;
        }

        return array_combine($keys, array_values($array));
    }
}

if (!function_exists('array_insert_after')) {
    function array_insert_after(array $array, string $key, array $value): array
    {
        $keys = array_keys($array);
        $index = array_search($key, $keys, true);
        $position = $index === false ? count($array) : $index + 1;

        return array_merge(array_slice($array, 0, $position), $value, array_slice($array, $position));
    }
}

if (!function_exists('array_merge_deep')) {
    function array_merge_deep(array $array1, array $array2): array
    {
        $merged = $array1;

        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = array_merge_deep($merged[$key], $value);
            } elseif (is_numeric($key)) {
                if (!in_array($value, $merged)) {
                    $merged[] = $value;
                }
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
