<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modelo extends CI_Controller
{
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
		if ($this->session->userdata('FUN_Id') != 2) {
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}
	}

	function add()
	{
		$data['title'] = "Cadastro de Modelo - SG Transportes";
		$data['headline'] = "Cadastro de Modelo";
		$data['include'] = "modelo_add_edit";
		$this->load->Model('MMarca');
		$data['marcas'] = $this->MMarca->listMarcas();
		$this->load->view('template', $data);
	}

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		if (isset($_POST['MOD_Id'])) {
			$this->form_validation->set_rules('MOD_Id', 'ID', 'required');
			$this->form_validation->set_rules('MOD_Nome', 'Nome do Modelo', 'trim|required|edit_unique[modeloveiculo.MOD_Nome.' . $_POST['MOD_Id'] . ']');
			$this->form_validation->set_rules('MAR_Id', 'Marca', 'trim|required');
		} else {
			$this->form_validation->set_rules('MOD_Nome', 'Nome do Modelo', 'trim|required|is_unique[modeloveiculo.MOD_Nome]');
			$this->form_validation->set_rules('MAR_Id', 'Marca', 'trim|required');
		}
		return $this->form_validation->run();
	}

	function create()
	{
		if ($this->validation()) {
			$this->load->model('MModelo');
			if ($this->MModelo->addModelo($_POST)) {
				$this->session->set_flashdata('sucesso', 'Modelo Cadastrado.');
				redirect('modelo/listing');
			} else {
				$this->session->set_flashdata('erro', 'Modelo não cadastrado.');
				$this->add();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->add();
		}
	}

	function edit()
	{
		$MOD_Id = $this->uri->segment(3);
		$this->load->model('MModelo');
		$data['modelo'] = $this->MModelo->getModelo($MOD_Id)->result();
		$data['title'] = "Modificar Modelo - SG Transportes";
		$data['headline'] = "Edição de Modelo";
		$data['include'] = "modelo_add_edit";
		$data['update'] = true;
		$this->load->Model('MMarca');
		$data['marcas'] = $this->MMarca->listMarcas();
		$this->load->view('template', $data);
	}

	function update()
	{
		if ($this->validation()) {
			$this->load->model('MModelo');
			if ($this->MModelo->updateModelo($_POST['MOD_Id'], $_POST)) {
				$this->session->set_flashdata('sucesso', 'Modelo Atualizado.');
				redirect('modelo/listing');
			} else {
				$this->session->set_flashdata('erro', 'Modelo não Atualizado.');
				$this->edit();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->edit();
		}
	}

	function listing()
	{
		$this->load->model('MModelo');
		$this->load->model('MVeiculo');
		$qry = $this->MModelo->listModelos();
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Codigo', 'Marca', 'Modelo', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $modelo) {
			$table_row = null;
			$table_row[] = $modelo->MOD_Id;
			$table_row[] = $modelo->MAR_Nome;
			$table_row[] = $modelo->MOD_Nome;
			if ($this->MVeiculo->verificarModelo($modelo->MOD_Id)) {
				$table_row[] = (anchor('modelo/edit/' . $modelo->MOD_Id, '<i class="fas fa-pencil-alt"></i>')) . '&nbsp;&nbsp;|&nbsp;&nbsp; <i class="text-danger fas fa-minus-circle"></i>';
			} else {
				$table_row[] =  anchor('modelo/edit/' . $modelo->MOD_Id, '<i class="fas fa-pencil-alt"></i>') . "&nbsp;&nbsp;|&nbsp;&nbsp;" .  anchor(
					'marca/delete',
					'<i class="fas fa-trash-alt"></i>',
					'data-toggle="modal" data-target="#modalexcluir" data-transfer="' . $modelo->MOD_Nome . '" data-id="' . $modelo->MOD_Id . '"'
				);
			}
			
			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();

		$data['title'] = "Listar Modelos - SG Transportes";
		$data['headline'] = "Listar Modelos";
		$data['include'] = "modelo_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
    {
        $MOD_Id = $this->uri->segment(3);
        $this->load->model('MVeiculo');
        if ($this->MVeiculo->verificarModelo($MOD_Id)) {
            $this->session->set_flashdata('erro', 'Não foi possivel Excluir Veiculo Vinculado.');
            $this->listing();
        } else {
            $this->load->model('mmodelo');
            if ($this->mmodelo->deleteModelo($MOD_Id)) {
                $this->session->set_flashdata('sucesso', 'Modelo Deletado com Sucesso.');
                redirect('modelo/listing', 'refresh');
            }
        }
    }
}
