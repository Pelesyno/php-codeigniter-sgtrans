<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Departamento extends CI_Controller
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
		if ($this->session->userdata('FUN_Id') != 1) {
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}
	}

	function add()
	{
		$data['title'] = "Cadastro de Departamento - SG Transportes";
		$data['headline'] = "Cadastro de Departamento";
		$data['include'] = "departamento_add";
		$EMP_Id = "1";
		$this->load->model('MEmpresa', '', true);
		$data['empresa'] = $this->MEmpresa->getEmpresa($EMP_Id);
		$this->load->view('template', $data);
	}

	function create()
	{
		$this->load->model('MDepartamento', '', true);
		$this->MDepartamento->addDepartamento($_POST);
		$this->session->set_flashdata('sucesso', 'Departamento Adicionado.');
		redirect('departamento/listing', 'refresh');
	}

	function edit()
	{
		$DEP_Id = $this->uri->segment(3);
		$this->load->model('MDepartamento', '', true);
		$data['departamento'] = $this->MDepartamento->getDepartamento($DEP_Id)->result();
		$data['title'] = "Modificar Departamento - SG Transportes";
		$data['headline'] = "Edição de Departamento";
		$data['include'] = "departamento_edit";
		$this->load->view('template', $data);
	}


	function listing()
	{
		$this->load->model('MDepartamento', '', true);
		$qry = $this->MDepartamento->listDepartamento();
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Departamento', 'Editar', 'Excluir');
		$table_row = array();

		foreach ($qry->result() as $departamento) {
				$table_row = null;
				$table_row[] = $departamento->DEP_Nome;
				$table_row[] =  anchor('departamento/edit/' . $departamento->DEP_Id, '<i class="fas fa-pencil-alt"></i>');
				$table_row[] =  anchor(
					'departamento/delete/' . $departamento->DEP_Id,
					'<i class="fas fa-trash-alt"></i>',
					"onClick=\" return confirm('Tem certeza que deseja remover o registro?')\""
				);
				$this->table->add_row($table_row);
			}
		$table = $this->table->generate();

		$data['title'] = "Listar Departamentos - SG Transportes";
		$data['headline'] = "Listar Departamentos";
		$data['include'] = "departamento_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function update()
	{
		$this->load->model('MDepartamento', '', true);
		$this->MDepartamento->updateDepartamento($_POST['DEP_Id'], $_POST);
		$this->session->set_flashdata('sucesso', 'Departamento Atualizado.');
		redirect('departamento/listing');
	}

	function delete()
	{
		$DEP_Id = $this->uri->segment(3);
		$this->load->model('MDepartamento', '', true);
		$this->MDepartamento->deleteDepartamento($DEP_Id);
		$this->session->set_flashdata('sucesso', 'Departamento Deletado.');
		redirect('departamento/listing', 'refresh');
	}
}

/* End of file departamento.php */


