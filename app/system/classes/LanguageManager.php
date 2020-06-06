<?php

namespace System\Classes;

use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Traits\Singleton;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;

class LanguageManager
{
    use Singleton;

    /**
     * @var \Igniter\Flame\Translation\FileLoader
     */
    protected $loader;

    /**
     * @var \Igniter\Flame\Filesystem\Filesystem
     */
    protected $files;

    protected $langPath;

    public function initialize()
    {
        $this->loader = App::make('translation.loader');
        $this->files = App::make('files');
        $this->langPath = App::langPath();
    }

    public function namespaces()
    {
        $namespaces = $this->loader->namespaces();
        asort($namespaces);

        return $namespaces;
    }

    //
    // Translations
    //

    public function listLocaleFiles($locale)
    {
        $result = [];
        $namespaces = $this->loader->namespaces();
        asort($namespaces);
        foreach ($namespaces as $namespace => $folder) {
            foreach (File::glob($folder.'/'.$locale.'/*.php') as $filePath) {
                $result[] = [
                    'namespace' => $namespace,
                    'group' => pathinfo($filePath, PATHINFO_FILENAME),
                    'system' => in_array(ucfirst($namespace), config('system.modules', [])),
                ];
            }
        }

        return $result;
    }

    public function listTranslations($sourceLines, $translationLines, $options = [])
    {
        $file = array_get($options, 'file');
        $stringFilter = array_get($options, 'stringFilter');

        $result = [];
        foreach ($sourceLines as $key => $sourceLine) {
            $translationLine = array_get($translationLines, $key, $sourceLine);

            if ($stringFilter === 'changed' AND !array_has($translationLines, $key)) continue;

            if ($stringFilter === 'unchanged' AND array_has($translationLines, $key)) continue;

            if ((!is_null($sourceLine) AND !is_string($sourceLine))) continue;

            if ((!is_null($translationLine) AND !is_string($translationLine))) continue;

            $namespacedKey = sprintf('%s::%s.%s', $file['namespace'], $file['group'], $key);

            $result[$namespacedKey] = [
                'source' => $sourceLine,
                'translation' => $translationLine,
            ];
        }

        return $result;
    }

    public function searchTranslations($translations, $term = null)
    {
        if (!strlen($term))
            return $translations;

        $result = [];
        $term = strtolower($term);
        foreach ($translations as $key => $value) {
            if (strlen($term)) {
                if (stripos(strtolower(array_get($value, 'source')), $term) !== FALSE
                    OR stripos(strtolower(array_get($value, 'translation')), $term) !== FALSE
                    OR stripos(strtolower($key), $term) !== FALSE) {
                    $result[$key] = $value;
                }
            }
            else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function paginateTranslations($translations, $perPage = 50)
    {
        $page = Paginator::resolveCurrentPage();

        $items = collect($translations);
        $total = $items->count();

        $items = $total ? $items->forPage($page, $perPage) : collect();

        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ];

        return App::makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'page', 'options'
        ));
    }
}