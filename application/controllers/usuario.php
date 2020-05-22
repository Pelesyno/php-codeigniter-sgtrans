<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller
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

	private function check_permission()
	{
		if ($this->session->userdata('FUN_Id') > 2) {
			$this->session->set_flashdata('erro', 'Acesso não Autorizado - verifique suas permissões Junto ao Administrador.');
			redirect('transporte/index');
		}
	}

	function add()
	{
		$this->check_permission();
		$data['title'] = "Cadastro de Usuário - Controle de Estoque";
		$data['headline'] = "Cadastro de Usuário";
		$data['include'] = "usuario_add";
		$this->load->model('MUsuario', '', true);
		$data['usuarios'] = $this->MUsuario->listUsuario();
		$this->load->model('MFuncao', '', true);
		$data['funcoes'] = $this->MFuncao->listFuncao();
		$this->load->model('MDepartamento', '', true);
		$data['departamentos'] = $this->MDepartamento->listDepartamento();
		$this->load->view('template', $data);
	}

	function create()
	{
		$this->check_permission();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('USU_Login', 'Login', 'is_unique[usuario.USU_Login] | required');
		if ($this->form_validation->run() == false) {
				$this->session->set_flashdata('erro', 'O Usuário <strong>' . $_POST['USU_Login'] . '</strong> já existe, ele deve ser único.');
				redirect('usuario/add');
			} else {

				$usuario = array(
					'USU_Nome'   => $_POST['USU_Nome'],
					'USU_Login'  => $_POST['USU_Login'],
					'USU_Password' => $_POST['USU_Password'],
					'USU_Email'   => $_POST['USU_Email'],
					'USU_Celular'   => $_POST['USU_Celular'],
					'USU_Ativo' => $_POST['USU_Ativo'],
					'FUN_Id' => $_POST['FUN_Id']
				);
				$this->load->model('MUsuario', '', true);
				$idInsert = $this->MUsuario->addUsuario($usuario);


				if ($_POST['FUN_Id'] == 4) {
					$solicitante = array(
						'USU_Id' 	=> $idInsert,
						'DEP_Id' => $_POST['DEP_Id']
					);
					$this->load->model('MSolicitante', '', true);
					if ($this->MSolicitante->addSolicitante($solicitante)) {
						$this->session->set_flashdata('sucesso', 'Solicitante Adicionado.');
					} else {
						$this->session->set_flashdata('erro', 'Solicitante não adicionado.');
					}
				} else if ($_POST['FUN_Id'] == 3) {
					$motorista = array(
						'USU_Id' 	=> $idInsert,
						'MOT_NumeroCnh'   => $_POST['MOT_NumeroCnh'],
						'MOT_DataValidadeCnh'  => $_POST['MOT_DataValidadeCnh'],
						'MOT_Categoria' => $_POST['MOT_Categoria']
					);
					$this->load->model('MMotorista', '', true);
					if ($this->MMotorista->addMotorista($motorista)) {
						$this->session->set_flashdata('sucesso', 'Motorista Adicionado.');
					} else {
						$this->session->set_flashdata('erro', 'Motorista não adicionado.');
					}
				}
			}
		redirect('usuario/listing', 'refresh');
	}

	function edit()
	{
		$id = $this->uri->segment(3);

		if ($this->session->userdata('FUN_Id') > 2) {
			$data['disabled'] = 'disabled';
		} else {
			$data['disabled'] = 'enabled';
		}

		$this->load->model('MUsuario', '', true);
		$data['usuario'] = $this->MUsuario->getUsuario($id)->result();
		$data['title'] = "Modificar Usuário - Controle de Estoque";
		$data['headline'] = "Edição de Usuário";
		$data['include'] = "usuario_edit";
		$this->load->model('MFuncao', '', true);
		$data['funcoes'] = $this->MFuncao->listFuncao();
		$this->load->model('MMotorista', '', true);
		$data['motorista'] = $this->MMotorista->getMotorista($id)->result();
		$this->load->model('MSolicitante', '', true);
		$data['solicitante'] = $this->MSolicitante->getSolicitante($id)->result();
		$this->load->model('MDepartamento', '', true);
		$data['departamentos'] = $this->MDepartamento->listDepartamento();
		$this->load->view('template', $data);
	}

	function update()
	{
		if ($this->session->userdata('FUN_Id') == 1) {

			$_POST1 = array(
				'USU_Nome'   => $_POST['USU_Nome'],
				'USU_Login'  => $_POST['USU_Login'],
				'USU_Password' => $_POST['USU_Password'],
				'USU_Email'   => $_POST['USU_Email'],
				'USU_Celular'   => $_POST['USU_Celular'],
				'USU_Ativo' => $_POST['USU_Ativo'],
				'FUN_Id' => $_POST['FUN_Id']
			);
			$this->load->model('MUsuario', '', true);
			$this->MUsuario->updateUsuario($_POST['USU_Id'], $_POST1);
		}


		if (($this->session->userdata('FUN_Id') == 2) && ($_POST['FUN_Id'] == 2)) {
			$_POST1 = array(
				'USU_Password' => $_POST['USU_Password']
			);
			$this->load->model('MUsuario', '', true);
			$this->MUsuario->updateUsuario($_POST['USU_Id'], $_POST1);
			$this->session->set_flashdata('sucesso', 'Usuário Atualizado.');
			redirect('transporte/index', 'refresh');
		}

		if ($this->session->userdata('FUN_Id') > 2) {
			$_POST1 = array(
				'USU_Password' => $_POST['USU_Password']
			);
			$this->load->model('MUsuario', '', true);
			$this->MUsuario->updateUsuario($_POST['USU_Id'], $_POST1);
			$this->session->set_flashdata('sucesso', 'Usuário Atualizado.');
			redirect('transporte/index', 'refresh');
		}


		if (($this->session->userdata('FUN_Id') == 2) && ($_POST['FUN_Id'] > 2)) {

			$_POST1 = array(
				'USU_Nome'   => $_POST['USU_Nome'],
				'USU_Login'  => $_POST['USU_Login'],
				'USU_Password' => $_POST['USU_Password'],
				'USU_Email'   => $_POST['USU_Email'],
				'USU_Celular'   => $_POST['USU_Celular'],
				'USU_Ativo' => $_POST['USU_Ativo'],
				'FUN_Id' => $_POST['FUN_Id']
			);
			$this->load->model('MUsuario', '', true);
			$this->MUsuario->updateUsuario($_POST['USU_Id'], $_POST1);

			if ($_POST['FUN_Id'] == 4) {
				$_POST2 = array(
					'DEP_Id' => $_POST['DEP_Id']
				);
				$this->load->model('MSolicitante', '', true);
				if ($this->MSolicitante->updateSolicitante($_POST['USU_Id'], $_POST2)) {
					$this->session->set_flashdata('sucesso', 'Solicitante Atualizado.');
				} else {
					$this->session->set_flashdata('erro', 'Solicitante não Atualizado.');
				}
			} else if ($_POST['FUN_Id'] == 3) {
				$_POST3 = array(
					'MOT_NumeroCnh'   => $_POST['MOT_NumeroCnh'],
					'MOT_DataValidadeCnh'  => $_POST['MOT_DataValidadeCnh'],
					'MOT_Categoria' => $_POST['MOT_Categoria']
				);
				$this->load->model('MMotorista', '', true);
				if ($this->MMotorista->updateMotorista($_POST['USU_Id'], $_POST3)) {
					$this->session->set_flashdata('sucesso', 'Motorista Atualizado.');
				} else {
					$this->session->set_flashdata('erro', 'Motorista não Atualizado.');
				}
			}
			$this->session->set_flashdata('sucesso', 'Usuário Atualizado.');
			redirect('usuario/listing', 'refresh');
		}
		redirect('transporte/index');
	}


	function inativa()
	{
		$this->check_permission();
		$id = $this->uri->segment(3);
		$this->load->model('MUsuario', '', true);
		$this->MUsuario->inativarUsuario($id);
		$this->session->set_flashdata('sucesso', 'Usuário desabilitado.');
		redirect('usuario/listing', 'refresh');
	}

	function ativa()
	{
		$this->check_permission();
		$id = $this->uri->segment(3);
		$this->load->model('MUsuario', '', true);
		$this->MUsuario->ativarUsuario($id);
		$this->session->set_flashdata('sucesso', 'Usuário Habilitado.');
		redirect('usuario/listing_inativos', 'refresh');
	}


	function listing()
	{
		$this->check_permission();
		$this->load->model('MUsuario', '', true);
		$qry = $this->MUsuario->listUsuario();
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Nome', 'Login', 'Função', 'Editar', 'Inativar');
		$table_row = array();
		$session_funcao_id = $this->session->userdata('FUN_Id');
		if ($session_funcao_id == "1") {
				foreach ($qry->result() as $usuario) {
						if (($usuario->FUN_Id != "1") && ($usuario->FUN_Id == "2")) {
								$table_row = null;
								$table_row[] = $usuario->USU_Nome;
								$table_row[] = $usuario->USU_Login;
								$table_row[] = $usuario->FUN_Nome;
								$table_row[] = anchor('usuario/edit/' . $usuario->USU_Id, '<i class="fas fa-user-edit"></i>');
								$table_row[] = anchor('usuario/inativa/' . $usuario->USU_Id, '<i class="fas fa-user-minus"></i>');

								$this->table->add_row($table_row);
							}
					}
			}
		if ($session_funcao_id == "2") {
				foreach ($qry->result() as $usuario) {
						if (($usuario->FUN_Id != "1") && ($usuario->FUN_Id != "2")) {
								$table_row = null;
								$table_row[] = $usuario->USU_Nome;
								$table_row[] = $usuario->USU_Login;
								$table_row[] = $usuario->FUN_Nome;
								$table_row[] = anchor('usuario/edit/' . $usuario->USU_Id, '<i class="fas fa-user-edit"></i>');
								$table_row[] = anchor('usuario/inativa/' . $usuario->USU_Id, '<i class="fas fa-user-minus"></i>');
								$this->table->add_row($table_row);
							}
					}
			}
		$table = $this->table->generate();
		$data['data_table'] = $table;
		///////////////////////////  tabela 2 //////////////////////////////
		$this->load->model('MUsuario', '', true);
		$qry2 = $this->MUsuario->listUsuarioAdm();
		$table2 = $this->table->generate($qry2);
		$tmpl2 = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl2);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Nome', 'Login', 'Função', 'Editar', 'Inativar');
		$table_row = array();
		$session_funcao_id = $this->session->userdata('FUN_Id');
		$session_user_id = $this->session->userdata('USU_Id');
		if ($session_funcao_id == "1") {
			$Funcao = "Administrador";
		} else {
			$Funcao = "Operador";
		}
		if (($session_funcao_id == "1") || ($session_funcao_id == "2")) {
				$this->load->model('MUsuario', '', true);
				$usuario_sess = $this->MUsuario->getUsuario($session_user_id)->result();
				$table_row = null;
				$table_row[] = $usuario_sess[0]->USU_Nome;
				$table_row[] = $usuario_sess[0]->USU_Login;
				$table_row[] = $this->session->userdata('FUN_Nome');
				$table_row[] = anchor('usuario/edit/' . $usuario_sess[0]->USU_Id, '<i class="fas fa-user-edit"></i>');
				$table_row[] = "Ativo"; //anchor('usuario/inativa/' . $session_id_user, '<span class="fas-fa-minus"></span>');

				$this->table->add_row($table_row);

				$data['funcao'] = "1";
				$table2 = $this->table->generate();
				$data['data_table2'] = $table2;
			} else {
			$data['funcao'] = "qualquer";
		}
		$data['title'] = "Usuário - SG Transportes";
		$data['headline'] = "Usuários Ativos";
		$data['headline2'] = $Funcao;
		$data['include'] = 'usuario_listing';

		$this->load->view('template', $data);
	}

	function listing_inativos()
	{
		$this->check_permission();
		$this->load->model('MUsuario', '', true);
		$qry = $this->MUsuario->listUsuarioInativo();
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Login', 'Função', 'Ativa');
		$table_row = array();
		$session_funcao_id = $this->session->userdata('FUN_Id');
		if ($session_funcao_id == "1") {
				foreach ($qry->result() as $usuario) {
						if (($usuario->FUN_Id != "1") && ($usuario->FUN_Id == "2")) {
								$table_row = null;
								$table_row[] = $usuario->USU_Login;
								$table_row[] = $usuario->FUN_Nome;
								$table_row[] = anchor('usuario/ativa/' . $usuario->USU_Id, '<i class="fas fa-user-plus"></i>');
								$this->table->add_row($table_row);
							}
					}
			}
		if ($session_funcao_id == "2") {
				foreach ($qry->result() as $usuario) {
						if (($usuario->FUN_Id != "1") && ($usuario->FUN_Id != "2")) {
								$table_row = null;
								$table_row[] = $usuario->USU_Login;
								$table_row[] = $usuario->FUN_Nome;
								$table_row[] = anchor('usuario/ativa/' . $usuario->USU_Id, '<i class="fas fa-user-plus"></i>');
								$this->table->add_row($table_row);
							}
					}
			}

		$table = $this->table->generate();
		$data['title'] = "Usuário - Controle de Estoque";
		$data['headline'] = "Usuário Inativos";
		$data['include'] = 'usuario_listing_ativa';
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}
}

/* End of file usuario.php */
/* Location: ./application/controllers/usuario.php */
