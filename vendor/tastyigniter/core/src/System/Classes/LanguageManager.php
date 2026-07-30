<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Helpers\SystemHelper;
use Igniter\System\Models\Language;
use Igniter\System\Models\Translation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Translation\FileLoader as IlluminateFileLoader;
use stdClass;

class LanguageManager
{
    protected IlluminateFileLoader $loader;

    protected string $langPath;

    protected UpdateManager $updateManager;

    protected HubManager $hubManager;

    /**
     * @var array of languages and their directory paths.
     */
    protected $paths = [];

    public function initialize(): void
    {
        $this->loader = App::make('translation.loader');
        $this->langPath = App::langPath();

        $this->updateManager = resolve(UpdateManager::class);
        $this->hubManager = resolve(HubManager::class);
    }

    public function namespaces(): array
    {
        $namespaces = $this->loader->namespaces();
        asort($namespaces);

        return $namespaces;
    }

    public function listLanguages(): Collection
    {
        return Language::whereIsEnabled()->get();
    }

    /**
     * Create a Directory Map of all themes
     */
    public function paths(): array
    {
        if ($this->paths) {
            return $this->paths;
        }

        $paths = [];

        if (!File::exists($directory = base_path('language'))) {
            return $paths;
        }

        foreach (File::directories($directory) as $path) {
            $langDir = basename((string)$path);
            $paths[$langDir] = $path;
        }

        return $this->paths = $paths;
    }

    //
    // Translations
    //

    public function listLocalePackages(?string $locale = null): array
    {
        $locale ??= 'en';

        $result = [];
        $extensionManager = resolve(ExtensionManager::class);
        $namespaces = $this->loader->namespaces();
        asort($namespaces);
        foreach ($namespaces as $namespace => $folder) {
            $name = $namespace === 'igniter' ? 'Application' : 'Unknown';
            if ($extension = $extensionManager->findExtension($namespace)) {
                $name = array_get($extension->extensionMeta(), 'name');
            }

            $result[] = (object)[
                'code' => $namespace,
                'name' => $name,
                'files' => File::glob($folder.'/'.$locale.'/*.php'),
            ];
        }

        return $result;
    }

    public function listTranslations(
        Language $model,
        ?string $packageCode = null,
        ?string $filter = null,
        ?string $searchTerm = null,
    ): stdClass {
        $result = (object)[
            'total' => null,
            'translated' => null,
            'untranslated' => null,
            'progress' => null,
            'strings' => [],
        ];

        collect($this->listLocalePackages())
            ->filter(fn(stdClass $localePackage): bool => !$packageCode || $localePackage->code === $packageCode)
            ->each(function(stdClass $localePackage) use ($filter, $result, $model) {
                collect($localePackage->files)->each(function($filePath) use ($filter, $result, $localePackage, $model) {
                    $filePath = pathinfo($filePath, PATHINFO_FILENAME);

                    $sourceLines = $model->getLines('en', $filePath, $localePackage->code);
                    $translationLines = $model->getTranslations($filePath, $localePackage->code);

                    $result->total += count($sourceLines);
                    $result->translated += count($translationLines);

                    $localeGroup = sprintf('%s::%s', $localePackage->code, $filePath);
                    $translations = $this->listTranslationStrings($sourceLines, $translationLines, $localeGroup, $filter);

                    $result->strings = array_merge($result->strings, $translations);
                });
            });

        if (!is_null($searchTerm) && strlen($searchTerm)) {
            $result->strings = $this->searchTranslations($result->strings, $searchTerm);
        }

        $result->strings = $this->paginateTranslations($result->strings);

        $result->untranslated = $result->total - $result->translated;
        $result->progress = $result->total ? round(($result->translated * 100) / $result->total, 2) : 0;

        return $result;
    }

    public function publishTranslations(Language $model): void
    {
        $installedItems = collect($this->updateManager->getInstalledItems())->keyBy('name');

        $translations = $model->translations()
            ->get()
            // @phpstan-ignore-next-line
            ->groupBy(fn(Translation $translation): string => $translation->namespace)
            ->filter(fn(Collection $translations, string $namespace): bool => $namespace === 'igniter' || $installedItems->has($namespace))
            ->map(function(Collection $translations, string $namespace) use ($installedItems): array {
                $item = $namespace === 'igniter'
                    ? [
                        'name' => 'tastyigniter',
                        'type' => 'core',
                        'ver' => Igniter::version(),
                    ] : $installedItems->get($namespace);

                // @phpstan-ignore-next-line
                $item['files'] = $translations->groupBy(fn(Translation $translation): string => $translation->group)
                    ->map(fn(Collection $translations, string $file): array => [
                        'name' => $file.'.php',
                        // @phpstan-ignore-next-line
                        'strings' => $translations->map(fn(Translation $translation): array => [
                            'key' => $translation->item,
                            'value' => $translation->text,
                        ])->all(),
                    ])
                    ->values()
                    ->all();

                return $item;
            });

        throw_if($translations->isEmpty(), new FlashException('No translations to publish'));

        $translations->each(function(array $item) use ($model) {
            $this->hubManager->publishTranslations($model->code, $item);
        });
    }

    protected function listTranslationStrings(array $sourceLines, array $translationLines, string $localeGroup, ?string $filter): array
    {
        $result = [];
        foreach ($sourceLines as $key => $sourceLine) {
            $translationLine = array_get($translationLines, $key, $sourceLine);

            if (
                ($filter === 'changed' && !array_has($translationLines, $key))
                || ($filter === 'unchanged' && array_has($translationLines, $key))
                || ((!is_null($sourceLine) && !is_string($sourceLine)))
                || (!is_null($translationLine) && !is_string($translationLine))
            ) {
                continue;
            }

            $result[sprintf('%s.%s', $localeGroup, $key)] = [
                'source' => $sourceLine,
                'translation' => (strcmp((string)$sourceLine, (string)$translationLine) === 0) ? '' : $translationLine,
            ];
        }

        return $result;
    }

    protected function searchTranslations(array $translations, ?string $term = null): array
    {
        $result = [];
        $term = strtolower((string)$term);
        foreach ($translations as $key => $value) {
            if (stripos(strtolower((string)array_get($value, 'source')), $term) !== false
                || stripos(strtolower((string)array_get($value, 'translation')), $term) !== false
                || stripos(strtolower((string)$key), $term) !== false) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    protected function paginateTranslations(array $translations, int $perPage = 50): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage();

        $items = collect($translations);
        $total = $items->count();
        $items = $total !== 0 ? $items->forPage($page, $perPage) : collect();

        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ];

        return App::makeWith(LengthAwarePaginator::class, ['items' => $items, 'total' => $total, 'perPage' => $perPage, 'page' => $page, 'options' => $options]);
    }

    //
    //
    //

    public function findLanguage(string $locale): array
    {
        $result = $this->hubManager->getLanguage($locale);

        return array_get($result, 'data', []);
    }

    public function applyLanguagePack(string $locale, ?array $builds = null): array
    {
        $installedItemCodes = collect($this->updateManager->getInstalledItems())->keyBy('name');

        $items = collect($this->namespaces())
            ->filter(fn($langDirectory, $code) => $code === 'igniter' || $installedItemCodes->has($code))
            ->map(function(string $langDirectory, $code) use ($builds, $installedItemCodes) {
                $item = $code === 'igniter'
                    ? [
                        'name' => 'tastyigniter',
                        'type' => 'core',
                        'ver' => Igniter::version(),
                    ]
                    : $installedItemCodes->get($code);

                $item['files'] = collect(File::glob($langDirectory.'/en/*.php'))
                    ->map(function($langFile) use ($builds, $item): array {
                        $langFilename = basename($langFile);

                        return [
                            'name' => $langFilename,
                            'hash' => array_get(array_get($builds, $item['name']), $langFilename),
                        ];
                    })
                    ->all();

                return $item;
            })
            ->filter(fn($item) => (new SystemHelper)->validateVersion($item['ver']))
            ->values()
            ->all();

        $response = $this->hubManager->applyLanguagePack($locale, $items);

        return array_get($response, 'data', []);
    }

    public function installLanguagePack(string $locale, array $meta): void
    {
        $eTag = array_get($meta, 'hash');

        $response = $this->hubManager->downloadLanguagePack($eTag, [
            'locale' => $locale,
            'item' => $meta,
        ]);

        $strings = array_get($response, 'data.strings', []);

        $langDirectory = $meta['name'] === 'tastyigniter' ? 'igniter' : str_replace('.', '-', $meta['name']);
        $filePath = $this->langPath.'/vendor/'.$langDirectory.'/'.$locale.'/'.$meta['file'];

        File::makeDirectory(dirname($filePath), 0777, true, true);

        File::put($filePath, "<?php\n\nreturn ".var_export($strings, true).";\n");
    }
}
