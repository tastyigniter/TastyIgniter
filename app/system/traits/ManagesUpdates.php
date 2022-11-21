<?php

namespace System\Traits;

use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Support\Facades\File;
use Main\Classes\ThemeManager;
use System\Classes\ComposerManager;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;

trait ManagesUpdates
{
    public function search()
    {
        $json = [];

        if (($filter = input('filter')) && is_array($filter)) {
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

    public function onApplyRecommended()
    {
        $itemsCodes = post('install_items') ?? [];
        $items = collect(post('items') ?? [])->whereIn('name', $itemsCodes);
        if ($items->isEmpty())
            throw new ApplicationException(lang('system::lang.updates.alert_no_items'));

        $this->validateItems();

        $response = UpdateManager::instance()->requestApplyItems($items->all());
        $response = array_get($response, 'data', []);

        return [
            'steps' => $this->buildProcessSteps($response, $items),
        ];
    }

    public function onApplyItems()
    {
        $items = post('items') ?? [];
        if (!count($items))
            throw new ApplicationException(lang('system::lang.updates.alert_no_items'));

        $this->validateItems();

        $response = UpdateManager::instance()->requestApplyItems($items);
        $response = collect(array_get($response, 'data', []))
            ->whereIn('code', collect($items)->pluck('name')->all())
            ->all();

        return [
            'steps' => $this->buildProcessSteps($response, $items),
        ];
    }

    public function onApplyUpdate()
    {
        $items = post('items') ?? [];
        if (!count($items))
            throw new ApplicationException(lang('system::lang.updates.alert_no_items'));

        $this->validateItems();

        $updates = UpdateManager::instance()->requestUpdateList(input('check') == 'force');
        $response = array_get($updates, 'items');

        return [
            'steps' => $this->buildProcessSteps($response, $items),
        ];
    }

    public function onLoadRecommended()
    {
        $itemType = post('itemType');
        $items = (in_array($itemType, ['theme', 'extension']))
            ? UpdateManager::instance()->listItems($itemType)
            : [];

        return $this->makePartial('updates/list_recommended', [
            'items' => $items,
            'itemType' => $itemType,
        ]);
    }

    public function onCheckUpdates()
    {
        $updateManager = UpdateManager::instance();
        $updateManager->requestUpdateList(true);

        return $this->redirect($this->checkUrl);
    }

    public function onIgnoreUpdate()
    {
        $items = post('items');
        if (!$items || count($items) < 1)
            throw new ApplicationException(lang('system::lang.updates.alert_item_to_ignore'));

        $updateManager = UpdateManager::instance();

        $updateManager->ignoreUpdates($items);

        $updates = $updateManager->requestUpdateList(input('check') == 'force');

        return [
            '#updates' => $this->makePartial('updates/list', ['updates' => $updates]),
        ];
    }

    public function onApplyCarte()
    {
        $carteKey = post('carte_key');
        if (!strlen($carteKey))
            throw new ApplicationException(lang('system::lang.updates.alert_no_carte_key'));

        $response = UpdateManager::instance()->applySiteDetail($carteKey);

        $this->ensureComposerAuthConfigured();

        return [
            '#carte-details' => $this->makePartial('updates/carte_info', ['carteInfo' => $response]),
        ];
    }

    public function onProcessItems()
    {
        return $this->processInstallOrUpdate();
    }

    //
    //
    //

    protected function initUpdate($itemType)
    {
        $this->ensureComposerRepositoryAndAuthConfigured();

        $this->prepareAssets();

        $updateManager = UpdateManager::instance();

        $this->vars['itemType'] = $itemType;
        $this->vars['carteInfo'] = $updateManager->getSiteDetail();
        $this->vars['installedItems'] = $updateManager->getInstalledItems();
    }

    protected function prepareAssets()
    {
        $this->addJs('src/js/vendor/mustache.js', 'mustache-js');
        $this->addJs('src/js/vendor/typeahead.js', 'typeahead-js');
        $this->addJs('js/updates.js', 'updates-js');
        $this->addJs('~/app/admin/formwidgets/recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');
    }

    protected function buildProcessSteps($response, $params = [])
    {
        $processSteps = [];
        foreach (['install', 'complete'] as $step) {
            if ($step == 'complete') {
                $processSteps[$step][] = [
                    'items' => $response,
                    'process' => $step,
                    'label' => lang("system::lang.updates.progress_complete"),
                    'success' => lang('system::lang.updates.progress_success'),
                ];
            }
            else {
                $processSteps[$step][] = [
                    'items' => $response,
                    'process' => 'updateComposer',
                    'label' => lang("system::lang.updates.progress_composer"),
                    'success' => lang('system::lang.updates.progress_composer_success'),
                ];

                if ($coreUpdate = collect($response)->firstWhere('type', 'core')) {
                    $processSteps[$step][] = array_merge($coreUpdate, [
                        'action' => 'update',
                        'process' => "{$step}Core",
                        'label' => lang("system::lang.updates.progress_core"),
                        'success' => lang('system::lang.updates.progress_core_success'),
                    ]);
                }

                $addonUpdates = collect($response)->where('type', '!=', 'core');
                if ($addonUpdates->isNotEmpty()) {
                    $processSteps[$step][] = [
                        'items' => $addonUpdates->all(),
                        'process' => "{$step}Addon",
                        'label' => lang("system::lang.updates.progress_addons"),
                        'success' => lang('system::lang.updates.progress_addons_success'),
                    ];
                }
            }
        }

        return $processSteps;
    }

    protected function processInstallOrUpdate()
    {
        $json = [];

        $this->validateProcess();

        $meta = post('meta');

        $composerManager = ComposerManager::instance();

        $result = false;
        switch ($meta['process']) {
            case 'updateComposer':
                $result = $composerManager->require(['composer/composer']);
                break;
            case 'installCore':
                $result = $composerManager->requireCore($meta['version']);
                break;
            case 'installAddon':
                $result = $composerManager->require(collect($meta['items'])->map(function ($item) {
                    return $item['package'].':'.$item['version'];
                })->all());
                break;

            case 'complete':
                $result = $this->completeProcess($meta['items']);
                break;
        }

        if ($result) $json['result'] = 'success';

        return $json;
    }

    protected function completeProcess($items)
    {
        if (!count($items))
            return false;

        foreach ($items as $item) {
            if ($item['type'] == 'core') {
                $updateManager = UpdateManager::instance();
                $updateManager->update();
                $updateManager->setCoreVersion($item['version'], $item['hash']);

                break;
            }

            switch ($item['type']) {
                case 'extension':
                    ExtensionManager::instance()->installExtension($item['code'], $item['version']);
                    break;
                case 'theme':
                    ThemeManager::instance()->installTheme($item['code'], $item['version']);
                    break;
            }
        }

        UpdateManager::instance()->requestUpdateList(true);

        return true;
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
        return $this->validate(post(), [
            'items.*.name' => ['required'],
            'items.*.type' => ['required', 'in:core,extension,theme,language'],
            'items.*.ver' => ['required'],
            'items.*.action' => ['required', 'in:install,update'],
        ], [], [
            'items.*.name' => lang('system::lang.updates.label_meta_code'),
            'items.*.type' => lang('system::lang.updates.label_meta_type'),
            'items.*.ver' => lang('system::lang.updates.label_meta_version'),
            'items.*.action' => lang('system::lang.updates.label_meta_action'),
        ]);
    }

    protected function validateProcess()
    {
        $rules = [
            'meta.code' => ['sometimes', 'required'],
            'meta.type' => ['sometimes', 'required', 'in:core,extension,theme,language'],
            'meta.version' => ['sometimes', 'required'],
            'meta.hash' => ['sometimes', 'required'],
            'meta.description' => ['sometimes'],
            'meta.action' => ['sometimes', 'required', 'in:install,update'],
        ];

        $attributes = [
            'meta.code' => lang('system::lang.updates.label_meta_code'),
            'meta.type' => lang('system::lang.updates.label_meta_type'),
            'meta.version' => lang('system::lang.updates.label_meta_version'),
            'meta.hash' => lang('system::lang.updates.label_meta_hash'),
            'meta.description' => lang('system::lang.updates.label_meta_description'),
            'meta.action' => lang('system::lang.updates.label_meta_action'),
        ];

        $rules['step'] = ['required', 'in:install,complete'];
        $rules['meta.items'] = ['sometimes', 'required', 'array'];

        $attributes['step'] = lang('system::lang.updates.label_meta_step');
        $attributes['meta.items'] = lang('system::lang.updates.label_meta_items');

        return $this->validate(post(), $rules, [], $attributes);
    }

    protected function ensureComposerRepositoryAndAuthConfigured()
    {
        $composerManager = ComposerManager::instance();

        if (!$composerManager->hasRepository('https://satis.tastyigniter.com')) {
            $composerManager->addRepository('tastyigniter', 'composer', 'https://satis.tastyigniter.com');
        }

        if (!File::exists(base_path('auth.json'))) {
            $this->ensureComposerAuthConfigured();
        }
    }

    protected function ensureComposerAuthConfigured()
    {
        if ($carteInfo = params('carte_info')) {
            ComposerManager::instance()->addAuthCredentials('satis.tastyigniter.com', $carteInfo['email'], params('carte_key'));
        }
    }
}
