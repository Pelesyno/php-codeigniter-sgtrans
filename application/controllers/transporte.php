<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transporte extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
	}

	private function check_isvalidated()
	{
		if (!$this->session->userdata('validated')) {
			redirect('login');
		}
	}

	public function sair()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	public function index()
	{

		$this->load->model('mveiculo');
		$this->load->model('mmotorista');
		$this->load->model('mposto');
		$this->load->model('mocorrencia');
		$this->load->model('mnotificacao');
		$data['title'] = "Página Inicial - SG Transportes";
		$data['headline'] = "Gerenciamento de Transportes";
		$data['include'] = "transporte_index";
		$data['veiculos'] = $this->mveiculo->listVeiculo();
		$data['motoristas'] = $this->mmotorista->listMotorista();
		$data['postos'] = $this->mposto->listPosto();
		$data['ocorrencias'] = $this->mocorrencia->listOcorrencias();
		$data['habilitacao'] = $this->mmotorista->vencendoMotorista();
		$data['ipva'] = $this->mnotificacao->listIPVA();
		$this->load->view('template', $data);
	}
}

/* End of file transporte.php */


