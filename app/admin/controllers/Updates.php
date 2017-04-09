<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Updates extends Admin_Controller
{

    public $check_url = 'updates';
    public $force_check_url = 'updates?check=force';
    public $browse_url = 'updates/browse/{item}';

    public function __construct()
    {
        parent::__construct();

        $this->user->restrict('Site.Updates');

        $this->load->library('updates_manager');
        $this->load->library('hub_manager');

        $this->lang->load('updates');
    }

    public function index()
    {
        $ignore_update = $this->input->get('ignore_update');
        if ($ignore_update AND $this->updates_manager->ignoreUpdate($ignore_update)) {
            $this->redirect($this->check_url);
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

        if ($this->config->item('site_key')) {
            $this->template->setButton($this->lang->line('button_edit_site'), ['class' => 'btn btn-info', 'href' => $this->pageUrl('settings#system')]);
        } else {
            $this->template->setButton($this->lang->line('button_add_site'), ['class' => 'btn btn-success', 'href' => $this->pageUrl('settings#system')]);
        }

        $this->template->setButton(sprintf($this->lang->line('button_browse'), $this->lang->line('text_tab_title_extensions')), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->browse_url, ['item' => 'extensions'])]);
        $this->template->setButton($this->lang->line('button_check'), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->force_check_url)]);

        $this->assets->setStyleTag(assets_url('css/app/marketplace.css'), 'marketplace-css');
        $this->assets->setScriptTag(assets_url('js/mustache.js'), 'mustache-js', '20');
        $this->assets->setScriptTag(assets_url('js/app/updates.js'), 'updates-js', '22');

        $data['installed_items'] = $this->updates_manager->getInstalledItems();

        $force = $this->input->get('check') === 'force' ? TRUE : FALSE;
        $data['updates'] = $this->updates_manager->requestUpdateList($force);

        if (is_string($data['updates']))
            $this->alert->set('warning', $data['updates']);

        if (!empty($data['updates']['core']) AND empty($data['updates']['core']['ignored']))
            $this->alert->set('warning', $this->lang->line('alert_modification_warning'));

        $this->template->render('updates', $data);
    }

    public function browse()
    {
        $item_type = $this->uri->rsegment(3);
        $title = ($item_type == 'extensions') ? $this->lang->line('text_tab_title_extensions') : $this->lang->line('text_tab_title_themes');
        $this->template->setTitle(sprintf($this->lang->line('text_browse_title'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_browse_heading'), $title));

        if ($this->config->item('site_key')) {
            $this->template->setButton($this->lang->line('button_edit_site'), ['class' => 'btn btn-info', 'href' => $this->pageUrl('settings#system')]);
        } else {
            $this->template->setButton($this->lang->line('button_add_site'), ['class' => 'btn btn-success', 'href' => $this->pageUrl('settings#system')]);
        }

        $button_type = ($item_type == 'extensions') ? 'themes' : 'extensions';
        $button_title = ($button_type == 'extensions') ? $this->lang->line('text_tab_title_extensions') : $this->lang->line('text_tab_title_themes');
        $this->template->setButton(sprintf($this->lang->line('button_browse'), $button_title), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->browse_url, ['item' => $button_type])]);
        $this->template->setButton($this->lang->line('button_updates'), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->check_url)]);

        $this->assets->setStyleTag(assets_url('css/app/marketplace.css'), 'marketplace-css');
        $this->assets->setScriptTag(assets_url('js/mustache.js'), 'mustache-js', '20');
        $this->assets->setScriptTag(assets_url('js/typeahead.js'), 'typeahead-js', '21');
        $this->assets->setScriptTag(assets_url('js/app/updates.js'), 'updates-js', '22');

        $data['installed_items'] = $this->updates_manager->getInstalledItems();

        $data['item_type'] = singular($item_type);

        $data['items'] = $this->updates_manager->getPopularItems(singular($item_type));

        $this->template->render('updates_browse', $data);
    }

    public function search()
    {
        $json = [];

        if ($filter = $this->input->post_get('filter') AND is_array($filter)) {

            $itemType = isset($filter['type']) ? $filter['type'] : 'extension';
            $searchQuery = isset($filter['search']) ? strtolower($filter['search']) : '';
            $json['response'] = $this->updates_manager->searchItems($itemType, $searchQuery);
        }

        $this->setOutput($json);
    }

    public function apply()
    {
        $error = null;

        $code = $this->input->post_get('code');
        if (empty($code) OR !is_array($code))
            $error = TRUE;

        $json['response'] = $this->lang->line('alert_error_try_again');

        if (!$error) {
            $params = [];
            foreach ($code as $item)
                $params[$item['code']] = $item;

            try {
                $response = $this->updates_manager->applyInstallOrUpdate($params);

                if (is_array($response) AND count(array_collapse($response)) > 0)
                    $json['response'] = ['steps' => $this->buildProcessSteps($response, $params)];
            } catch (Exception $ex) {
                $json['response'] = $ex->getMessage();
            }
        }

        $this->setOutput($json);
    }

    public function process()
    {
        $json = [];
        if (($error = $this->_validateProcess()) === TRUE) {

            try {
                $post = $this->input->post();
                $stepProcess = $this->input->post('process');

                $params = !isset($post['code']) ? [] : [
                    $post['code'] => [
                        'code'   => $post['code'],
                        'type'   => $post['type'],
                        'ver'    => $post['version'],
                        'action' => $post['action'],
                    ],
                ];

                switch ($stepProcess) {
                    case 'downloadCore':
                        $response = $this->updates_manager->downloadCore($post['code'], $post['hash'], $params);
                        if ($response) $json['response'][] = 'downloaded';
                        break;

                    case 'downloadExtension':
                    case 'downloadTheme':
                    case 'downloadTranslation':
                        $response = $this->updates_manager->downloadFile($post['code'], $post['hash'], $params);
                        if ($response) $json['response'][] = 'downloaded';
                        break;

                    case 'extractCore':
                        $response = $this->updates_manager->extractCore($post['code']);
                        if ($response) $json['redirect'] = root_url('setup');
                        break;

                    case 'extractExtension':
                    case 'extractTheme':
                    case 'extractTranslation':
                        $response = $this->updates_manager->extractFile($post['code'], $post['type']);
                        if ($response) $json['response'][] = 'extracted';
                        break;

                    case 'completeInstall':
                    case 'completeUpdate':
                        $response = $this->completeProcess($post);
                        if ($response) $json['response'][] = 'complete';
                        break;
                }
            } catch (Exception $e) {
                $json['response'] = $e->getMessage();
            }
        }

        $this->setOutput($json);
    }

    protected function buildProcessSteps($meta, $params = [])
    {
        $applySteps = [];

        $availableSteps = ['download', 'extract', 'complete'];
        if ($core = array_get($meta, 'core', [])) {
            foreach ($availableSteps as $step) {
                $applySteps[] = array_merge([
                    'action'  => 'update',
                    'process' => ($step == 'complete') ? $step."Update" : "{$step}Core",
                    'label'   => sprintf($this->lang->line("progress_{$step}"), "{$core['name']}".($step != 'complete' ? '' : ' update')),
                ], $core);
            }
        }

        $availableTypes = ['extensions', 'themes', 'translations'];
        foreach ($availableTypes as $type) {
            $typeSingular = singular($type);
            if (isset($meta[$type])) {
                foreach ($meta[$type] as $item) {
                    $action = $params[$item['code']]['action'];
                    foreach ($availableSteps as $step) {
                        $applySteps[] = array_merge([
                            'action'  => $action,
                            'process' => camelize(($step == 'complete') ? $step.' '.$action : underscore("{$step} {$typeSingular}")),
                            'label'   => sprintf($this->lang->line("progress_{$step}"), "{$item['name']} {$type}".($step != 'complete' ? '' : ' '.$action)),
                        ], $item);
                    }
                }
            }
        }

        return $applySteps;
    }

    protected function completeProcess($post)
    {
        if (isset($post['type'], $post['action']) AND $post['action'] == 'update') {
            switch ($post['type']) {
                case 'extension':
                    $this->updates_manager->updateExtension($post['code']);
                    break;
                case 'theme':
                    $this->updates_manager->updateTheme($post['code']);
                    break;
                case 'translation':
                    $this->updates_manager->updateTranslation($post['code']);
                    break;
            }
        }

        $this->alert->set('success', 'Operation successful');

        return TRUE;
    }

    protected function setOutput($json)
    {
        $error = null;
        if (isset($json['response']) AND is_string($json['response'])) {
            $error = $json['response'];
            unset($json['response']);
        }

        if (is_string($error)) {
            $this->output->set_status_header(400);
            $json = $error;
        }

        $this->output->set_output(json_encode($json));
    }

    protected function _validateProcess()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('items[]', 'lang:label_extensions', 'xss_clean|trim');
            $this->form_validation->set_rules('item', 'lang:label_extensions', 'xss_clean|trim');

            if (in_array($this->input->post('step'), ['download', 'extract', 'install'])) {
                $this->form_validation->set_rules('hash', 'lang:label_meta_data', 'xss_clean|trim|required');
                $this->form_validation->set_rules('type', 'lang:label_meta_data', 'xss_clean|trim|required');
                $this->form_validation->set_rules('code', 'lang:label_meta_data', 'xss_clean|trim|required');
                $this->form_validation->set_rules('version', 'lang:label_meta_data', 'xss_clean|trim|required');
                $this->form_validation->set_rules('description', 'lang:label_meta_data', 'xss_clean|trim|required');
            }

            if ($this->form_validation->run() === TRUE) {
                return TRUE;
            }

            return $this->form_validation->error_string();
        }

        return FALSE;
    }
}

/* End of file Updates.php */
/* Location: ./admin/controllers/Updates.php */