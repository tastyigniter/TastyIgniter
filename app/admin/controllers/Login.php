<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Login extends Admin_Controller
{

    protected $requireAuthentication = FALSE;

    public function index()
    {
        $this->lang->load('login');
        $this->load->model('Users_model');

        if ($this->user->islogged()) {
            $this->redirect('dashboard');
        }

        $this->template->setTitle($this->lang->line('text_title'));

        $data['site_name'] = $this->config->item('site_name');
        $data['reset_url'] = $this->pageUrl('login/reset');

        if ($this->input->post() AND $this->validateLoginForm() === TRUE) {
            $remember = (bool)$this->input->post('remember');
            $credentials = [
                'username' => $this->input->post('user'),
                'password' => $this->input->post('password'),
            ];

            if (!$this->user->validate($credentials, $remember, TRUE)) {
                $this->alert->set('danger', $this->lang->line('alert_username_not_found'));
                $this->redirect(current_url());
            } else {
                log_activity($this->user->getStaffId(), 'logged in', 'staffs', get_activity_message('activity_logged_in',
                    ['{staff}', '{link}'],
                    [$this->user->getStaffName(), admin_url('staffs/edit?id='.$this->user->getStaffId())]
                ));

                if (!$this->config->item('address_1', 'main_address')) {
                    $this->redirect('settings');
                }

                if ($redirect_url = $this->input->get('redirect')) {
                    $this->redirect($redirect_url);
                }

                $this->redirect('dashboard');
            }
        }

        $this->template->render('login', $data);
    }

    public function reset()
    {
        $this->lang->load('login');

        $this->load->model('Staffs_model');
        if ($this->user->islogged()) {
            $this->redirect('dashboard');
        }

        $this->template->setTitle($this->lang->line('text_password_reset_title'));

        $data['reset_code'] = $this->input->get_post('code');

        if ($this->input->post() AND $this->_resetPassword() === TRUE) {
            $this->redirect('login');
        }

        $data['login_url'] = $this->pageUrl();

        $this->template->render('login_reset', $data);
    }

    protected function _resetPassword()
    {
        if ($this->validateResetForm() === TRUE) {
            if (!$this->input->get_post('code')) {
                $username = $this->input->post('username');
                if ($this->user->resetPassword($username)) {
                    $this->alert->set('success', $this->lang->line('alert_email_sent'));

                    return TRUE;
                }

                $error = $this->lang->line('alert_email_not_sent');
            } else {
                $credentials = [
                    'reset_code' => $this->input->get_post('code'),
                    'password'   => $this->input->post('password'),
                ];

                if ($this->user->validateResetPassword($credentials)) {
                    $this->user->completeResetPassword($credentials);
                    $this->alert->set('success', $this->lang->line('alert_success_reset'));

                    return TRUE;
                }

                $error = $this->lang->line('alert_failed_reset');
            }

            $this->alert->set('danger', $error);
            $this->redirect(current_url());
        }
    }

    protected function validateLoginForm()
    {
        // START of form validation rules
        $this->form_validation->set_rules('user', 'lang:label_username', 'xss_clean|trim|required');
        $this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]');
        // END of form validation rules

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function validateResetForm()
    {
        if ($this->uri->segment(3)) {
            $this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'lang:label_password_confirm', 'xss_clean|trim|required');
        } else {
            $this->form_validation->set_rules('username', 'lang:label_username', 'xss_clean|trim|required|callback__check_user');
        }

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _check_user($str)
    {
        if (!$this->Users_model->validateUser($str)) {
            $this->form_validation->set_message('_check_user', $this->lang->line('error_no_user_found'));

            return FALSE;
        }

        return TRUE;
    }
}

/* End of file Login.php */
/* Location: ./admin/controllers/Login.php */