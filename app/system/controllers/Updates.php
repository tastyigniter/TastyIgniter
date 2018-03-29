<?php namespace System\Controllers;

use AdminMenu;
use Assets;
use Exception;
use Flash;
use System\Classes\UpdateManager;
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
        if (!params()->has('carte_key')) {
            Flash::warning(lang('system::default.missing.carte_key'))->now();
        }

        if ($force = get('check')) {
            UpdateManager::instance()->requestUpdateList($force == 'force');

            return $this->redirectBack();
        }

        $pageTitle = lang('system::updates.text_title');
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        Template::setButton(lang('system::updates.button_check'), ['class' => 'btn btn-success', 'href' => admin_url($this->forceCheckUrl)]);
        Template::setButton(sprintf(lang('system::updates.button_browse'), 'extensions'), ['class' => 'btn btn-default', 'href' => admin_url($this->browseUrl.'/extensions')]);
        Template::setButton(lang('system::updates.button_carte'), ['class' => 'btn btn-default pull-right', 'data-target' => '#carte-modal', 'data-toggle' => 'modal']);

        $this->prepareAssets();

        $updateManager = UpdateManager::instance();

        $this->vars['carteInfo'] = $updateManager->getSiteDetail();
        $this->vars['installedItems'] = $updateManager->getInstalledItems();

        try {
            $this->vars['updates'] = $updates = $updateManager->requestUpdateList();

            $lastChecked = isset($updates['last_check']) ? time_elapsed($updates['last_check']) : lang('system::updates.text_never');

            Template::setButton(sprintf(lang('system::updates.text_last_checked'), $lastChecked), ['class' => 'btn disabled text-muted pull-right']);

            if (isset($updates['items']) AND $updates['items'] > 0) {
                Template::setButton(lang('system::updates.button_update'), ['class' => 'btn btn-primary pull-left', 'id' => 'apply-updates']);
            }
        } catch (Exception $ex) {
            Flash::warning($ex->getMessage())->now();
        }
    }

    public function browse($context, $itemType = null)
    {
        if (!params()->has('carte_key')) {
            Flash::warning(lang('system::default.missing.carte_key'))->now();
        }

        $updateManager = UpdateManager::instance();

        $pageTitle = ($itemType == 'extensions') ? lang('system::updates.text_tab_title_extensions') : lang('system::updates.text_tab_title_themes');
        Template::setTitle(sprintf(lang('system::updates.text_browse_title'), $pageTitle));
        Template::setHeading(sprintf(lang('system::updates.text_browse_title'), $pageTitle));

        $buttonType = ($itemType == 'extensions') ? 'themes' : 'extensions';
        $buttonTitle = ($buttonType == 'extensions') ? lang('system::updates.text_tab_title_extensions') : lang('system::updates.text_tab_title_themes');
        Template::setButton(lang('system::updates.button_updates'), ['class' => 'btn btn-success', 'href' => admin_url($this->checkUrl)]);
        Template::setButton(sprintf(lang('system::updates.button_browse'), $buttonTitle), ['class' => 'btn btn-default', 'href' => admin_url($this->browseUrl.'/'.$buttonType)]);
        Template::setButton(lang('system::updates.button_carte'), ['class' => 'btn btn-default pull-right', 'data-target' => '#carte-modal', 'data-toggle' => 'modal']);

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

            $itemType = isset($filter['type']) ? $filter['type'] : 'extension';
            $searchQuery = isset($filter['search']) ? strtolower($filter['search']) : '';

            try {
                $json = UpdateManager::instance()->searchItems($itemType, $searchQuery);
            } catch (Exception $ex) {
                $json = $ex->getMessage();
            }
        }

        return $json;
    }

    protected function prepareAssets()
    {
        Assets::addCss(assets_url('css/app/marketplace.css'), 'marketplace-css');
        Assets::addJs(assets_url('js/vendor/mustache.js'), 'mustache-js');
        Assets::addJs(assets_url('js/vendor/typeahead.js'), 'typeahead-js');
        Assets::addJs(assets_url('js/app/flashmessage.js'), 'flashmessage-js');
        Assets::addJs(assets_url('js/app/updates.js'), 'updates-js');
    }

    public function index_onApplyCarte()
    {
        return $this->applyCarte();
    }

    public function index_onApply($context = null)
    {
        return $this->applyInstallOrUpdate($context);
    }

    public function index_onIgnoreUpdates()
    {
        try {
            $items = post('items');
            if (!$items OR count($items) < 1)
                throw new Exception('Select item(s) to ignore.');

            $updateManager = UpdateManager::instance();

            $updateManager->ignoreUpdates($items);

            $updates = $updateManager->requestUpdateList();

            $json = [
                '#updates' => $this->makePartial('updates/list', ['updates' => $updates]),
            ];
        } catch (Exception $ex) {
            $this->statusCode = 500;
            $json = $ex->getMessage();
        }

        return $json;
    }

    public function index_onProcess()
    {
        return $this->processInstallOrUpdate();
    }

    public function browse_onFetchItems()
    {

        try {
            $itemType = post('type');
            $items = UpdateManager::instance()->listItems($itemType);

            return [
                '#list-items' => $this->makePartial('browse/list', ['items' => $items]),
            ];
        } catch (Exception $ex) {
            $this->statusCode = 500;

            return $ex->getMessage();
        }
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
        try {
            $carteKey = post('carte_key');
            if (!strlen($carteKey))
                throw new Exception('No carte key specified.');

            $json = UpdateManager::instance()->applySiteDetail($carteKey);

            $json = [
                '#carte-details' => $this->makePartial('updates/carte_info', ['carteInfo' => $json]),
            ];
        } catch (Exception $ex) {
            $this->statusCode = 500;
            $json = $ex->getMessage();
        }

        return $json;
    }

    protected function applyInstallOrUpdate($context)
    {
        $error = null;

        try {
            $items = input('items');

            if (!count($items))
                throw new Exception('No item(s) specified.');

            $this->validateItems();

            $context = ($context != 'index') ? 'install' : 'update';
            $response = UpdateManager::instance()->applyItems($items, $context);

            $json['steps'] = $this->buildProcessSteps($response, $items);
        } catch (Exception $ex) {
            $this->statusCode = 500;
            $json = $ex->getMessage();
        }

        return $json;
    }

    protected function buildProcessSteps($meta, $params = [])
    {
        $processSteps = [];

        foreach (['download', 'extract', 'complete'] as $step) {

            // Silly way to sort the process
            $applySteps = [
                'core'         => [],
                'extensions'   => [],
                'themes'       => [],
                'translations' => [],
            ];

            if ($step == 'complete') {
                $processSteps[$step][] = [
                    'items'   => $meta['data'],
                    'process' => $step,
                    'label'   => lang("progress_{$step}"),
                    'success' => sprintf(lang("progress_success"), rtrim($step, 'e').'ing', ''),
                ];

                continue;
            }

            foreach ($meta['data'] as $item) {
                if ($item['type'] == 'core') {
                    $applySteps['core'][] = array_merge([
                        'action'  => 'update',
                        'process' => "{$step}Core",
                        'label'   => sprintf(lang("progress_{$step}"), "{$item['name']}".' update'),
                        'success' => sprintf(lang("progress_success"), $step.'ing', $item['name']),
                    ], $item);
                }
                else {
                    $singularType = str_singular($item['type']);
                    $pluralType = str_plural($item['type']);

                    $action = $this->getActionFromItems($item['code'], $params);
                    $applySteps[$pluralType][] = array_merge([
                        'action'  => $action,
                        'process' => camelize(underscore("{$step} {$singularType}")),
                        'label'   => sprintf(lang("progress_{$step}"), "{$item['name']} {$singularType}".' '.$action),
                        'success' => sprintf(lang("progress_success"), $step.'ing', $item['name']),
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

        try {
            $this->validateProcess();

            $meta = post('meta');

            $params = [];
            if (post('step') != 'complete') {
                $params = !isset($meta['code']) ? [] : [
                    'name'   => $meta['code'],
                    'type'   => $meta['type'],
                    'ver'    => $meta['version'],
                    'action' => $meta['action'],
                ];
            }

            $updateManager = UpdateManager::instance();

            $processMeta = $meta['process'];
            switch ($processMeta) {
                case 'downloadCore':
                case 'downloadExtension':
                case 'downloadTheme':
                case 'downloadTranslation':
                    $result = $updateManager->downloadFile($meta['code'], $meta['hash'], $params);
                    if ($result) $json['result'] = 'success';
                    break;

                case 'extractCore':
                    $response = $updateManager->extractCore($meta['code']);
                    if ($response) $json['result'] = 'success';
                    break;

                case 'extractExtension':
                case 'extractTheme':
                case 'extractTranslation':
                    $response = $updateManager->extractFile($meta['code'], $meta['type']);
                    if ($response) $json['result'] = 'success';
                    break;

                case 'complete':
                    $response = $this->completeProcess($meta['items']);
                    if ($response) $json['result'] = 'success';
                    break;
            }
        } catch (Exception $ex) {
            $this->statusCode = 500;
            $json = $ex->getMessage();
        }

        return $json;
    }

    protected function completeProcess($meta)
    {
        if (isset($post['type'], $post['action']) AND $post['action'] == 'update') {
            $updateManager = UpdateManager::instance();

            switch ($post['type']) {
                case 'extension':
                    $updateManager->updateExtension($post['code']);
                    break;
                case 'theme':
                    $updateManager->updateTheme($post['code']);
                    break;
                case 'translation':
                    $updateManager->updateTranslation($post['code']);
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
        foreach (post('items') as $key => $value) {
            $this->form_validation->set_rules('items['.$key.'][name]', 'lang:system::updates.label_meta_code', 'required');
            $this->form_validation->set_rules('items['.$key.'][type]', 'lang:system::updates.label_meta_type', 'required');
            $this->form_validation->set_rules('items['.$key.'][ver]', 'lang:system::updates.label_meta_version', 'required');
            $this->form_validation->set_rules('items['.$key.'][action]', 'lang:system::updates.label_meta_action', 'required|in_list[install,update]');
        }

        if ($this->form_validation->run() === FALSE) {
            throw new Exception($this->form_validation->error_string());
        }
    }

    protected function validateProcess()
    {
        if (post('step') != 'complete') {
            $this->form_validation->set_rules('meta[code]', 'lang:system::updates.label_meta_code', 'required');
            $this->form_validation->set_rules('meta[type]', 'lang:system::updates.label_meta_type', 'required');
            $this->form_validation->set_rules('meta[version]', 'lang:system::updates.label_meta_version', 'required');
            $this->form_validation->set_rules('meta[hash]', 'lang:system::updates.label_meta_hash', 'required');
            $this->form_validation->set_rules('meta[description]', 'lang:system::updates.label_meta_description', 'required');
            $this->form_validation->set_rules('meta[action]', 'lang:system::updates.label_meta_action', 'required|in_list[install,update]');
        }
        else {
            $this->form_validation->set_rules('meta[items]', 'lang:system::updates.label_meta_items', 'required');
        }

        $this->form_validation->set_rules('step', 'lang:system::updates.label_meta_step', 'required|in_list[download,extract,complete]');

        if ($this->form_validation->run() === FALSE) {
            throw new Exception($this->form_validation->error_string());
        }
    }
}