<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index($msg = null)
    {
        $data['title'] = "Login - SG-Transportes";
        $data['headline'] = "Sistema de Gerenciamento de Transportes";
        $data['msg'] = $msg;
        $data['include'] = "login_view";
        $this->load->view('template2', $data);
    }

    public function process()
    {
        $this->load->model('MLogin');
        $result = $this->MLogin->validate();
        if (!$result) {
            $msg = 1;
            $this->index($msg);
        } else {
            redirect('transporte/index');
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
