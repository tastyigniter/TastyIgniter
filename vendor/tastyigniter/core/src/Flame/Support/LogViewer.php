<?php

declare(strict_types=1);

namespace Igniter\Flame\Support;

use Exception;
use Igniter\Flame\Support\Facades\File;
use InvalidArgumentException;

/**
 * Class LogViewer
 * Based on Rap2hpoutre\LaravelLogViewer
 */
class LogViewer
{
    // Limit to 30MB, reading larger files can eat up memory
    public const int MAX_FILE_SIZE = 31457280;

    /**
     * @var string file
     */
    protected ?string $file = null;

    protected static $levelClasses = [
        'debug' => 'info',
        'info' => 'info',
        'notice' => 'info',
        'warning' => 'warning',
        'error' => 'danger',
        'critical' => 'danger',
        'alert' => 'danger',
        'emergency' => 'danger',
        'processed' => 'info',
    ];

    protected static $levelIcons = [
        'debug' => 'info',
        'info' => 'info',
        'notice' => 'info',
        'warning' => 'warning',
        'error' => 'warning',
        'critical' => 'warning',
        'alert' => 'warning',
        'emergency' => 'warning',
        'processed' => 'info',
    ];

    /**
     * Log levels that are used
     * @var array
     */
    protected static $levels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
        'processed',
    ];

    /**
     * @param string $file
     *
     * @throws Exception
     */
    public function setFile($file): static
    {
        $this->file = self::pathToLogFile($file);

        return $this;
    }

    /**
     * @param string $file
     *
     * @return string
     * @throws Exception
     */
    public function pathToLogFile($file)
    {
        // check if requested file is really in the logs directory
        if (!starts_with($file, storage_path('logs'))) {
            throw new InvalidArgumentException('Invalid log file');
        }

        return $file;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return File::basename($this->file);
    }

    public function all(): ?array
    {
        $log = [];
        if (!$this->file) {
            $logFile = self::getFiles();

            if ($logFile === []) {
                return [];
            }

            $this->file = $logFile[0];
        }

        $fileContents = File::get($this->file);
        $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/';
        preg_match_all($pattern, $fileContents, $headings);

        if (!array_filter($headings)) {
            return $log;
        }

        $logData = preg_split($pattern, $fileContents);

        if ($logData[0] < 1) {
            array_shift($logData);
        }

        foreach ($headings as $h) {
            for ($i = 0, $j = count($h); $i < $j; $i++) {
                foreach (self::$levels as $level) {
                    if (strpos(strtolower($h[$i]), '.'.$level) || strpos(strtolower($h[$i]), $level.':')) {

                        preg_match(
                            '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\](?:.*?(\w+)\.|.*?)'
                            .$level.': (.*?)( in .*?:[0-9]+)?$/i', $h[$i], $current,
                        );

                        if (!isset($current[3])) {
                            continue;
                        }

                        $log[] = [
                            'context' => $current[2],
                            'level' => strtoupper((string)$level),
                            'class' => self::$levelClasses[$level],
                            'icon' => self::$levelIcons[$level],
                            'date' => $current[1],
                            'text' => $current[3],
                            'summary' => $current[4] ?? null,
                            'stack' => ltrim($logData[$i], "\n"),
                        ];
                    }
                }
            }
        }

        return array_reverse($log);
    }

    /**
     * @param bool $basename
     */
    public function getFiles($basename = false): array
    {
        $files = File::glob(storage_path().'/logs/*.log');
        $files = array_reverse($files);
        $files = array_filter($files, fn($file) => File::isFile($file));

        if ($basename) {
            foreach ($files as $k => $file) {
                $files[$k] = File::basename($file);
            }
        }

        return array_values($files);
    }
}
