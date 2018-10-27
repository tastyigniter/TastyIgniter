<?php namespace System\Controllers;

use AdminMenu;
use ApplicationException;
use Exception;
use Flash;
use System\Classes\UpdateManager;
use System\Models\Extensions_model;
use System\Models\Themes_model;
use Template;

class Updates extends \Admin\Classes\AdminController
{
    public $checkUrl = 'updates';

    public $forceCheckUrl = 'updates?check=force';

    public $browseUrl = 'updates/browse';

    protected $requiredPermissions = 'Site.Updates';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('updates', 'system');
    }

    public function index()
    {
        if ($this->getUser()->hasPermission('Admin.Extensions.Manage'))
            Extensions_model::syncAll();

        Themes_model::syncAll();

        if (!params()->has('carte_key')) {
            Flash::warning(lang('system::lang.missing.carte_key'))->now();
        }

        $pageTitle = lang('system::lang.updates.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        Template::setButton(sprintf(lang('system::lang.updates.button_browse'), 'extensions'), ['class' => 'btn btn-default', 'href' => admin_url($this->browseUrl.'/extensions')]);
        if (input('check') == 'force') {
            Template::setButton(lang('system::lang.updates.button_updates'), ['class' => 'btn btn-success', 'href' => admin_url($this->checkUrl)]);
        }
        else {
            Template::setButton(lang('system::lang.updates.button_check'), ['class' => 'btn btn-success', 'href' => admin_url($this->forceCheckUrl)]);
        }
        Template::setButton(lang('system::lang.updates.button_carte'), ['class' => 'btn btn-default pull-right', 'role' => 'button', 'data-target' => '#carte-modal', 'data-toggle' => 'modal']);

        Template::setButton(sprintf(lang('system::lang.version'), params('ti_version')), [
            'class' => 'btn disabled text-muted pull-right', 'role' => 'button',
        ]);

        $this->prepareAssets();

        try {
            $updateManager = UpdateManager::instance();
            $this->vars['carteInfo'] = $updateManager->getSiteDetail();
            $this->vars['updates'] = $updates = $updateManager->requestUpdateList(input('check') == 'force');

            $lastChecked = isset($updates['last_check'])
                ? time_elapsed($updates['last_check'])
                : lang('admin::lang.text_never');

            Template::setButton(sprintf(lang('system::lang.updates.text_last_checked'), $lastChecked), [
                'class' => 'btn disabled text-muted pull-right', 'role' => 'button',
            ]);

            if (!empty($updates['items']) OR !empty($updates['ignoredItems'])) {
                Template::setButton(lang('system::lang.updates.button_update'), [
                    'class' => 'btn btn-primary pull-left mr-2',
                    'id' => 'apply-updates', 'role' => 'button',
                ]);
            }
        }
        catch (Exception $ex) {
            Flash::warning($ex->getMessage())->now();
        }
    }

    public function browse($context, $itemType = null)
    {
        if (!params()->has('carte_key')) {
            Flash::warning(lang('system::lang.missing.carte_key'))->now();
        }

        $updateManager = UpdateManager::instance();

        $pageTitle = ($itemType == 'extensions') ? lang('system::lang.updates.text_tab_title_extensions') : lang('system::lang.updates.text_tab_title_themes');
        Template::setTitle(sprintf(lang('system::lang.updates.text_browse_title'), $pageTitle));
        Template::setHeading(sprintf(lang('system::lang.updates.text_browse_title'), $pageTitle));

        $buttonType = ($itemType == 'extensions') ? 'themes' : 'extensions';
        $buttonTitle = ($buttonType == 'extensions')
            ? lang('system::lang.updates.text_tab_title_extensions')
            : lang('system::lang.updates.text_tab_title_themes');

        Template::setButton(sprintf(lang('system::lang.updates.button_browse'), $buttonTitle), ['class' => 'btn btn-default', 'href' => admin_url($this->browseUrl.'/'.$buttonType)]);
        Template::setButton(lang('system::lang.updates.button_updates'), ['class' => 'btn btn-success', 'href' => admin_url($this->checkUrl)]);
        Template::setButton(lang('system::lang.updates.button_carte'), ['class' => 'btn btn-default pull-right', 'role' => 'button', 'data-target' => '#carte-modal', 'data-toggle' => 'modal']);

        $this->prepareAssets();

        $this->vars['searchActionUrl'] = admin_url('updates/search');
        $this->vars['itemType'] = str_singular($itemType);
        $this->vars['carteInfo'] = $updateManager->getSiteDetail();
        $this->vars['installedItems'] = $updateManager->getInstalledItems();

        return $this->makeView('browse/index');
    }

    public function search()
    {
        $json = [];

        if ($filter = input('filter') AND is_array($filter)) {

            $itemType = $filter['type'] ?? 'extension';
            $searchQuery = isset($filter['search']) ? strtolower($filter['search']) : '';

            try {
                $json = UpdateManager::instance()->searchItems($itemType, $searchQuery);
            }
            catch (Exception $ex) {
                $json = $ex->getMessage();
            }
        }

        return $json;
    }

    protected function prepareAssets()
    {
        $this->addJs('ui/js/vendor/mustache.js', 'mustache-js');
        $this->addJs('ui/js/vendor/typeahead.js', 'typeahead-js');
        $this->addJs('ui/js/updates.js', 'updates-js');
    }

    public function index_onApplyCarte()
    {
        return $this->applyCarte();
    }

    public function index_onApply($context = null)
    {
        return $this->applyInstallOrUpdate($context);
    }

    public function index_onIgnoreUpdate()
    {
        $items = post('items');
        if (!$items OR count($items) < 1)
            throw new ApplicationException('Select item(s) to ignore.');

        $updateManager = UpdateManager::instance();

        $updateManager->ignoreUpdates($items);

        $updates = $updateManager->requestUpdateList(input('check') == 'force');

        return [
            '#updates' => $this->makePartial('updates/list', ['updates' => $updates]),
        ];
    }

    public function index_onProcess()
    {
        return $this->processInstallOrUpdate();
    }

    public function browse_onFetchItems()
    {
        $itemType = post('type');
        $items = UpdateManager::instance()->listItems($itemType);

        return [
            '#list-items' => $this->makePartial('browse/list', [
                'items' => $items,
                'itemType' => $itemType,
            ]),
        ];
    }

    public function browse_onApplyCarte()
    {
        return $this->applyCarte();
    }

    public function browse_onApply($context = null)
    {
        return $this->applyInstallOrUpdate($context);
    }

    public function browse_onProcess()
    {
        return $this->processInstallOrUpdate();
    }

    protected function applyCarte()
    {
        $carteKey = post('carte_key');
        if (!strlen($carteKey))
            throw new ApplicationException('No carte key specified.');

        $response = UpdateManager::instance()->applySiteDetail($carteKey);

        return [
            '#carte-details' => $this->makePartial('updates/carte_info', ['carteInfo' => $response]),
        ];
    }

    protected function applyInstallOrUpdate($context)
    {
        $error = null;

        $items = input('items');

        if (!count($items))
            throw new ApplicationException('No item(s) specified.');

        $this->validateItems();

        if ($context == 'index') {
            $updates = UpdateManager::instance()->requestUpdateList(input('check') == 'force');
            $response['data'] = array_get($updates, 'items');
        }
        else {
            $response = UpdateManager::instance()->requestApplyItems($items);
        }

        return [
            'steps' => $this->buildProcessSteps($response, $items),
        ];
    }

    protected function buildProcessSteps($meta, $params = [])
    {
        $processSteps = [];
        if (!count($meta['data']))
            return $processSteps;

        foreach (['download', 'extract', 'complete'] as $step) {

            // Silly way to sort the process
            $applySteps = [
                'core' => [],
                'extensions' => [],
                'themes' => [],
                'translations' => [],
            ];

            if ($step == 'complete') {
                $processSteps[$step][] = [
                    'items' => $meta['data'],
                    'process' => $step,
                    'label' => lang("system::lang.updates.progress_{$step}"),
                    'success' => sprintf(lang('system::lang.updates.progress_success'), rtrim($step, 'e').'ing', ''),
                ];

                continue;
            }

            foreach (array_get($meta, 'data') as $item) {
                if ($item['type'] == 'core') {
                    $applySteps['core'][] = array_merge([
                        'action' => 'update',
                        'process' => "{$step}Core",
                        'label' => sprintf(lang("system::lang.updates.progress_{$step}"), $item['name'].' update'),
                        'success' => sprintf(lang('system::lang.updates.progress_success'), $step.'ing', $item['name']),
                    ], $item);
                }
                else {
                    $singularType = str_singular($item['type']);
                    $pluralType = str_plural($item['type']);

                    $action = $this->getActionFromItems($item['code'], $params);
                    $applySteps[$pluralType][] = array_merge([
                        'action' => $action,
                        'process' => $step.ucfirst($singularType),
                        'label' => sprintf(lang("system::lang.updates.progress_{$step}"), "{$item['name']} {$singularType}"),
                        'success' => sprintf(lang('system::lang.updates.progress_success'), $step.'ing', $item['name']),
                    ], $item);
                }
            }

            $processSteps[$step] = array_collapse(array_values($applySteps));
        }

        return $processSteps;
    }

    protected function processInstallOrUpdate()
    {
        $json = [];

        $this->validateProcess();

        $meta = post('meta');

        $params = [];
        if (post('step') != 'complete') {
            $params = !isset($meta['code']) ? [] : [
                'name' => $meta['code'],
                'type' => $meta['type'],
                'ver' => $meta['version'],
                'action' => $meta['action'],
            ];
        }

        $updateManager = UpdateManager::instance();

        $processMeta = $meta['process'];
        switch ($processMeta) {
            case 'downloadCore':
            case 'downloadExtension':
            case 'downloadTheme':
                $result = $updateManager->downloadFile($meta['code'], $meta['hash'], $params);
                if ($result) $json['result'] = 'success';
                break;

            case 'extractCore':
                $response = $updateManager->extractCore($meta['code']);
                if ($response) $json['result'] = 'success';
                break;

            case 'extractExtension':
                $response = $updateManager->extractFile($meta['code'], 'extensions/');
                if ($response) $json['result'] = 'success';
                break;
            case 'extractTheme':
                $response = $updateManager->extractFile($meta['code'], 'themes/');
                if ($response) $json['result'] = 'success';
                break;

            case 'complete':
                $response = $this->completeProcess($meta['items']);
                if ($response) $json['result'] = 'success';
                break;
        }

        return $json;
    }

    protected function completeProcess($items)
    {
        if (!count($items))
            return FALSE;

        $updateManager = UpdateManager::instance();

        foreach ($items as $item) {
            switch ($item['type']) {
                case 'core':
                    $updateManager->update();
                    $updateManager->setCoreVersion($item['version'], $item['hash']);
                    break;
                case 'extension':
                    Extensions_model::install($item['code'], $item['version']);
                    break;
            }
        }

        return TRUE;
    }

    protected function getActionFromItems($code, $itemNames)
    {
        foreach ($itemNames as $itemName) {
            if ($code == $itemName['name'])
                return $itemName['action'];
        }
    }

    protected function validateItems()
    {
        $rules = [
            ['items.*.name', 'lang:system::lang.updates.label_meta_code', 'required'],
            ['items.*.type', 'lang:system::lang.updates.label_meta_type', 'required'],
            ['items.*.ver', 'lang:system::lang.updates.label_meta_version', 'required'],
            ['items.*.action', 'lang:system::lang.updates.label_meta_action', 'required|in:install,update'],
        ];

        return $this->validatePasses(post(), $rules);
    }

    protected function validateProcess()
    {
        $rules = [];
        if (post('step') != 'complete') {
            $rules[] = ['meta.code', 'lang:system::lang.updates.label_meta_code', 'required'];
            $rules[] = ['meta.type', 'lang:system::lang.updates.label_meta_type', 'required'];
            $rules[] = ['meta.version', 'lang:system::lang.updates.label_meta_version', 'required'];
            $rules[] = ['meta.hash', 'lang:system::lang.updates.label_meta_hash', 'required'];
            $rules[] = ['meta.description', 'lang:system::lang.updates.label_meta_description', 'sometimes'];
            $rules[] = ['meta.action', 'lang:system::lang.updates.label_meta_action', 'required|in:install,update'];
        }
        else {
            $rules[] = ['meta.items', 'lang:system::lang.updates.label_meta_items', 'required|array'];
        }

        $rules[] = ['step', 'lang:system::lang.updates.label_meta_step', 'required|in:download,extract,complete'];

        return $this->validatePasses(post(), $rules);
    }
}