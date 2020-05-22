<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Controller
{

	private $EMP_Id = 1;

	function __construct()
	{
		parent::__construct();
		$this->check_isvalidated();
		$this->check_permission();
	}

	private function check_isvalidated()
	{
		if (!$this->session->userdata('validated')) {
			redirect('login');
		}
	}

	private function check_permission()
	{
		if ($this->session->userdata('FUN_Id') != 1) {
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}
	}

	function view()
	{
		$this->load->model('MEmpresa', '', true);
		$data['empresa'] = $this->MEmpresa->getEmpresa($this->EMP_Id)->result();
		$data['title'] = "Visualizar Empresa - SG Transportes";
		$data['headline'] = "Visualizar Empresa";
		$data['include'] = "empresa_view";
		$this->load->view('template', $data);
	}

	function edit()
	{
		$this->load->model('MEmpresa', '', true);
		$data['empresa'] = $this->MEmpresa->getEmpresa($this->EMP_Id)->result();
		$data['title'] = "Editar Empresa - SG Transportes";
		$data['headline'] = "Edição de Empresa";
		$data['include'] = "empresa_edit";
		$this->load->view('template', $data);
	}

	function update()
	{
		if (isset($_FILES["EMP_Logo"]) && $_FILES["EMP_Logo"]['type'] == "image/png") {
			// Upload da Logo na pasta Assets/img - com o nome Logo
			$config["upload_path"] = FCPATH . "assets/img";
			$config["allowed_types"] = "png";
			$config['overwrite'] = true;
			$config['file_name'] = 'logo';
			$this->load->library("upload", $config);
			$this->upload->do_upload("EMP_Logo");
			//fim Upload
		}
		$this->load->model('MEmpresa', '', true);
		$this->MEmpresa->updateEmpresa($this->EMP_Id, $_POST);
		$this->session->set_flashdata('sucesso', 'Empresa Atualizada.');
		redirect('empresa/view', 'refresh');
	}
}

/* End of file usuario.php */
/* Location: ./application/controllers/usuario.php */
