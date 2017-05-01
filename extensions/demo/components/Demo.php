<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Demo extends BaseComponent
{

    public function index()
    {
        $this->lang->load('demo/demo');

        $data['code'] = $this->setting('code');
        $data['title'] = $this->setting('title', $data['code']);

        return $this->load->view('demo/demo', $data, TRUE);
    }
}

/* End of file Demo.php */
/* Location: ./extensions/demo/components/Demo.php */