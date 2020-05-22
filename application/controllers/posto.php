<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Posto extends CI_Controller
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

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		if (isset($_POST['POS_Id'])) {
			$this->form_validation->set_rules('POS_Id', 'ID', 'required');
			$this->form_validation->set_rules('POS_Cnpj', 'CNPJ', 'trim|edit_unique[posto.POS_Cnpj.' . $_POST['POS_Id'] . ']|required');
		} else {
			$this->form_validation->set_rules('POS_Cnpj', 'CNPJ', 'trim|is_unique[posto.POS_Cnpj]|required');
		}

		$this->form_validation->set_rules('POS_RazaoSocial', 'Razão Social', 'required');
		$this->form_validation->set_rules('POS_NomeFantasia', 'Nome Fantasia', 'required');
		$this->form_validation->set_rules('POS_Telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('POS_Endereco', 'Endereço', 'required');

		return $this->form_validation->run();
	}

	function add()
	{
		$data['title'] = "Cadastro de Posto - SG Transportes";
		$data['headline'] = "Cadastro de Posto";
		$data['include'] = "posto_add_edit";
		$this->load->view('template', $data);
	}

	function create()
	{
		//Remover caracteres do CNPJ antes de salvar no banco
		$chars = array(".", "/", "-");
		$_POST['POS_Cnpj'] = str_replace($chars, "", $_POST['POS_Cnpj']);
		$chars = array("(", ")", "-");
		$_POST['POS_Telefone'] = str_replace($chars, "", $_POST['POS_Telefone']);
		if ($this->validation()) {
			$this->load->model('MPosto', '', true);

			if ($this->MPosto->addPosto($_POST)) {
				$this->session->set_flashdata('sucesso', 'Posto Adicionado.');
				redirect('posto/listing', 'refresh');
			} else {
				$this->session->set_flashdata('erro', 'Posto não adicionado.');
				$this->add();
			}
		} else {
			$this->add();
		}
	}

	function edit()
	{
		$POS_Id = $this->uri->segment(3);
		$this->load->model('MPosto', '', true);
		$data['posto'] = $this->MPosto->getPosto($POS_Id)->result();
		$data['title'] = "Modificar Posto - SG Transportes";
		$data['headline'] = "Edição de Posto";
		$data['include'] = "posto_add_edit";
		$data['update'] = true;
		$this->load->view('template', $data);
	}

	function update()
	{
		//Remover caracteres do CNPJ antes de salvar no banco
		$chars = array(".", "/", "-");
		$_POST['POS_Cnpj'] = str_replace($chars, "", $_POST['POS_Cnpj']);
		$chars = array("(", ")", "-");
		$_POST['POS_Telefone'] = str_replace($chars, "", $_POST['POS_Telefone']);

		if ($this->validation()) {
			$this->load->model('MPosto', '', true);
			if ($this->MPosto->updatePosto($_POST['POS_Id'], $_POST)) {
				$this->session->set_flashdata('sucesso', 'Posto Atualizado.');
				redirect('posto/listing');
			} else {
				$this->session->set_flashdata('erro', 'Posto não atualizada.');
				$this->edit();
			}
		} else {
			$this->edit();
		}
	}


	function listing()
	{
		$this->load->model('MPosto', '', true);
		$qry = $this->MPosto->listPosto();
		$this->load->model('mabastecer');
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Código', 'CNPJ', 'Razão Social', 'Nome Fantasia', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $posto) {
			$table_row = null;
			$table_row[] = $posto->POS_Id;
			$table_row[] = $posto->POS_Cnpj;
			$table_row[] = $posto->POS_RazaoSocial;
			$table_row[] = $posto->POS_NomeFantasia;
			if($this->mabastecer->verificarAbastecimentos($posto->POS_Id))
				{
					$table_row[] =  anchor('posto/edit/' . $posto->POS_Id, '<i class="fas fa-pencil-alt"></i>') .'&nbsp;&nbsp;|&nbsp;&nbsp;<i class="text-danger fas fa-minus-circle"></i>';			
				}else{
					$table_row[] =  anchor('posto/edit/' . $posto->POS_Id, '<i class="fas fa-pencil-alt"></i>') . "&nbsp;&nbsp;|&nbsp;&nbsp;" .  anchor(
						'posto/delete',
						'<i class="fas fa-trash-alt"></i>',
						'data-toggle="modal" data-target="#modalexcluir" data-transfer="' . $posto->POS_RazaoSocial . '" data-id="' . $posto->POS_Id . '"'
					);
				}
			
			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();

		$data['title'] = "Listar Postos - SG Transportes";
		$data['headline'] = "Listar Postos";
		$data['include'] = "posto_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$POS_Id = $this->uri->segment(3);

		$this->load->model('MPosto', '', true);

		$result = $this->MPosto->deletePosto($POS_Id);

		$this->session->set_flashdata('sucesso', 'Posto Deletado.');
		redirect('posto/listing', 'refresh');
	}
}

/* End of file oficina.php */
