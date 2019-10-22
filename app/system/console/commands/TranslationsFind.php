<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use System\Classes\LanguageManager;

class TranslationsFind extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'translations:find';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find translations in php/htm files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $manager = TranslationManager::instance();

//        $counter = $manager->findTranslations();
//        $this->info('Done importing, processed '.$counter.' items!');

        $path = base_path('app/admin/language');
        $finder = new Finder();
        $finder->in($path)->exclude('storage')->exclude('vendor')->name('*.php')->name('*.htm')->files();

        $files = LanguageManager::instance()->listLocaleFiles('en');

        $duplicates = $values = [];
        foreach ($files as $file) {
            $lines = app('translation.loader')->load('en', $file['group'], $file['namespace']);

            foreach ($lines as $key => $value) {
                if (!is_string($value)) continue;

                if (in_array($value, $values)) {
                    $duplicates[$value][] = sprintf('%s::%s.%s', $file['namespace'], $file['group'], $key);
//                    $count = count($duplicates[$value]);
//                    $this->output->writeln("Duplicate string $key in {$file['namespace']}::{$file['group']} --- $value");
                }

                $values[$key] = $value;
            }
        }

        foreach ($duplicates as $text => $duplicate) {
            $this->output->writeln("<info>String $text in: </info>");
            $this->output->writeln(implode(PHP_EOL, $duplicate));
        }

        $this->output->writeln('Total Duplicates: '.count($duplicates));
//        $duplicates = $values = [];
//        /** @var \Symfony\Component\Finder\SplFileInfo $file */
//        foreach ($finder as $file) {
//            $lang = File::getRequire($file);
//            $lang = array_dot($lang);
//
//            foreach ($lang as $key => $value) {
//                if (in_array($value, $values))
//                    $duplicates[$value][] = $key;
//
//                $values[] = $value;
//            }
//        }
    }
}
