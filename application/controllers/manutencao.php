<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manutencao extends CI_Controller
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

		$this->form_validation->set_rules('MAN_Odometro', 'Odometro', 'required|is_numeric');
		$this->form_validation->set_rules('MAN_DataHoraEntrada', 'Data de Entrada', 'required');

		$this->form_validation->set_rules('VEI_Id', 'Veiculo', 'required|numeric');
		$this->form_validation->set_rules('OFI_Id', 'Oficina', 'required|numeric');

		return $this->form_validation->run();
	}

	function show($id)
	{
		$data['title'] = "Registro de Manutenções - SG Transportes";
		$data['headline'] = "Registro de Manutenções";
		$data['include'] = "manutencao_show";

		$this->load->model('mmanutencao');
		$data['manutencao'] = $this->mmanutencao->getManutencao($id)->result();

		$this->load->model('mveiculo');
		$data['veiculo'] = $this->mveiculo->getVeiculo($data['manutencao'][0]->VEI_Id)->result();

		$this->load->model('moficina');
		$data['oficina'] = $this->moficina->getOficina($data['manutencao'][0]->OFI_Id)->result();

		$this->load->model('mpecasutilizadas');
		$data['pecasUtilizadas'] = $this->mpecasutilizadas->getPecasUtilizadas($id);

		$this->load->model('mservicosutilizados');
		$data['servicosUtilizadas'] = $this->mservicosutilizados->getServicosUtilizados($id);

		$this->load->view('template', $data);
	}

	function add($id = null)
	{
		if ($id) {
			$this->load->model('mmanutencao');
			$odometro = $this->mmanutencao->getOdometro($id)->result();
			$odometro = $odometro[0]->MAN_Odometro;
			$data['manutencao'] = array(
				'0' => (object)array(
					'VEI_Id' => $id,
					'MAN_Odometro' => $odometro
				)
			);
		}
		$data['title'] = "Registro de Manutenções - SG Transportes";
		$data['headline'] = "Registro de Manutenções";
		$data['include'] = "manutencao_add_edit";
		$this->load->model('mveiculo');
		$data['veiculos'] = $this->mveiculo->listVeiculo();
		$this->load->model('moficina');
		$data['oficinas'] = $this->moficina->listOficina();
		$this->load->model('mpecas');
		$data['pecas'] = $this->mpecas->listPecas();
		$this->load->model('mservicos');
		$data['servicos'] = $this->mservicos->listServicos();
		$this->load->view('template', $data);
	}

	function create()
	{
		if ($this->validation()) {

			$this->load->model('mmanutencao');

			$manutencao = array(
				'MAN_DataHoraSaida'   => $_POST['MAN_DataHoraSaida'],
				'MAN_Odometro'  => $_POST['MAN_Odometro'],
				'MAN_DataHoraEntrada' => $_POST['MAN_DataHoraEntrada'],
				'MAN_CustoTotal' => 0.01,
				'VEI_Id'   => $_POST['VEI_Id'],
				'OFI_Id' => $_POST['OFI_Id']
			);


			if ($id = $this->mmanutencao->addManutencao($manutencao)) {

				//Adicionar peças Utilizadas
				if (!$this->addPecasUtilizadas($id, $_POST['pecasUtilizadas'])) {
					$this->session->set_flashdata('erro', 'Problema ao Registrar Peça.');
					$this->add();
				}

				//Adicionar Serviços Utilizados
				if (!$this->addServicosUtilizados($id, $_POST['servicosUtilizados'])) {
					$this->session->set_flashdata('erro', 'Problema ao Registrar Serviço.');
					$this->add();
				}

				$this->session->set_flashdata('sucesso', 'A Manutenção foi Registrada.');
				redirect('manutencao/listing', 'refresh');
			} else {
				$this->session->set_flashdata('erro', 'A Manutenção não foi Registrada.');
				$this->add();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->add();
		}
	}

	function edit($id)
	{
		$data['title'] = "Registro de Manutenções - SG Transportes";
		$data['headline'] = "Registro de Manutenções";
		$data['include'] = "manutencao_add_edit";
		$this->load->model('mveiculo');
		$data['veiculos'] = $this->mveiculo->listVeiculo();
		$this->load->model('moficina');
		$data['oficinas'] = $this->moficina->listOficina();
		$this->load->model('mpecas');
		$data['pecas'] = $this->mpecas->listPecas();
		$this->load->model('mservicos');
		$data['servicos'] = $this->mservicos->listServicos();
		$this->load->model('mmanutencao');
		$data['manutencao'] = $this->mmanutencao->getManutencao($id)->result();
		$this->load->model('mpecasutilizadas');
		$data['pecasUtilizadas'] = $this->mpecasutilizadas->getPecasUtilizadas($id);
		$this->load->model('mservicosutilizados');
		$data['servicosUtilizadas'] = $this->mservicosutilizados->getServicosUtilizados($id);
		$data['update'] = true;
		$this->load->view('template', $data);
	}

	function addPecasUtilizadas($id, $pecas)
	{
		$array_pecas = explode("|", $pecas);
		$this->load->model('mpecasutilizadas');
		$this->load->model('mpecas');
		if ($array_pecas[0] != "") {
			foreach ($array_pecas as $peca) {
				$valorPeca = $this->mpecas->getPeca($peca)->result();
				$pecasUtilizadas = array(
					'MAN_Id' => $id,
					'PEC_Id' => $peca,
					'PU_Valor' => $valorPeca[0]->PEC_Preco
				);
				$ok = $this->mpecasutilizadas->addPecaUtilizada($pecasUtilizadas);
			}
			return $ok;
		}
	}

	function addServicosUtilizados($id, $servicos)
	{
		$array_servicos = explode("|", $servicos);
		$this->load->model('mservicosutilizados');
		$this->load->model('mservicos');
		if ($array_servicos[0] != "") {
			foreach ($array_servicos as $servico) {
				$valorServico = $this->mservicos->getServico($servico)->result();
				$servicosUtilizados = array(
					'MAN_Id' => $id,
					'SER_Id' => $servico,
					'SU_Valor' => $valorServico[0]->SER_Preco
				);
				$ok = $this->mservicosutilizados->addServicoUtilizado($servicosUtilizados);
			}
			return $ok;
		} else {
			return FALSE;
		}
	}

	function update()
	{
		$id = $_POST['MAN_Id'];
		if ($this->validation()) {

			$this->load->model('mmanutencao');
			$this->load->model('mservicosutilizados');
			$this->load->model('mpecasutilizadas');

			$manutencao = array(
				'MAN_DataHoraSaida'   => $_POST['MAN_DataHoraSaida'],
				'MAN_Odometro'  => $_POST['MAN_Odometro'],
				'MAN_DataHoraEntrada' => $_POST['MAN_DataHoraEntrada'],
				'MAN_CustoTotal' => 0,
				'VEI_Id'   => $_POST['VEI_Id'],
				'OFI_Id' => $_POST['OFI_Id']
			);

			if ($this->mmanutencao->updateManutencao($id, $manutencao)) {
				//Atualizar Peças Utilizadas
				$this->mpecasutilizadas->deletarPecasUtilizadas($id);
				$this->addPecasUtilizadas($id, $_POST['pecasUtilizadas']);

				//Atualizar Serviços Utilizados
				$this->mservicosutilizados->deletarServicosUtilizados($id);
				$this->addServicosUtilizados($id, $_POST['servicosUtilizados']);

				$this->session->set_flashdata('sucesso', 'Manutenção Atualizada!');
				redirect('manutencao/listing', 'refresh');
			} else {
				$this->session->set_flashdata('erro', 'Manutenção não Atualizada!');
				redirect('manutencao/edit/' . $id, 'refresh');
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->edit($id);
		}
	}

	function listing($id = null)
	{
		$data['title'] = "Registro de Manutenções - SG Transportes";
		$data['headline'] = "Registros de Manutenções";
		$data['include'] = "manutencao_listing";
		$this->load->model('mmanutencao');
		if ($id) {
			$qry = $this->mmanutencao->listManutencao($id);
		} else {
			$qry = $this->mmanutencao->listManutencoes();
		}

		$tmpl = array(
			'table_open'  => '<table id="abasteceTable" class="table table-bordered table-hover table-sm text-center ">'
		);
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Data Entrada', 'Data Saída', 'Veículo - Placa', 'Odometro', 'Oficina', 'Custo', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $manutencao) {

			$table_row = null;
			$table_row[] = (mysql_to_pt($manutencao->MAN_DataHoraEntrada));
			$table_row[] = (mysql_to_pt($manutencao->MAN_DataHoraSaida));
			$this->load->model('mveiculo');
			$veiculo = $this->mveiculo->getVeiculo($manutencao->VEI_Id)->result();
			$table_row[] = ($veiculo[0]->VEI_Placa);
			$table_row[] = ($manutencao->MAN_Odometro);
			$this->load->model('moficina');
			$oficina = $this->moficina->getOficina($manutencao->OFI_Id)->result();
			$table_row[] = ($oficina[0]->OFI_RazaoSocial);
			$table_row[] = ('R$ ' . number_format($manutencao->MAN_CustoTotal, 2, ',', '.'));

			if($manutencao->MAN_DataHoraSaida != '0000-00-00'){
				$table_row[] = (anchor('manutencao/show/' . $manutencao->MAN_Id, '<i class="fas fa-eye"></i>', 'title="Ver Manutenção"'));
			}else{

			$table_row[] = (anchor('manutencao/show/' . $manutencao->MAN_Id, '<i class="fas fa-eye"></i>', 'title="Ver Manutenção"') .
				" &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;" . anchor('manutencao/edit/' . $manutencao->MAN_Id, '<i class="fas fa-pencil-alt"></i>', 'title="Editar Manutenção"') .
				" &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;" .
				anchor(
					'manutencao/listing',
					'<i class="fas fa-trash-alt"></i>',
					"data-toggle='modal' data-target='#modalexcluir' title='Excluir Manutenção' data-transfer=" . $veiculo[0]->VEI_Placa . " data-id=" . $manutencao->MAN_Id
				));
			}

			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$MAN_Id = $this->uri->segment(3);
		$this->load->model('mmanutencao', '', true);
		//$this->load->model('mpecasutilizadas', '', true);
		//$this->load->model('mservicosutilizados', '', true);

		//if ($this->mpecasutilizadas->getPecasUtilizadas($MAN_Id)->num_rows() > 0 || $this->mservicosutilizados->getServicosUtilizados($MAN_Id)->num_rows() > 0) {
		//	$this->session->set_flashdata('erro', 'Manutenção possui peças ou serviços vinculados, Não foi possivel Deletar!');
		//	redirect('manutencao/listing', 'refresh');
		//} else {
			if ($this->mmanutencao->deleteManutencao($MAN_Id)) {
				$this->session->set_flashdata('sucesso', 'Manutenção Deletada.');
				redirect('manutencao/listing', 'refresh');
			} else {
				$this->session->set_flashdata('erro', 'Não foi possivel Deletar a Manutenção.');
				redirect('manutencao/listing', 'refresh');
			}
		//}
	}
}
