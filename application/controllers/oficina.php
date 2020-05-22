<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Oficina extends CI_Controller
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
		if (isset($_POST['OFI_Id'])) {
			$this->form_validation->set_rules('OFI_Id', 'ID', 'required');
			$this->form_validation->set_rules('OFI_Cnpj', 'CNPJ', 'trim|edit_unique[oficina.OFI_Cnpj.' . $_POST['OFI_Id'] . ']|required');
		} else {
			$this->form_validation->set_rules('OFI_Cnpj', 'CNPJ', 'trim|is_unique[oficina.OFI_Cnpj]|required');
		}

		$this->form_validation->set_rules('OFI_RazaoSocial', 'Razão Social', 'required');
		$this->form_validation->set_rules('OFI_Fantasia', 'Fantasia', 'required');
		$this->form_validation->set_rules('OFI_Telefone', 'Telefone', 'required');
		$this->form_validation->set_rules('OFI_Endereco', 'Endereço', 'required');

		return $this->form_validation->run();
	}

	function add()
	{
		$data['title'] = "Cadastro de Oficina - SG Transportes";
		$data['headline'] = "Cadastro de Oficina";
		$data['include'] = "oficina_add_edit";
		$this->load->view('template', $data);
	}

	function create()
	{
		//Remover caracteres do CNPJ antes de salvar no banco
		$chars = array(".", "/", "-");
		$_POST['OFI_Cnpj'] = str_replace($chars, "", $_POST['OFI_Cnpj']);
		$chars = array("(", ")", "-");
		$_POST['OFI_Telefone'] = str_replace($chars, "", $_POST['OFI_Telefone']);
		if ($this->validation()) {
			$this->load->model('MOficina', '', true);

			if ($this->MOficina->addOficina($_POST)) {
				$this->session->set_flashdata('sucesso', 'Oficina Adicionado.');
				redirect('oficina/listing', 'refresh');
			} else {
				$this->session->set_flashdata('erro', 'Oficina não adicionado.');
				$this->add();
			}
		} else {
			$this->add();
		}
	}

	function edit()
	{
		$OFI_Id = $this->uri->segment(3);
		$this->load->model('MOficina', '', true);
		$data['oficina'] = $this->MOficina->getOficina($OFI_Id)->result();
		$data['title'] = "Modificar Oficina - SG Transportes";
		$data['headline'] = "Edição de Oficina";
		$data['include'] = "oficina_add_edit";
		$data['update'] = true;
		$this->load->view('template', $data);
	}

	function update()
	{
		//Remover caracteres do CNPJ antes de salvar no banco
		$chars = array(".", "/", "-");
		$_POST['OFI_Cnpj'] = str_replace($chars, "", $_POST['OFI_Cnpj']);
		$chars = array("(", ")", "-");
		$_POST['OFI_Telefone'] = str_replace($chars, "", $_POST['OFI_Telefone']);
		if ($this->validation()) {
			$this->load->model('MOficina', '', true);
			if ($this->MOficina->updateOficina($_POST['OFI_Id'], $_POST)) {
				$this->session->set_flashdata('sucesso', 'Oficina Atualizada.');
				redirect('oficina/listing');
			} else {
				$this->session->set_flashdata('erro', 'Oficina não atualizada.');
				$this->edit();
			}
		} else {
			$this->edit();
		}
	}


	function listing()
	{
		$this->load->model('MOficina', '', true);
		$qry = $this->MOficina->listOficina();

		$this->load->model('mmanutencao');

		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Oficina', 'Ações');
		$table_row = array();
		foreach ($qry->result() as $oficina) {
				$table_row = null;
			
				$table_row[] = $oficina->OFI_RazaoSocial;
				if($this->mmanutencao->verificarOficinas($oficina->OFI_Id))
				{
					$table_row[] =  anchor('oficina/edit/' . $oficina->OFI_Id, '<i class="fas fa-pencil-alt"></i>') .'&nbsp;&nbsp;|&nbsp;&nbsp;<i class="text-danger fas fa-minus-circle"></i>';			
				}else{
					$table_row[] =  anchor('oficina/edit/' . $oficina->OFI_Id, '<i class="fas fa-pencil-alt"></i>') . '&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;' . anchor(
						'oficina/delete',
						'<i class="fas fa-trash-alt"></i>',
						'data-toggle="modal" data-target="#modalexcluir" data-transfer="' . $oficina->OFI_RazaoSocial . '" data-id="' . $oficina->OFI_Id . '"'
					);
				}
				
				$this->table->add_row($table_row);
			}
		$table = $this->table->generate();

		$data['title'] = "Listar Oficinas - SG Transportes";
		$data['headline'] = "Listar Oficinas";
		$data['include'] = "oficina_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}


	function delete()
	{
		$OFI_Id = $this->uri->segment(3);
		$this->load->model('MOficina', '', true);
		$this->MOficina->deleteOficina($OFI_Id);
		$this->session->set_flashdata('sucesso', 'Oficina Deletada.');
		redirect('oficina/listing', 'refresh');
	}
}

/* End of file oficina.php */


