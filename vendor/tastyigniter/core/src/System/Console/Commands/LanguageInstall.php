<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Exception;
use Igniter\System\Classes\LanguageManager;
use Igniter\System\Models\Language;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputArgument;

class LanguageInstall extends Command
{
    protected $name = 'igniter:language-install';

    protected $description = 'Pull translated strings from the TastyIgniter marketplace.';

    public function handle(): void
    {
        $languageManager = resolve(LanguageManager::class);

        $locale = $this->argument('locale');
        if (!$translationLanguage = $languageManager->findLanguage($locale)) {
            $this->output->writeln(sprintf('<error>Language %s not found in the TastyIgniter Community Translation project</error>', $locale));

            return;
        }

        if (is_null($language = Language::findByCode($locale))) {
            /** @var Language $language */
            $language = Language::create(['code' => $locale, 'name' => $translationLanguage['name'], 'status' => true]);
            $this->output->writeln('<info>Language not found, creating new language</info>');
        }

        if (!$itemsToUpdate = $languageManager->applyLanguagePack($language->code, (array)$language->version)) {
            $this->output->writeln('<info>No new translated strings found</info>');

            return;
        }

        $this->output->writeln('<info>New translated strings found</info>');

        foreach ($itemsToUpdate as $item) {
            foreach (array_get($item, 'files', []) as $file) {
                $this->output->writeln(sprintf(lang('igniter::system.languages.alert_update_file_progress'), $language->code, $item['name'], $file['name']));

                try {
                    $languageManager->installLanguagePack($language->code, [
                        'name' => $item['code'],
                        'type' => $item['type'],
                        'ver' => '0.1.0',
                        'file' => $file['name'],
                        'hash' => $file['hash'],
                    ]);
                } catch (Exception $ex) {
                    $this->output->writeln(sprintf(lang('igniter::system.languages.alert_update_file_failed'), $language->code, $item['name'], $file['name']));
                    $this->output->writeln($ex->getMessage());
                    continue;
                }

                $language->updateVersions($item['code'], $file['name'], $file['hash']);
                $this->output->writeln(sprintf(lang('igniter::system.languages.alert_update_file_complete'), $language->code, $item['name'], $file['name']));
            }

            $this->output->writeln(sprintf(lang('igniter::system.languages.alert_update_complete'), $language->code, $item['name']));
        }
    }

    #[Override]
    protected function getArguments(): array
    {
        return [
            ['locale', InputArgument::REQUIRED, 'The name of the language. Eg: fr_FR'],
        ];
    }

    #[Override]
    protected function getOptions(): array
    {
        return [];
    }
}
