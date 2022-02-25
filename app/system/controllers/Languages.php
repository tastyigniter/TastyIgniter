<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;
use Admin\Widgets\Form;
use System\Classes\ExtensionManager;
use System\Classes\LanguageManager;
use System\Models\Language;
use System\Traits\SessionMaker;

class Languages extends \Admin\Classes\AdminController
{
    use SessionMaker;

    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Language',
            'title' => 'lang:system::lang.languages.text_title',
            'emptyMessage' => 'lang:system::lang.languages.text_empty',
            'defaultSort' => ['language_id', 'DESC'],
            'configFile' => 'language',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:system::lang.languages.text_form_name',
        'model' => 'System\Models\Language',
        'request' => 'System\Requests\Language',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
            'redirectNew' => 'languages/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'languages/edit/{language_id}',
            'redirectClose' => 'languages',
            'redirectNew' => 'languages/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'languages',
        ],
        'delete' => [
            'redirect' => 'languages',
        ],
        'configFile' => 'language',
    ];

    protected $requiredPermissions = 'Site.Languages';

    protected $localeFiles;

    protected $totalStrings;

    protected $totalTranslated;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('languages', 'localisation');
    }

    public function index()
    {
        Language::applySupportedLanguages();

        $this->asExtension('ListController')->index();
    }

    public function edit($context = null, $recordId = null)
    {
        $this->addJs('~/app/admin/assets/js/translationseditor.js', 'translationseditor-js');

        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function edit_onSubmitFilter($context = null, $recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $this->asExtension('FormController')->initForm($model, $context);

        $file = post('Language._file');
        $this->setFilterValue('file', (!strlen($file) || strpos($file, '::') == FALSE) ? null : $file);

        $term = post('Language._search');
        $this->setFilterValue('search', (!strlen($term) || !is_string($term)) ? null : $term);

        $stringFilter = post('Language._string_filter');
        $this->setFilterValue('string_filter', (!strlen($stringFilter) || !is_string($stringFilter)) ? null : $stringFilter);

        return $this->asExtension('FormController')->makeRedirect('edit', $model);
    }

    public function formExtendFields(Form $form, $fields)
    {
        if ($form->getContext() !== 'edit')
            return;

        $fileField = $form->getField('_file');
        $searchField = $form->getField('_search');
        $stringFilterField = $form->getField('_string_filter');
        $field = $form->getField('translations');

        $fileField->value = $this->getFilterValue('file');
        $searchField->value = $this->getFilterValue('search');
        $stringFilterField->value = $this->getFilterValue('string_filter', 'all');
        $field->value = $this->getFilterValue('search');

        if (is_null($this->localeFiles))
            $this->localeFiles = LanguageManager::instance()->listLocaleFiles('en');

        $fileField->options = $this->prepareNamespaces();
        $field->options = post($field->getName()) ?: $this->prepareTranslations($form->model);

        $this->vars['totalStrings'] = $this->totalStrings;
        $this->vars['totalTranslated'] = $this->totalTranslated;
        $this->vars['translatedProgress'] = $this->totalStrings ? round(($this->totalTranslated * 100) / $this->totalStrings, 2) : 0;
    }

    protected function getFilterValue($key, $default = null)
    {
        return $this->getSession('translation_'.$key, $default);
    }

    protected function setFilterValue($key, $value)
    {
        $this->putSession('translation_'.$key, trim($value));
    }

    protected function prepareNamespaces()
    {
        $result = [];

        $extensionManager = ExtensionManager::instance();

        foreach ($this->localeFiles as $file) {
            $name = sprintf('%s::%s', $file['namespace'], $file['group']);

            if (!array_get($file, 'system', FALSE)
                && ($extension = $extensionManager->findExtension($file['namespace']))) {
                $result[$name] = array_get($extension->extensionMeta(), 'name').' - '.$name;
            }
            else {
                $result[$name] = ucfirst($file['namespace']).' - '.$name;
            }
        }

        return $result;
    }

    protected function prepareTranslations($model)
    {
        $this->totalStrings = 0;
        $this->totalTranslated = 0;
        $stringFilter = $this->getFilterValue('string_filter');
        $files = collect($this->localeFiles);

        $file = $this->getFilterValue('file');
        if (strlen($file) && strpos($file, '::')) {
            [$namespace, $group] = explode('::', $file);
            $files = $files->where('group', $group)->where('namespace', $namespace);
        }

        $manager = LanguageManager::instance();

        $result = [];
        $files->each(function ($file) use ($manager, $model, &$result, $stringFilter) {
            $sourceLines = $model->getLines('en', $file['group'], $file['namespace']);
            $translationLines = $model->getTranslations($file['group'], $file['namespace']);

            $this->totalStrings += count($sourceLines);
            $this->totalTranslated += count($translationLines);

            $translations = $manager->listTranslations($sourceLines, $translationLines, [
                'file' => $file,
                'stringFilter' => $stringFilter,
            ]);

            $result = array_merge($result, $translations);
        });

        $term = $this->getFilterValue('search');
        $result = $manager->searchTranslations($result, $term);

        return $manager->paginateTranslations($result);
    }
}
