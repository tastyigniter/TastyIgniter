<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Maintenance extends Admin_Controller {

    public function __construct() {
        parent::__construct(); //  calls the constructor

        $this->load->model('Maintenance_model');

        $this->lang->load('maintenance');
    }

    public function index() {
        $this->load->helper('number');
        $this->user->restrict('Admin.Maintenance.Access');

        if ($this->input->post('migrate') AND $this->_migrate() === TRUE) {
            redirect('maintenance');
        }

        if ($this->Maintenance_model->checkTables($this->input->post('tables'))) {
            $this->session->set_flashdata('tables', $this->input->post('tables'));
            redirect('maintenance/backup');
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

        $this->template->setButton($this->lang->line('button_backup'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#tables-form\').submit();'));
        $this->template->setButton($this->lang->line('button_migrate'), array('class' => 'btn btn-success', 'onclick' => '$(\'#migrate-form\').submit();'));

        $data['backup_tables'] = FALSE;
        $data['db_tables'] = array();
        $db_tables = $this->Maintenance_model->getdbTables();
        foreach ($db_tables as $db_table) {
            $data['db_tables'][] = array(
                'name'         => $db_table['table_name'],
                'records'      => $db_table['table_rows'],
                'data_length'  => byte_format($db_table['data_length']),
                'index_length' => byte_format($db_table['index_length']),
                'data_free'    => byte_format($db_table['data_free']),
                'engine'       => $db_table['engine'],
                'browse'       => site_url('maintenance/browse_table/' . $db_table['table_name'])
            );
        }

        $data['backup_files'] = array();
        $backup_files = glob(ROOTPATH . 'assets/downloads/*.sql');
        if (count($backup_files) > 0) {
            foreach ($backup_files as $backup_file) {
                $basename = basename($backup_file);
                $data['backup_files'][] = array(
                    'filename' => $basename,
                    'size'     => filesize($backup_file),
                    'download' => site_url('maintenance/backup?download=' . $basename),
                    'restore'  => site_url('maintenance/backup?restore=' . $basename),
                    'delete'   => site_url('maintenance/backup?delete=' . $basename)
                );
            }
        }

        $this->load->library('migration');
        $data['installed_version'] = $this->migration->get_version();
        $data['latest_version'] = $this->migration->get_latest_version();

        $data['migration_files'] = array();
        if ($migration_files = $this->migration->find_migrations()) {
            foreach ($migration_files as $version => $migration_file) {
                $migration_file = basename($migration_file);
                $version = $this->migration->get_migration_number(basename($migration_file));
                $data['migration_files'][$version] = $migration_file;
            }
        }

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('maintenance', $data);
    }

    public function backup() {
        $this->user->restrict('Admin.Maintenance.Manage');

        if ($this->input->get('restore') AND $this->_restore() === TRUE) {
            redirect('maintenance');
        } else if ($this->input->get('download') AND $this->_download() === TRUE) {
            redirect('maintenance');
        } else if ($this->input->get('delete') AND $this->_delete() === TRUE) {
            redirect('maintenance');
        }

        $checked_tables = ($this->session->flashdata('tables')) ? $this->session->flashdata('tables') : $this->input->post('tables');
        if ( ! $this->Maintenance_model->checkTables($checked_tables)) {
            redirect('maintenance');
        } else if ($this->input->post('tables') AND $this->input->post('compression') AND $this->_backup() === TRUE) {
            redirect('maintenance');
        }

        $data['backup_tables'] = TRUE;

        $timestamp = mdate('%Y-%m-%d-%H-%i-%s', now());

        $this->template->setTitle($this->lang->line('text_backup_heading'));
        $this->template->setHeading($this->lang->line('text_backup_heading'));

        $this->template->setButton($this->lang->line('button_backup'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_migrate'), array('class' => 'btn btn-success', 'onclick' => '$(\'#migrate-form\').submit();'));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('maintenance')));

        if ($this->input->post('file_name')) {
            $data['file_name'] = $this->input->post('file_name');
        } else {
            $data['file_name'] = 'tastyigniter-' . $timestamp;
        }

        if ($this->input->post('drop_tables')) {
            $data['drop_tables'] = $this->input->post('drop_tables');
        } else {
            $data['drop_tables'] = '0';
        }

        if ($this->input->post('add_inserts')) {
            $data['add_inserts'] = $this->input->post('add_inserts');
        } else {
            $data['add_inserts'] = '1';
        }

        if ($this->input->post('compression')) {
            $data['compression'] = $this->input->post('compression');
        } else {
            $data['compression'] = 'none';
        }

        if ($this->session->flashdata('tables')) {
            $data['tables'] = $this->session->flashdata('tables');
        } else if ($this->input->post('tables')) {
            $data['tables'] = $this->input->post('tables');
        } else {
            $data['tables'] = array();
        }

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('maintenance', $data);
    }

    public function browse_table() {
        $this->user->restrict('Admin.Maintenance.Access');
        $this->user->restrict('Admin.Maintenance.Manage');

        $filter = array();
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        }

        if ($this->uri->rsegment(3)) {
            $filter['table'] = $this->uri->rsegment(3);
        } else {
            $filter['table'] = '';
        }

        $table_info = $this->Maintenance_model->browseTable($filter);

        $this->template->setTitle(sprintf($this->lang->line('text_browse_heading'), $filter['table']));
        $this->template->setHeading(sprintf($this->lang->line('text_browse_heading'), $filter['table']));
        $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('maintenance')));

        $data['sql_query'] = 'SELECT * FROM (' . $filter['table'] . ')';

        if ( ! empty($table_info['query'])) {
            $this->load->library('table');
            $template = array('table_open' => '<table class="table table-striped table-border">');
            $this->table->set_template($template);
            $data['query_table'] = $this->table->generate($table_info['query']);
        } else {
            $data['query_table'] = '';
        }

        $config['base_url'] = site_url('maintenance/browse_table/' . $filter['table']);
        $config['total_rows'] = ! empty($table_info['total_rows']) ? $table_info['total_rows'] : '0';
        $config['per_page'] = $filter['limit'];

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['pagination'] = array(
            'info'  => $this->pagination->create_infos(),
            'links' => $this->pagination->create_links()
        );

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('maintenance_browse', $data);

    }

    private function _backup() {
        if ($this->input->post('tables') AND $this->validateForm() === TRUE) {

            if ($this->Maintenance_model->backupDatabase($this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database backed up '));
            }

            return TRUE;
        }
    }

    private function _restore() {
        $this->user->restrict('Admin.Maintenance.Add');

        if ($this->input->get('restore')) {
            $restore = pathinfo($this->security->sanitize_filename($this->input->get('restore')));
            $restore_path = ROOTPATH . "assets/downloads/" . $restore['filename'] . ".sql";

            if ($restore['extension'] === 'sql' AND is_file($restore_path)) {
                if ($this->Maintenance_model->restoreDatabase($restore_path)) { // calls model to save data to SQL
                    $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database restored '));
                }
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'restored'));
            }

            return TRUE;
        }
    }

    private function _download() {
        $this->user->restrict('Admin.Maintenance.Manage');

        if ($this->input->get('download')) {
            $download = pathinfo($this->security->sanitize_filename($this->input->get('download')));
            $file_path = ROOTPATH . "assets/downloads/" . $download['filename'] . ".sql";

            if ($download['extension'] === 'sql' AND is_file($file_path)) {
                $file_data = file_get_contents($file_path);
                $this->load->helper('download');
                force_download($download['basename'], $file_data);
            }

        }
    }

    private function _delete() {
        $this->user->restrict('Admin.Maintenance.Delete');

        if ($this->input->get('delete')) {
            $delete = pathinfo($this->security->sanitize_filename($this->input->get('delete')));
            $file_path = ROOTPATH . "assets/downloads/" . $delete['filename'] . ".sql";

            if ($delete['extension'] === 'sql' AND is_file($file_path)) {
                unlink($file_path);
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database backup deleted '));
            }

            return TRUE;
        }
    }

    private function _migrate() {
        $this->user->restrict('Admin.Maintenance.Manage');

        if ($this->input->post('migrate') AND is_numeric($this->input->post('migrate'))) {
            $this->load->library('migration');
            $migrate = (int) $this->migration->get_migration_number($this->input->post('migrate'));

            if ($this->migration->version($migrate)) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database migrated '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error'), $this->migration->error_string()));
            }
        }

        return TRUE;
    }

    private function validateForm() {
        $this->form_validation->set_rules('file_name', 'lang:label_file_name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('drop_tables', 'lang:label_drop_tables', 'xss_clean|trim|required|alpha_dash');
        $this->form_validation->set_rules('add_inserts', 'lang:label_add_inserts', 'xss_clean|trim|required|alpha_dash');
        $this->form_validation->set_rules('compression', 'lang:label_compression', 'xss_clean|trim|required|alpha_dash');
        $this->form_validation->set_rules('tables[]', 'lang:label_backup_table', 'xss_clean|trim|required|alpha_dash');

        if ( ! empty($_POST['file_name'])) {
            $_POST['file_name'] = html_entity_decode($_POST['file_name'], ENT_QUOTES, 'UTF-8');
            $_POST['file_name'] = str_replace(array('"', "'", "/", "\\"), "", $_POST['file_name']);
            $filename = $this->security->sanitize_filename($_POST['file_name']);
            $_POST['file_name'] = basename($filename);
        }

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* End of file maintenance.php */
/* Location: ./admin/controllers/maintenance.php */