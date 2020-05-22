<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico extends CI_Controller {

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

	public function validate_time($str){
		if (strrchr($str,":")) {
			list($hh, $mm, $ss) = explode(':', $str);
			if (!is_numeric($hh) || !is_numeric($mm) || !is_numeric($ss)){
				return FALSE;
			}elseif ((int) $hh > 24 || (int) $mm > 59 || (int) $ss > 59){
				return FALSE;
			}elseif (mktime((int) $hh, (int) $mm, (int) $ss) === FALSE){
				return FALSE;
			}
			return TRUE;
		}else{
			return FALSE;
		}   
	}

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		if (isset($_POST['SER_Id'])) {
			$this->form_validation->set_rules('SER_Id', 'ID', 'required');
			$this->form_validation->set_rules('SER_Nome', 'Descrição', 'trim|edit_unique[servicos.SER_Nome.' . $_POST['SER_Id'] . ']|required');
		} else {
			$this->form_validation->set_rules('SER_Nome', 'Descrição', 'trim|is_unique[servicos.SER_Nome]|required');
		}
		$this->form_validation->set_rules('SER_Preco', 'Preço', 'trim|required|numeric');
		$this->form_validation->set_rules('SER_TempoEstimado', 'Tempo Estimado', 'trim|required|callback_validate_time');
		return $this->form_validation->run();
	}


	function add()
	{
		$data['title'] = "Cadastro de Serviços - SG Transportes";
		$data['headline'] = "Cadastro de Serviços";
		$data['include'] = "servico_add_edit";
		$data['edit'] = FALSE;
		$this->load->view('template', $data);
	}

	function create()
	{
		if($this->validation())
		{
			$this->load->model('mservicos');
			if($this->mservicos->addServico($_POST))
			{
				$this->session->set_flashdata('sucesso', 'Serviço Adicionado.');
				redirect('servico/listing', 'refresh');
			}else{
				$this->session->set_flashdata('erro', 'Serviço não Adicionado.');
				$this->add();
			}
		}else{
			$this->session->set_flashdata('erro', 'Erro Validação.');
			$this->add();
		}
	}

	function edit($SER_Id)
	{
		$this->load->model('mservicos');
		$data['servico'] = $this->mservicos->getServico($SER_Id)->result();
		$data['title'] = "Modificar |Serviço - SG Transportes";
		$data['headline'] = "Edição de Serviço";
		$data['edit'] = 'enabled';
		$data['update'] = true;
		$data['include'] = "servico_add_edit";
		$this->load->view('template', $data);
	}

	function update()
	{
		if($this->validation())
		{
			$this->load->model('mservicos');
			if($this->mservicos->updateServico($_POST['SER_Id'], $_POST))
			{
				$this->session->set_flashdata('sucesso', 'Serviço Atualizado.');
				redirect('servico/listing');
			}else{
				$this->session->set_flashdata('erro', 'Serviço não Atualizado');
				$this->edit($_POST['SER_Id']);
			}
		}else{
			$this->session->set_flashdata('erro', 'Erro de Validação');
			$this->edit($_POST['SER_Id']);
		}
	}

	function listing()
	{
		$this->load->model('mservicos', '', true);
		$qry = $this->mservicos->listServicos();
		$this->load->model('mservicosutilizados');
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Serviço', 'Preço', 'Tempo', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $servico) {
				$table_row = null;
				$table_row[] = $servico->SER_Nome;
				$table_row[] = $servico->SER_Preco;
				$table_row[] = $servico->SER_TempoEstimado;
				if ($this->mservicosutilizados->verificarServicosUtilizados($servico->SER_Id)) {
					$table_row[] =  (anchor('servico/edit/' . $servico->SER_Id, '<i class="fas fa-pencil-alt"></i>') . '&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <i class="text-danger fas fa-minus-circle"></i>');
				} else {
				$table_row[] = (anchor('servico/edit/' . $servico->SER_Id, '<i class="fas fa-pencil-alt"></i>') .
					" &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;" .
					anchor(
						'servico/delete',
						'<i class="fas fa-trash-alt"></i>',
						"data-toggle='modal' data-target='#modalexcluir' title='Excluir' data-transfer='$servico->SER_Nome' data-id='$servico->SER_Id'"
					));
			}
				
				$this->table->add_row($table_row);
			}
		$table = $this->table->generate();

		$data['title'] = "Listar Serviços - SG Transportes";
		$data['headline'] = "Listar Serviços";
		$data['include'] = "servico_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$SER_Id = $this->uri->segment(3);
		$this->load->model('mservicos');
		if($this->mservicos->deleteServico($SER_Id))
		{
			$this->session->set_flashdata('sucesso', 'Serviço Deletado.');
		}else{
			$this->session->set_flashdata('erro', 'Problemas ao deletar o Serviço.');
		}
		redirect('servico/listing', 'refresh');
	}

	function getPreco()
	{
		$SER_Id = $this->input->post('SER_Id');
		$this->load->model('mservicos');
		$servico = $this->mservicos->getServico($SER_Id)->result();
		
		echo "R$ " . number_format($servico[0]->SER_Preco, 2, ',', '.');
	}

}

/* End of file servico.php */
/* Location: ./application/controllers/servico.php */