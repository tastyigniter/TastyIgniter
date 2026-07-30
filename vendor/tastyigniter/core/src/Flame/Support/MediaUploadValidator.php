<?php

declare(strict_types=1);

namespace Igniter\Flame\Support;

use enshrined\svgSanitize\Sanitizer;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\System\Models\Settings;

class MediaUploadValidator
{
    protected const array FILENAME_DENYLIST = [
        'htaccess',
        'web.config',
        'nginx.conf',
    ];

    protected const array IMAGE_MAGIC_BYTES = [
        'jpg' => ["\xFF\xD8\xFF"],
        'jpeg' => ["\xFF\xD8\xFF"],
        'png' => ["\x89PNG\r\n\x1a\n"],
        'gif' => ['GIF87a', 'GIF89a'],
        'bmp' => ['BM'],
        'tiff' => ["II*\x00", "MM\x00*"],
        'ico' => ["\x00\x00\x01\x00"],
    ];

    public function validateFilename(string $filename, ?array $allowedExtensions = null): void
    {
        if (str_contains($filename, "\0")) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_invalid_path'));
        }

        if (str_contains($filename, '..')) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_invalid_path'));
        }

        $basename = basename($filename);

        if ($basename === '' || str_starts_with($basename, '.')) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_dotfile_not_allowed'));
        }

        $lowerBasename = strtolower($basename);
        $lowerName = strtolower(pathinfo($basename, PATHINFO_FILENAME));

        foreach (self::FILENAME_DENYLIST as $denied) {
            if ($lowerBasename === $denied || $lowerName === $denied) {
                throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
            }
        }

        $extension = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
        $allowedExtensions ??= Settings::defaultExtensions();

        if ($extension === '' || !in_array($extension, $allowedExtensions, true)) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_extension_not_allowed'));
        }
    }

    public function validateAndSanitize(string $filename, string $contents, ?array $allowedExtensions = null): string
    {
        $this->validateFilename($filename, $allowedExtensions);

        $extension = strtolower(pathinfo(basename($filename), PATHINFO_EXTENSION));

        if ($extension === 'svg') {
            return $this->sanitizeSvg($contents);
        }

        if ($this->isImageExtension($extension)) {
            $this->assertValidImageContent($contents, $extension);
            $this->assertSafeImageContent($contents);

            return $contents;
        }

        $this->assertSafeContent($contents, $extension);

        return $contents;
    }

    protected function sanitizeSvg(string $contents): string
    {
        $sanitizer = new Sanitizer;
        $sanitized = $sanitizer->sanitize($contents);

        if ($sanitized === false || $sanitized === '') {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
        }

        return $sanitized;
    }

    protected function assertSafeContent(string $contents, string $extension): void
    {
        if ($this->containsPhpTags($contents)) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
        }

        if ($this->containsApacheDirectives($contents)) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
        }

        if ($this->containsEmbeddedScript($contents)) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
        }
    }

    protected function assertSafeImageContent(string $contents): void
    {
        if ($this->containsExplicitPhpTags($contents)) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
        }

        if ($this->containsApacheDirectives($contents)) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_unsafe_file_content'));
        }
    }

    protected function assertValidImageContent(string $contents, string $extension): void
    {
        if ($extension === 'webp') {
            if (!$this->hasWebpSignature($contents)) {
                throw new ApplicationException(lang('igniter::main.media_manager.alert_invalid_image_content'));
            }

            return;
        }

        if ($extension === 'svg') {
            return;
        }

        $signatures = self::IMAGE_MAGIC_BYTES[$extension] ?? null;

        if ($signatures === null) {
            return;
        }

        $matched = false;
        foreach ($signatures as $signature) {
            if (str_starts_with($contents, $signature)) {
                $matched = true;
                break;
            }
        }

        if (!$matched) {
            throw new ApplicationException(lang('igniter::main.media_manager.alert_invalid_image_content'));
        }
    }

    protected function containsPhpTags(string $contents): bool
    {
        if ($this->containsExplicitPhpTags($contents)) {
            return true;
        }

        return (bool)preg_match('/<\?(?!xml)/i', $contents);
    }

    protected function containsExplicitPhpTags(string $contents): bool
    {
        return preg_match('/<\?php/i', $contents) || preg_match('/<\?=/', $contents);
    }

    protected function containsApacheDirectives(string $contents): bool
    {
        $patterns = [
            '/SetHandler/i',
            '/AddHandler/i',
            '/AddType\s+application\/x-httpd/i',
            '/php_value/i',
            '/php_flag/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $contents)) {
                return true;
            }
        }

        return false;
    }

    protected function containsEmbeddedScript(string $contents): bool
    {
        return (bool)preg_match('/<script/i', $contents);
    }

    protected function isImageExtension(string $extension): bool
    {
        return in_array($extension, Settings::imageExtensions(), true);
    }

    protected function hasWebpSignature(string $contents): bool
    {
        return str_starts_with($contents, 'RIFF')
            && strlen($contents) >= 12
            && substr($contents, 8, 4) === 'WEBP';
    }
}
