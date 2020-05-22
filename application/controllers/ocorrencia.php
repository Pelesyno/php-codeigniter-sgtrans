<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ocorrencia extends CI_Controller
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
		$VEI_Id = $this->uri->segment(3);

		$this->load->model('MVeiculo', '', true);
		$data['veiculo'] = $this->MVeiculo->getVeiculo($VEI_Id)->result();

		$veiculo = $this->MVeiculo->getVeiculo($VEI_Id)->result();
		$MOD_Id = $veiculo[0]->VEI_Modelo;

		$this->load->model('MModelo', '', true);
		$data['modelo'] = $this->MModelo->getModelo($MOD_Id)->result();

		$this->load->model('MMotorista', '', true);
		$data['motorista'] = $this->MMotorista->listMotorista();

		$this->load->model('MUsuario', '', true);
		$data['usuario'] = $this->MUsuario->listUsuario();

		$this->load->model('MTipoocorrencia', '', true);
		$data['tipoocorrencia'] = $this->MTipoocorrencia->listTipoocorrencias();

		$data['title'] = "Cadastro de Ocorrência - SG Transportes";
		$data['headline'] = "Cadastro de Ocorrência";
		$data['include'] = "ocorrencia_add";
		$this->load->view('template', $data);
	}

	function create()
	{
		// Upload das Fotos da Ocorrencia na pasta Assets/img/ocorrencias;
		$config["upload_path"] = FCPATH . "assets/img/ocorrencias";
		$config["allowed_types"] = "gif|jpg|jpeg|png|pdf";
		$config["encrypt_name"] = true;
		$this->load->library("upload", $config);

		if (isset($_FILES["OCO_Anexo1"]) && $_FILES["OCO_Anexo1"]["name"] != "") {
			if ($this->upload->do_upload("OCO_Anexo1")) {
				$info_arquivo = $this->upload->data();
				$_POST['OCO_Anexo1'] = $info_arquivo['file_name'];
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não cadastrada, Erro no anexo 1.' . $this->upload->display_errors());
				redirect('ocorrencia/listing', 'refresh');
			}
		}
		if (isset($_FILES["OCO_Anexo2"]) && $_FILES["OCO_Anexo2"]["name"] != "") {
			if ($this->upload->do_upload("OCO_Anexo2")) {
				$info_arquivo2 = $this->upload->data();
				$_POST['OCO_Anexo2'] = $info_arquivo2['file_name'];
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não cadastrada, Erro no anexo 2.' . $this->upload->display_errors());
				redirect('ocorrencia/listing', 'refresh');
			}
		}
		if (isset($_FILES["OCO_Anexo3"]) && $_FILES["OCO_Anexo3"]["name"] != "") {
			if ($this->upload->do_upload("OCO_Anexo3")) {
				$info_arquivo3 = $this->upload->data();
				$_POST['OCO_Anexo3'] = $info_arquivo3['file_name'];
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não cadastrada, Erro no anexo 3.' . $this->upload->display_errors());
				redirect('ocorrencia/listing', 'refresh');
			}
		}

		$this->load->model('MOcorrencia', '', true);

		if ($this->MOcorrencia->addOcorrencia($_POST)) {
			$this->session->set_flashdata('sucesso', 'Ocorrência adicionada.');
			redirect('ocorrencia/listing', 'refresh');
		} else {
			$this->session->set_flashdata('erro', 'Ocorrência não adicionada.');
			$this->add();
		}
	}

	function edit()
	{
		$OCO_Id = $this->uri->segment(3);

		$this->load->model('MOcorrencia', '', true);
		$data['ocorrencia'] = $this->MOcorrencia->getOcorrencia($OCO_Id)->result();

		$ocorrencia = $this->MOcorrencia->getOcorrencia($OCO_Id)->result();
		$VEI_Id = $ocorrencia[0]->VEI_Id;

		$this->load->model('MVeiculo', '', true);
		$data['veiculo'] = $this->MVeiculo->getVeiculo($VEI_Id)->result();

		$veiculo = $this->MVeiculo->getVeiculo($VEI_Id)->result();
		$MOD_Id = $veiculo[0]->VEI_Modelo;

		$this->load->model('MModelo', '', true);
		$data['modelo'] = $this->MModelo->getModelo($MOD_Id)->result();

		$this->load->model('MMotorista', '', true);
		$data['motorista'] = $this->MMotorista->listMotorista();

		$this->load->model('MUsuario', '', true);
		$data['usuario'] = $this->MUsuario->listUsuario();

		$this->load->model('MTipoocorrencia', '', true);
		$data['tipoocorrencia'] = $this->MTipoocorrencia->listTipoocorrencias();
		$data['title'] = "Modificar Ocorrência - SG Transportes";
		$data['headline'] = "Edição de Ocorrência";
		$data['include'] = "ocorrencia_edit";
		$this->load->view('template', $data);
	}

	function update()
	{
		// Upload das Fotos da Ocorrencia na pasta Assets/img/ocorrencias;
		$config["upload_path"] = FCPATH . "assets/img/ocorrencias";
		$config["allowed_types"] = "gif|jpg|jpeg|png|pdf";
		$config["encrypt_name"] = true;
		$this->load->library("upload", $config);
		$this->load->model('MOcorrencia');
		$exist = $this->MOcorrencia->getOcorrencia($_POST['OCO_Id'])->result();

		if (isset($_FILES["OCO_Anexo1"]) && $_FILES["OCO_Anexo1"]["name"] != "") {

			$arquivo = FCPATH . "assets/img/ocorrencias/" . $exist[0]->OCO_Anexo1;
			if (file_exists($arquivo)) {
				unlink($arquivo);
			}

			if ($this->upload->do_upload("OCO_Anexo1")) {
				$info_arquivo = $this->upload->data();
				$_POST['OCO_Anexo1'] = $info_arquivo['file_name'];
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não atualizada, Erro no anexo 1.' . $this->upload->display_errors());
				redirect('ocorrencia/listing', 'refresh');
			}
		}
		if (isset($_FILES["OCO_Anexo2"]) && $_FILES["OCO_Anexo2"]["name"] != "") {

			$arquivo2 = FCPATH . "assets/img/ocorrencias/" . $exist[0]->OCO_Anexo2;
			if (file_exists($arquivo2)) {
				unlink($arquivo2);
			}
			if ($this->upload->do_upload("OCO_Anexo2")) {
				$info_arquivo2 = $this->upload->data();
				$_POST['OCO_Anexo2'] = $info_arquivo2['file_name'];
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não atualizada, Erro no anexo 2.' . $this->upload->display_errors());
				redirect('ocorrencia/listing', 'refresh');
			}
		}
		if (isset($_FILES["OCO_Anexo3"]) && $_FILES["OCO_Anexo3"]["name"] != "") {
			$arquivo3 = FCPATH . "assets/img/ocorrencias/" . $exist[0]->OCO_Anexo3;
			if (file_exists($arquivo3)) {
				unlink($arquivo3);
			}
			if ($this->upload->do_upload("OCO_Anexo3")) {
				$info_arquivo3 = $this->upload->data();
				$_POST['OCO_Anexo3'] = $info_arquivo3['file_name'];
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não atualizada, Erro no anexo 3.' . $this->upload->display_errors());
				redirect('ocorrencia/listing', 'refresh');
			}
		}

		if ($this->MOcorrencia->updateOcorrencia($_POST['OCO_Id'], $_POST)) {
			$this->session->set_flashdata('sucesso', 'Ocorrência Atualizada.');
			redirect('ocorrencia/listing');
		} else {
			$this->session->set_flashdata('erro', 'Ocorrência não atualizada.');
			$this->edit();
		}
	}


	function listing($id = null)
	{
		$this->load->model('MOcorrencia', '', true);
		if($id){
			$qry = $this->MOcorrencia->listOcorrencia($id);
		}else{
			$qry = $this->MOcorrencia->listOcorrencias();
		}
		
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Data', 'Tipo', 'Motorista', 'Modelo', 'Placa', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $ocorrencia) {
				$table_row = null;
				$table_row[] = mysql_to_pt($ocorrencia->OCO_Data);
				$table_row[] = $ocorrencia->TOC_Nome;
				$table_row[] = $ocorrencia->USU_Nome;
				$this->load->model('MModelo', '', true);
				$modelo = $this->MModelo->getModelo($ocorrencia->VEI_Modelo)->result();
				$table_row[] = $modelo[0]->MOD_Nome;
				$table_row[] = $ocorrencia->VEI_Placa;
				$table_row[] =  anchor('ocorrencia/edit/' . $ocorrencia->OCO_Id, '<i class="fas fa-pencil-alt"></i>') . "&nbsp;&nbsp;|&nbsp;&nbsp;" . anchor(
					'ocorrencia/delete',
					'<i class="fas fa-trash-alt"></i>',
					'data-toggle="modal" data-target="#modalexcluir" data-transfer="' . $ocorrencia->TOC_Nome . ' da Plca ' . $ocorrencia->VEI_Placa . '" data-id="' . $ocorrencia->OCO_Id . '"'
				);
				$this->table->add_row($table_row);
			}
		$table = $this->table->generate();

		$data['title'] = "Listar Ocorrências - SG Transportes";
		$data['headline'] = "Listar Ocorrências";
		$data['include'] = "ocorrencia_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$OCO_Id = $this->uri->segment(3);
		$this->load->model('MOcorrencia', '', true);
		$exist = $this->MOcorrencia->getOcorrencia($OCO_Id)->result();
		if ($exist) {

			if ($this->MOcorrencia->deleteOcorrencia($OCO_Id)) {
				$arquivo = FCPATH . "assets/img/ocorrencias/" . $exist[0]->OCO_Anexo1;
				$arquivo2 = FCPATH . 'assets/img/ocorrencias/' . $exist[0]->OCO_Anexo2;
				$arquivo3 = FCPATH . 'assets/img/ocorrencias/' . $exist[0]->OCO_Anexo3;

				if (file_exists($arquivo)) {
					unlink($arquivo);
				}
				if (file_exists($arquivo2)) {
					unlink($arquivo2);
				}
				if (file_exists($arquivo3)) {
					unlink($arquivo3);
				}

				var_dump($exist);


				$this->session->set_flashdata('sucesso', 'Ocorrência Deletada.');
			} else {
				$this->session->set_flashdata('erro', 'Ocorrência não deletada.');
			}
		} else {
			$this->session->set_flashdata('erro', 'Ocorrência não encontrada.');
		}
		redirect('ocorrencia/listing', 'refresh');
	}
}

/* End of file oficina.php */
/* Location: ./application/controllers/oficinao.php */
