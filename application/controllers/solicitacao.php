<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Solicitacao extends CI_Controller
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

	private function check_permission($t)
	{
		if ($this->session->userdata('FUN_Id') != $t) {
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}
	}

	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		$this->form_validation->set_rules('SOL_Tipo_Veiculo', 'Tipo de Veiculo', 'trim|required');
		$this->form_validation->set_rules('SOL_Data', 'Data da Solicitação', 'trim|required');
		$this->form_validation->set_rules('SOL_Hora', 'Hora da Solicitação', 'trim|required');

		return $this->form_validation->run();
	}

	function validationUpdate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
		$this->form_validation->set_rules('SOL_MOT_Id', 'Motorista', 'trim|required');
		$this->form_validation->set_rules('SOL_Veiculo', 'Veiculo', 'trim|required');

		return $this->form_validation->run();
	}

	function add()
	{
		if ($this->session->userdata('FUN_Id') != 4){
			if($this->session->userdata('FUN_Id') != 2){
				$this->check_permission(4);
			}
		}
		$data['title'] = "Registro de Solicitação - SG Transportes";
		$data['headline'] = "Registro de Solicitação";
		$data['include'] = "solicitacao/add";
		$this->load->view('template', $data);
	}

	function show($id){
		
		$data['title'] = "Registro de Solicitação - SG Transportes";
		$data['headline'] = "Registro de Solicitação";
		$data['include'] = "solicitacao/show";
		$this->load->model('msolicitacao');
		$this->load->model('mveiculo');
		$this->load->model('musuario');
		$data['solicitacao'] = $this->msolicitacao->getSolicitacoes($id)->result();

		if(($this->session->userdata('FUN_Id') == 3) && ($this->session->userdata('USU_Id') != $data['solicitacao'][0]->SOL_MOT_Id)){
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}

		if(($this->session->userdata('FUN_Id') == 4) && ($this->session->userdata('USU_Id') != $data['solicitacao'][0]->SOL_USE_Id)){
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}
		
		if($data['solicitacao'][0]->SOL_Veiculo){
			$veiculo = $this->mveiculo->getVeiculo($data['solicitacao'][0]->SOL_Veiculo)->result();
			$data['veiculo'] = $veiculo[0]->VEI_Placa;
		}else{
			$data['veiculo'] = ' - ';
		}
		 
		if($data['solicitacao'][0]->SOL_MOT_Id){
			$motorista = $this->musuario->getUsuario($data['solicitacao'][0]->SOL_MOT_Id)->result();
			$data['motorista'] = $motorista[0]->USU_Nome;
		}else{
			$data['motorista'] = ' - ';
		}
		
		$this->load->view('template', $data);
	}

	function create()
	{
		if ($this->validation()) {
			$this->load->model('msolicitacao');
			$data = explode("/", $_POST['SOL_Data']);
			$_POST['SOL_Data'] = $data[2] . '-' . $data[1] . '-' . $data[0];
			$_POST['SOL_USE_Id'] = $this->session->userdata('USU_Id');
			if ($this->msolicitacao->addSolicitacao($_POST)) {
				$this->session->set_flashdata('sucesso', 'Solicitação Cadastrada.');
				redirect('solicitacao/listing');
			} else {
				$this->session->set_flashdata('erro', 'Solicitação não cadastrada.');
				$this->add();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->add();
		}
	}

	function edit($id)
	{
		$this->check_permission(2);
		$this->load->model('msolicitacao');
		$this->load->model('musuario');
		$this->load->model('mveiculo');
		$data['solicitacao'] = $this->msolicitacao->getSolicitacoes($id)->result();
		$data['title'] = "Registro de Solicitação - SG Transportes";
		$data['headline'] = "Registro de Solicitação";
		$data['motoristas'] = $this->musuario->getUsuarioFuncao(3, $data['solicitacao'][0]->SOL_Data);
		$data['veiculos'] = $this->mveiculo->getTipoVeiculo($data['solicitacao'][0]->SOL_Tipo_Veiculo);
		$data['include'] = "solicitacao/edit";
		$this->load->view('template', $data);
	}

	function update()
	{ 
		if ($this->validationUpdate()) {
			$this->load->model('msolicitacao');
			$_POST['SOL_Status'] = 1;
			if ($this->msolicitacao->updateSolicitacao($_POST['SOL_Id'], $_POST)) {
				$this->session->set_flashdata('sucesso', 'Solicitação Aprovada.');
				redirect('solicitacao/listing');
			} else {
				$this->session->set_flashdata('erro', 'Solicitação não Aprovada.');
				$this->edit($_POST['SOL_Id']);
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->edit($_POST['SOL_Id']);
		}
	}

	function listing()
	{
		$data['title'] = "Registro de Solicitações - SG Transportes";
		$data['headline'] = "Registros de Solicitações";
		$data['include'] = "solicitacao/listing";
		$this->load->model('msolicitacao', '', true);
		$this->load->model('musuario', '', true);
		$this->load->model('mveiculo', '', true);

		if($this->session->userdata('FUN_Id') == 3){
			$qry = $this->msolicitacao->listSolicitacoesMotorista($this->session->userdata('USU_Id'));
		}else if($this->session->userdata('FUN_Id') == 4){
			$qry = $this->msolicitacao->listSolicitacoesSolicitante($this->session->userdata('USU_Id'));
		}else{
			$qry = $this->msolicitacao->listSolicitacoes();
		}

		$tmpl = array(
			'table_open'  => '<table id="tabela" class="table table-bordered table-hover table-sm text-center ">'
		);
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Solicitante', 'Data', 'Hora', 'Veiculo', 'Motorista', 'Status', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $solicitacao) {

			$user = $this->musuario->getUsuario($solicitacao->SOL_USE_Id)->result();
			$veiculo = $this->mveiculo->getVeiculo($solicitacao->SOL_Veiculo)->result();
			$table_row = null;

			$d = $user[0]->USU_Nome;

			$table_row[] = $user[0]->USU_Nome;
			$table_row[] = (mysql_to_pt($solicitacao->SOL_Data));
			$table_row[] = $solicitacao->SOL_Hora;
			if($veiculo){
				$table_row[] = $veiculo[0]->VEI_Placa;
			}else{
				$table_row[] = ' - ';
			}
			$motorista = $this->musuario->getUsuario($solicitacao->SOL_MOT_Id)->result();
			if($motorista){
				$table_row[] = $motorista[0]->USU_Nome;
			}else{
				$table_row[] = ' - ';
			}
			
			if ($solicitacao->SOL_Status == 0) {
				$table_row[] = 'Pendente';
				$table_row[] =  anchor('solicitacao/edit/' . $solicitacao->SOL_Id, '<i class="fas fa-pencil-alt"></i>', 'title="Editar"')
					. '&nbsp;&nbsp;|&nbsp;&nbsp;' .  anchor(
						'solicitacao/delete',
						'<i class="fas fa-trash-alt"></i>',
						"data-toggle='modal' data-target='#modalexcluir' title='Excluir' data-transfer='$d' data-id='$solicitacao->SOL_Id'"
					);
			} else if ($solicitacao->SOL_Status == 1) {
				$table_row[] = 'Aprovado';
				$table_row[] = (anchor('solicitacao/show/' . $solicitacao->SOL_Id, '<i class="fas fa-eye"></i>', 'title="Ver Solicitacao"'));
			} else {
				$table_row[] = 'Rejeitado';
				$table_row[] = (anchor('solicitacao/show/' . $solicitacao->SOL_Id, '<i class="fas fa-eye"></i>', 'title="Ver Solicitacao"'));
			}

			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$this->check_permission(2);
		$SOL_Id = $this->uri->segment(3);
		$this->load->model('msolicitacao', '', true);
		if($this->msolicitacao->deleteSolicitacao($SOL_Id)){
			$this->session->set_flashdata('sucesso', 'Solicitação Deletada.');
		}else{
			$this->session->set_flashdata('erro', 'Solicitação não Deletada.');
		}
		redirect('solicitacao/listing', 'refresh');
		
	}

	function verificarDatas()
	{
		$VEI_Tipo = $_POST['VEI_Tipo'];
		$this->load->model('mveiculo', '', true);
		$total = $this->mveiculo->countTipoVeiculo($VEI_Tipo);

		if ($total > 0) {
			$dia = date("d");
			$mes = date("m");
			$ano = date("Y");
			$ultimo_dia = date("t", mktime(0, 0, 0, $mes, '01', $ano));
			$r = "<option>Selecione a Data</option>" . PHP_EOL;
			while ($ultimo_dia >= $dia) {
				$data = $ano . '-' . $mes . '-' . $dia;
				$this->load->model('msolicitacao', '', true);
				$tSolicitacoes = $this->msolicitacao->listSolicitacoesData($VEI_Tipo, $data);
				$data = $dia . '/' . $mes . '/' . $ano;
				$dispon = (($total * 19) - $tSolicitacoes);
				$r .= "<option value='{$data}' >{$data} ({$dispon})</option>" . PHP_EOL;
				$dia = $dia + 1;
			}
		} else {
			$r .= "<option value='' >Sem Carros Disponiveis</option>" . PHP_EOL;
		}
		echo $r;
	}
	function verificarHoras()
	{
		$VEI_Tipo = $_POST['VEI_Tipo'];
		$data = explode("/", $_POST['SOL_Data']);
		$dataSelecionada = $data[2] . '-' . $data[1] . '-' . $data[0];
		$this->load->model('mveiculo', '', true);
		$total = $this->mveiculo->countTipoVeiculo($VEI_Tipo);
		$r = "<option>Selecione a Hora</option>" . PHP_EOL;
		if ($total > 0) {
			$this->load->model('msolicitacao', '', true);

			foreach ($this->msolicitacao->listHorasAtendimento()->result() as $hora) {
				echo $tSolicitacoes = $this->msolicitacao->listSolicitacoesHora($VEI_Tipo, $dataSelecionada, $hora->Hora);
				$dispon = ($total - $tSolicitacoes);
				if ($dispon != 0) {
					$r .= "<option value='{$hora->Hora}' >{$hora->Hora} ({$dispon})</option>" . PHP_EOL;
				}
			}
		} else {
			$r .= "<option value='' >Sem Data Disponivel</option>" . PHP_EOL;
		}
		echo $r;
	}

	function rejeitar($SOL_Id)
	{
		$this->check_permission(2);
		$this->load->model('msolicitacao', '', true);
		if ($this->msolicitacao->rejeitarSolicitacao($SOL_Id)) {
			$this->session->set_flashdata('sucesso', 'Solicitação Rejeitada.');
			redirect('solicitacao/listing', 'refresh');
		}
	}
}
