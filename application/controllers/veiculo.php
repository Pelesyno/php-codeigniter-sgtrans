<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Veiculo extends CI_Controller
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
		$data['title'] = "Cadastro de Veiculo - SG Transportes";
		$data['headline'] = "Cadastro de Veiculo";
		$data['include'] = "veiculo_add_edit";
		$this->load->model('MMarca');
		$data['marcas'] = $this->MMarca->listMarcas();
		$this->load->view('template', $data);
	}

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		if (isset($_POST['VEI_Id'])) {
			$this->form_validation->set_rules('VEI_Id', 'ID', 'required');
			$this->form_validation->set_rules('VEI_Placa', 'Placa', 'trim|edit_unique[veiculo.VEI_Placa.' . $_POST['VEI_Id'] . ']|required');
			$this->form_validation->set_rules('VEI_Renavam', 'RENAVAM', 'trim|edit_unique[veiculo.VEI_Renavam.' . $_POST['VEI_Id'] . ']|required|max_length[11]');
		} else {
			$this->form_validation->set_rules('VEI_Placa', 'Placa', 'trim|is_unique[veiculo.VEI_Placa]|required');
			$this->form_validation->set_rules('VEI_Renavam', 'RENAVAM', 'trim|is_unique[veiculo.VEI_Renavam]|required|max_length[11]');
		}
		$this->form_validation->set_rules('VEI_TipoPlaca', 'Tipo da Placa', 'required');
		$this->form_validation->set_rules('VEI_Tipo', 'Tipo', 'required');
		$this->form_validation->set_rules('VEI_Marca', 'Marca', 'required');
		$this->form_validation->set_rules('VEI_Modelo', 'Modelo', 'required');
		$this->form_validation->set_rules('VEI_AnoFabricacao', 'Ano de Fabricacao', 'required|numeric');
		$this->form_validation->set_rules('VEI_Combustivel', 'Combustivel', 'required');
		$this->form_validation->set_rules('VEI_CapacidadeTanque', 'Capacidade do Tanque', 'required');
		$this->form_validation->set_rules('VEI_Cilindrada', 'Cilindrada do Motor', 'required');
		$this->form_validation->set_rules('VEI_ConsumoMedio', 'Consumo Medio', 'required');
		$this->form_validation->set_rules('VEI_CapacidadePessoas', 'Capacidade de Pessoas', 'required|numeric');
		return $this->form_validation->run();
	}

	function create()
	{
		if ($this->validation()) {
			$this->load->model('MVeiculo');
			$_POST['VEI_Placa'] = strtoupper($_POST['VEI_Placa']);
			if ($this->MVeiculo->addVeiculo($_POST)) {
				$this->session->set_flashdata('sucesso', 'Veiculo Cadastrado.');
				redirect('veiculo/listing');
			} else {
				$this->session->set_flashdata('erro', 'Veiculo não cadastrado.');
				$this->add();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->add();
		}
	}

	function edit()
	{
		$VEI_Id = $this->uri->segment(3);
		$this->load->model('MVeiculo', '', true);
		$data['veiculo'] = $this->MVeiculo->getVeiculo($VEI_Id)->result();
		$data['title'] = "Modificar Veiculo - SG Transportes";
		$data['headline'] = "Edição de Veiculo";
		$data['include'] = "veiculo_add_edit";
		$data['update'] = true;
		$this->load->model('MMarca');
		$data['marcas'] = $this->MMarca->listMarcas();
		$this->load->view('template', $data);
	}

	function update()
	{
		if ($this->validation()) {
			$this->load->model('MVeiculo');
			$_POST['VEI_Placa'] = strtoupper($_POST['VEI_Placa']);
			if ($this->MVeiculo->updateVeiculo($_POST['VEI_Id'], $_POST)) {
				$this->session->set_flashdata('sucesso', 'Veiculo Atualizado.');
				redirect('veiculo/listing');
			} else {
				$this->session->set_flashdata('erro', 'Veiculo não Atualizado.');
				$this->edit();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->edit();
		}
	}


	function listing()
	{
		$this->load->model('MVeiculo', '', true);
		$qry = $this->MVeiculo->listVeiculo();
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading(
			'Modelo',
			'Placa',
			'Ano',
			'Renavam',
			'Editar',
			'Excluir',
			'<i class="fas fa-notes-medical"></i> Ocorrência',
			'<i class="fas fa-gas-pump"></i> Abastecimento',
			'<i class="fas fa-gas-pump"></i> Manutenção'
		);
		$table_row = array();

		foreach ($qry->result() as $veiculo) {
			$table_row = null;
			$table_row[] = $veiculo->MOD_Nome . "   " . $veiculo->VEI_Cilindrada;
			$table_row[] = $veiculo->VEI_Placa;
			$table_row[] = $veiculo->VEI_AnoFabricacao;
			$table_row[] = $veiculo->VEI_Renavam;
			$table_row[] =  anchor('veiculo/edit/' . $veiculo->VEI_Id, '<i class="fas fa-pencil-alt"></i>', 'title="Editar"');
			$table_row[] =  anchor(
				'veiculo/delete',
				'<i class="fas fa-trash-alt"></i>',
				"data-toggle='modal' data-target='#modalexcluir' title='Excluir' data-transfer='$veiculo->VEI_Placa' data-id='$veiculo->VEI_Id'"
			);

			//Ações de Ocorrencias
			$table_row[] =  anchor('ocorrencia/add/' . $veiculo->VEI_Id, '<i class="fas fa-plus"></i>', 'title="Ocorrência"') . " &nbsp;&nbsp;|&nbsp;&nbsp; " .
				anchor('ocorrencia/listing/' . $veiculo->VEI_Id, '<i class="fas fa-list"></i>', 'title="Listar Ocorrências"');

			//Ações de Abastecimento
			$table_row[] =  anchor('abastece/add/' . $veiculo->VEI_Id, '<i class="fas fa-plus"></i>', 'title="Registrar Abastecimento"') . " &nbsp;&nbsp;|&nbsp;&nbsp; " .
				anchor('abastece/listing/' . $veiculo->VEI_Id, '<i class="fas fa-list"></i>', 'title="Listar Abastecimentos"');

			//Ações de manutenção
			$table_row[] =  anchor('manutencao/add/' . $veiculo->VEI_Id, '<i class="fas fa-plus"></i>', 'title="Registrar Manutenção"') . " &nbsp;&nbsp;|&nbsp;&nbsp; " .
				anchor('manutencao/listing/' . $veiculo->VEI_Id, '<i class="fas fa-list"></i>', 'title="Listar Manutenções"');

			//Add Row a Tabela
			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();

		$data['title'] = "Listar Veiculos - SG Transportes";
		$data['headline'] = "Listar Veiculos";
		$data['include'] = "veiculo_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$VEI_Id = $this->uri->segment(3);
		$this->load->model('MVeiculo', '', true);
		if ($this->MVeiculo->deleteVeiculo($VEI_Id)) {
			$this->session->set_flashdata('sucesso', 'Veiculo Deletado.');
		} else {
			$this->session->set_flashdata('erro', 'Veiculo não Deletado.');
		}
		
		redirect('veiculo/listing', 'refresh');
	}

	function getModelos()
	{
		$MAR_Id = $this->input->post('MAR_Id');
		$this->load->model('mmodelo');
		echo $this->mmodelo->selectModelos($MAR_Id);
	}

	function informarEmplacamento($id)
	{
		$this->load->model('mveiculo');
		if ($this->mveiculo->informarEmplacamento($id)) {
			$this->session->set_flashdata('sucesso', 'Emplacamento registrado.');
			redirect('notificacoes/ipva', 'refresh');
		} else {
			$this->session->set_flashdata('erro', 'Erro ao registrar o Emplacamento.');
			redirect('notificacoes/ipva', 'refresh');
		}
	}
}

/* End of file veiculo.php */
/* Location: ./application/controllers/veiculo.php */
