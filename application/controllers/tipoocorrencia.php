<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tipoocorrencia extends CI_Controller
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
		$data['title'] = "Cadastro de Tipo de Ocorrência - SG Transportes";
		$data['headline'] = "Cadastro de Tipo de Ocorrência";
		$data['include'] = "tipo_ocorrencia_add";
		$this->load->view('template', $data);
	}

	function create()
	{
		$this->load->model('MTipoocorrencia', '', true);
		$this->MTipoocorrencia->addTipoocorrencia($_POST);
		$this->session->set_flashdata('sucesso', 'Tipo de Ocorrência Adicionada.');
		redirect('tipoocorrencia/listing', 'refresh');
	}

	function edit()
	{
		$TOC_Id = $this->uri->segment(3);
		$this->load->model('MTipoocorrencia', '', true);
		$data['tipoocorrencia'] = $this->MTipoocorrencia->getTipoocorrencia($TOC_Id)->result();
		$data['title'] = "Modificar tipo de Ocorrência - SG Transportes";
		$data['headline'] = "Edição de tipo de Ocorrência";
		$data['include'] = "tipo_ocorrencia_edit";
		$this->load->view('template', $data);
	}

	function update()
	{
		$this->load->model('MTipoocorrencia', '', true);
		$this->MTipoocorrencia->updateTipoocorrencia($_POST['TOC_Id'], $_POST);
		$this->session->set_flashdata('sucesso', 'Tipo de ocorrência Atualizada.');
		redirect('tipoocorrencia/listing');
	}


	function listing()
	{
		$this->load->model('MTipoocorrencia', '', true);
		$this->load->model('mocorrencia', '', true);
		$qry = $this->MTipoocorrencia->listTipoocorrencias();
		$table = $this->table->generate($qry);
		$tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Nome', 'Ações');
		$table_row = array();

		foreach ($qry->result() as $tipoocorrencia) {
				$table_row = null;
				$table_row[] = $tipoocorrencia->TOC_Nome;
				if ($this->mocorrencia->verificarTipoOcorrencia($tipoocorrencia->TOC_Id)) {
					$table_row[] =  anchor('tipoocorrencia/edit/' . $tipoocorrencia->TOC_Id, '<i class="fas fa-pencil-alt"></i>') . '&nbsp;&nbsp;|&nbsp;&nbsp; <i class="text-danger fas fa-minus-circle"></i>';
				} else {
					$table_row[] =  anchor('tipoocorrencia/edit/' . $tipoocorrencia->TOC_Id, '<i class="fas fa-pencil-alt"></i>') . "&nbsp;&nbsp;|&nbsp;&nbsp;" .  anchor(
						'tipoocorrencia/delete/' . $tipoocorrencia->TOC_Id . '/' . $tipoocorrencia->TOC_Id,
						'<i class="fas fa-trash-alt"></i>',
						"onClick=\" return confirm('Tem certeza que deseja remover o registro?')\""
					);
				}
				
				$this->table->add_row($table_row);
			}
		$table = $this->table->generate();

		$data['title'] = "Listar Tipos de Ocorrências - SG Transportes";
		$data['headline'] = "Listar Tipos de Ocorrências";
		$data['include'] = "tipo_ocorrencia_listing";
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function delete()
	{
		$TOC_Id = $this->uri->segment(3);
		$this->load->model('MTipoocorrencia', '', true);
		$this->MTipoocorrencia->deleteTipoocorrencia($TOC_Id);
		$this->session->set_flashdata('sucesso', 'Tipo de Ocorrência Deletada.');
		redirect('tipoocorrencia/listing', 'refresh');
	}
}

/* End of file oficina.php */
/* Location: ./application/controllers/oficinao.php */
