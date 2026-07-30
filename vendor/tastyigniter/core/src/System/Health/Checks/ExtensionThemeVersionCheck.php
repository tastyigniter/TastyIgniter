<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Igniter\Main\Models\Theme;
use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Igniter\System\Models\Extension;
use Override;

class ExtensionThemeVersionCheck extends Check
{
    public function label(): string
    {
        return lang('igniter::system.system.checks.extensions_themes');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-puzzle-piece';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 90;
    }

    public function run(): Result
    {
        $extensions = $this->enabledExtensions();

        return Result::ok(lang('igniter::system.system.checks.extensions_themes_ok', [
            'extensions' => count($extensions),
        ]))->meta($this->meta($extensions, Theme::getDefault()));
    }

    /**
     * @return array<int, array{name: string, version: string}>
     */
    protected function enabledExtensions(): array
    {
        return Extension::query()
            ->orderBy('name')
            ->get()
            ->filter(fn(Extension $extension): bool => $extension->status)
            ->map(fn(Extension $extension): array => [
                'name' => $extension->title,
                'version' => $extension->version,
            ])
            ->values()
            ->all();
    }

    /**
     * @param  array<int, array{name: string, version: string}>  $extensions
     * @return array{
     *     extensions: array<int, array{name: string, version: string}>,
     *     theme: array{name: string, version: string}|null,
     * }
     */
    protected function meta(array $extensions, ?Theme $theme): array
    {
        return [
            'extensions' => $extensions,
            'theme' => $theme instanceof Theme ? [
                'name' => $theme->name,
                'version' => $theme->version ?? '—',
            ] : null,
        ];
    }
}
