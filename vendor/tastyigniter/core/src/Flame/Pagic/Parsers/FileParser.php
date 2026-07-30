<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Parsers;

use Igniter\Flame\Pagic\Cache\FileSystem;
use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Support\Facades\File;

/**
 * FileParser class.
 */
class FileParser
{
    protected ?Model $object = null;

    protected FileSystem $fileCache;

    final public function __construct()
    {
        $this->fileCache = resolve(FileSystem::class);
    }

    public static function on(Model $object): static
    {
        return tap(new static, function($parser) use ($object) {
            $parser->object = $object;
        });
    }

    /**
     * Runs the object's PHP file and returns the corresponding object.
     */
    public function source(): mixed
    {
        $data = $this->process();
        $className = $data['className'];

        if (!$className || !class_exists($className)) {
            $this->fileCache->load($data['filePath']);
        }

        if ((!$className || !class_exists($className)) && ($data = $this->handleCorruptCache($data))) {
            $className = $data['className'];
        }

        return new $className(...func_get_args());
    }

    protected function process(): array
    {
        $filePath = $this->object->getFilePath();
        $path = $this->fileCache->getCacheKey($filePath);

        $result = [
            'filePath' => $path,
            'mTime' => $this->object->mTime,
        ];

        if (File::isFile($path)) {
            $cachedInfo = $this->fileCache->getCached($path);
            $hasCache = $cachedInfo !== null;

            if ($hasCache && $cachedInfo['mTime'] == $this->object->mTime) {
                $result['className'] = $cachedInfo['className'];

                return $result;
            }

            if (!$hasCache && File::lastModified($path) >= $this->object->mTime && ($className = $this->extractClassFromFile($path))) {
                $result['className'] = $cacheItem['className'] = $className;
                $this->fileCache->storeCached($filePath, $cacheItem);

                return $result;
            }
        }

        $result['className'] = $this->compile($path);
        $this->fileCache->storeCached($path, $result);

        return $result;
    }

    /**
     * Compile a page or layout file content as object.
     */
    protected function compile(string $path): string
    {
        $code = trim($this->object->code ?? '');
        $parentClass = trim($this->object->getCodeClassParent());

        $uniqueName = str_replace('.', '', uniqid('', true)).'_'.md5((string)mt_rand());
        $className = 'Pagic'.$uniqueName.'Class';

        $code = preg_replace('/^\s*function/m', 'public function', $code);
        $code = preg_replace('/^\<\?php/', '', (string)$code);
        $code = preg_replace('/^\<\?/', '', (string)preg_replace('/\?>$/', '', (string)$code));

        $imports = [];
        $pattern = '/(use\s+[a-z0-9_\\\\]+(\s+as\s+[a-z0-9_]+)?;\n?)/mi';
        preg_match_all($pattern, (string)$code, $imports);
        $code = preg_replace($pattern, '', (string)$code);

        if (!empty($parentClass)) {
            $parentClass = ' extends '.$parentClass;
        }

        $fileContents = '<?php '.PHP_EOL;
        $fileContents .= sprintf('/* %s */', $this->object->getFilePath()).PHP_EOL;

        foreach ($imports[0] as $namespace) {
            $fileContents .= $namespace;
        }

        $fileContents .= 'class '.$className.$parentClass.PHP_EOL;
        $fileContents .= '{'.PHP_EOL;
        $fileContents .= $code.PHP_EOL;
        $fileContents .= '}'.PHP_EOL;

        // Evaluates PHP content in order to detect syntax errors
        eval('?>'.$fileContents);

        $this->fileCache->write($path, $fileContents);

        return $className;
    }

    protected function handleCorruptCache(array $data): array
    {
        $path = array_get($data, 'filePath', $data['className'] ? $this->fileCache->getCacheKey($data['className']) : '');
        if (File::isFile($path)) {
            if (($className = $this->extractClassFromFile($path)) && class_exists($className)) {
                $data['className'] = $className;

                return $data;
            }

            @File::delete($path);
        }

        return $this->process();
    }

    /**
     * Extracts the class name from a cache file
     */
    protected function extractClassFromFile(string $path): ?string
    {
        $fileContent = File::get($path);
        $matches = [];
        $pattern = '/Pagic\S+_\S+Class/';
        preg_match($pattern, $fileContent, $matches);

        if (!empty($matches[0])) {
            return $matches[0];
        }

        return null;
    }
}
