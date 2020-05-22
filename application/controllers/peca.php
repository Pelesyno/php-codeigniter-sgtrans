<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peca extends CI_Controller
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
		$data['title'] = "Registro de Peças - SG Transportes";
		$data['headline'] = "Registro de Peças";
		$data['include'] = "peca_add_edit";
		$this->load->view('template', $data);
	}

	function create()
	{
		if ($this->validation()) {
			$this->load->model('mpecas');
			if ($this->mpecas->addPeca($_POST)) {
				$this->session->set_flashdata('sucesso', 'A Peça foi Cadastrada.');
				redirect('peca/listing', 'refresh');
			} else {
				$this->session->set_flashdata('erro', 'A Peça não foi Cadastrada.');
				$this->add();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->add();
		}
	}

	function edit($id)
	{
		$this->load->model('mpecas');
		$data['peca'] = $this->mpecas->getPeca($id)->result();
		$data['update'] = true;
		$data['title'] = "Registro de Peças - SG Transportes";
		$data['headline'] = "Registro de Peça";
		$data['include'] = "peca_add_edit";
		$this->load->view('template', $data);
	}

	function update()
	{
		if ($this->validation()) {
			$this->load->model('mpecas');

			$peca = array(
				'PEC_Nome' => $_POST['PEC_Nome'],
				'PEC_Preco' => $_POST['PEC_Preco']
			);

			if ($this->mpecas->editPeca($_POST['PEC_Id'], $peca)) {
				$this->session->set_flashdata('sucesso', 'Peça Alterada.');
				redirect('peca/listing');
			} else {
				$this->session->set_flashdata('erro', 'Peça não Alterada.');
				$this->edit($_POST['PEC_Id']);
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->edit($_POST['PEC_Id']);
		}
	}

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		if (isset($_POST['PEC_Id'])) {
			$this->form_validation->set_rules('PEC_Nome', 'Descrição', 'required|edit_unique[pecas.PEC_Nome.' . $_POST['PEC_Id'] . ']');
		} else {
			$this->form_validation->set_rules('PEC_Nome', 'Descrição', 'required|is_unique[pecas.PEC_Nome]');
		}

		$this->form_validation->set_rules('PEC_Preco', 'Preco', 'required|numeric');

		return $this->form_validation->run();
	}

	function listing()
	{
		$data['title'] = "Registro de Peças - SG Transportes";
		$data['headline'] = "Registros de peças";
		$data['include'] = "peca_listing";
		$this->load->model('mpecasutilizadas');
		$this->load->model('mpecas');
		$qry = $this->mpecas->listPecas();
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-bordered table-hover table-sm text-center ">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('#', 'Descrição', 'Valor',  'Ações');
		$table_row = array();
		foreach ($qry->result() as $peca) {

			$table_row = null;
			$table_row[] = ($peca->PEC_Id);
			$table_row[] = ($peca->PEC_Nome);
			$table_row[] = ("R$ " . number_format($peca->PEC_Preco, 2, ',', '.'));

			if ($this->mpecasutilizadas->verificarPecasUtilizadas($peca->PEC_Id)) {
					$table_row[] =  (anchor('peca/edit/' . $peca->PEC_Id, '<i class="fas fa-pencil-alt"></i>') . '&nbsp;&nbsp;|&nbsp;&nbsp; <i class="text-danger fas fa-minus-circle"></i>');
				} else {
				$table_row[] = (anchor('peca/edit/' . $peca->PEC_Id, '<i class="fas fa-pencil-alt"></i>') .
					" &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;" .
					anchor(
						'peca/listing',
						'<i class="fas fa-trash-alt"></i>',
						"data-toggle='modal' data-target='#modalexcluir' title='Excluir' data-transfer=" . $peca->PEC_Nome . " data-id=" . $peca->PEC_Id
					));
			}

			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete($PEC_Id)
	{
		$this->load->model('mpecas');
		if ($this->mpecas->deletePeca($PEC_Id)) {
				$this->session->set_flashdata('sucesso', 'Peça Deletada.');
				redirect('peca/listing', 'refresh');
			} else {
			$this->session->set_flashdata('erro', 'Peça não Deletada.');
			redirect('peca/listing', 'refresh');
		}
	}

	function getPreco()
	{
		$PEC_Id = $this->input->post('PEC_Id');
		$this->load->model('mpecas');
		$peca = $this->mpecas->getPeca($PEC_Id)->result();

		echo "R$ " . number_format($peca[0]->PEC_Preco, 2, ',', '.');
	}
}
