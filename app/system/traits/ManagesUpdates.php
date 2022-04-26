<?php

namespace System\Traits;

use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Main\Classes\ThemeManager;
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
                    'items' => $response,
                    'process' => $step,
                    'label' => lang("system::lang.updates.progress_{$step}"),
                    'success' => sprintf(lang('system::lang.updates.progress_success'), rtrim($step, 'e').'ing', ''),
                ];

                continue;
            }

            foreach ($response as $item) {
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
                        'action' => $action ?? 'install',
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
                $response = $updateManager->extractFile($meta['code'], extension_path('/'));
                if ($response) $json['result'] = 'success';
                break;
            case 'extractTheme':
                $response = $updateManager->extractFile($meta['code'], theme_path('/'));
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
            return false;

        foreach ($items as $item) {
            switch ($item['type']) {
                case 'core':
                    $updateManager = UpdateManager::instance();
                    $updateManager->update();
                    $updateManager->setCoreVersion($item['version'], $item['hash']);
                    break;
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
            'items.*.type' => ['required', 'in:core,extension,theme'],
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
        if (post('step') != 'complete') {
            $rules = [
                'meta.code' => ['required'],
                'meta.type' => ['required', 'in:core,extension,theme'],
                'meta.version' => ['required'],
                'meta.hash' => ['required'],
                'meta.description' => ['sometimes'],
                'meta.action' => ['required', 'in:install,update'],
            ];

            $attributes = [
                'meta.code' => lang('system::lang.updates.label_meta_code'),
                'meta.type' => lang('system::lang.updates.label_meta_type'),
                'meta.version' => lang('system::lang.updates.label_meta_version'),
                'meta.hash' => lang('system::lang.updates.label_meta_hash'),
                'meta.description' => lang('system::lang.updates.label_meta_description'),
                'meta.action' => lang('system::lang.updates.label_meta_action'),
            ];
        }
        else {
            $rules = ['meta.items' => ['required', 'array']];
            $attributes = ['meta.items' => lang('system::lang.updates.label_meta_items')];
        }

        $rules['step'] = ['required', 'in:download,extract,complete'];
        $attributes['step'] = lang('system::lang.updates.label_meta_step');

        return $this->validate(post(), $rules, [], $attributes);
    }
}
