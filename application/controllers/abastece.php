<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Abastece extends CI_Controller
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
		$this->form_validation->set_rules('VEI_Id', 'Veiculo', 'trim|required|numeric');
		$this->form_validation->set_rules('ABA_ValorAbastecido', 'Valor do Abastecimento', 'trim|required|is_decimal');
		$this->form_validation->set_rules('ABA_Odometro', 'Odometro', 'required|is_numeric');
		$this->form_validation->set_rules('ABA_Litros', 'Litros', 'required|is_decimal');
		$this->form_validation->set_rules('ABA_Data', 'Data do Abastecimento', 'required');
		$this->form_validation->set_rules('ABA_Combustivel', 'Combustível', 'required|numeric');
		$this->form_validation->set_rules('ABA_EstadoTanque', 'Nível antes do Abastecimento', 'required|numeric');
		$this->form_validation->set_rules('POS_Id', 'Posto', 'required|numeric');

		return $this->form_validation->run();
	}

	function add($id = null)
	{
		if ($id) {
			$this->load->model('mabastecer');
			$odometro = $this->mabastecer->getOdometro($id)->result();
			$data['abastece'] = array(
				'0' => (object)array(
					'VEI_Id' => $id,
					'ABA_OdometroAntigo' => $odometro[0]->ABA_Odometro,
					'ABA_Odometro' => $odometro[0]->ABA_Odometro + $odometro[0]->ABA_Autonomia,
					'ABA_Combustivel' => $odometro[0]->ABA_Combustivel
				)
			);
		}
		$data['title'] = "Registro de Abastecimentos - SG Transportes";
		$data['headline'] = "Registro de Abastecimento";
		$data['include'] = "abastece_add_edit";
		$this->load->model('mveiculo');
		$data['veiculos'] = $this->mveiculo->listVeiculo();
		$this->load->model('mposto');
		$data['postos'] = $this->mposto->listPosto();
		$this->load->model('musuario');
		$data['motoristas'] = $this->musuario->listUsuario();
		$data['edit'] = 'enabled';
		$this->load->view('template', $data);
	}

	function prepararAbastecimento($tipo)
	{
			$this->load->model('MVeiculo', '', true);
			$this->load->model('MEmpresa', '', true);
			$qry_empresa = $this->MEmpresa->listEmpresa();
  	        foreach ($qry_empresa->result() as $empresa) {
              $tolerancia = $empresa->EMP_Tolerancia;
              }
			$this->load->model('mabastecer');

			$veiculo_id = $this->input->post('VEI_Id');
			$veiculo = $this->MVeiculo->getVeiculo($veiculo_id)->result();
			$consumo = $veiculo[0]->VEI_ConsumoMedio;

			$abastecido = $this->input->post('ABA_Litros');
            $abastecidoR = str_replace(',', '.', $abastecido);
			$autonomia = $consumo * $abastecidoR;
			
            //$resul = (10.0 * 12.85);
            //echo  "<script>alert('consumo -> $consumo -Abastecido -> $abastecidoR - autonomia -> $autonomia - Resultado -> $resul  !');</script>";
			
            $autonomia_original = $autonomia;

            $_POST['ABA_Autonomia'] = $autonomia;
			$_POST['ABA_Status'] = "Aberto";

			if ($tipo == 'create') {
				$abastecimento = $this->mabastecer->getOdometro($veiculo_id);
			} else {
				$abastecimento = $this->mabastecer->getOdometroUpdate($veiculo_id);
			}
			
			if ($abastecimento->num_rows == 1) {
                $abasteceu = $abastecimento->result();
				$percorrido = $_POST['ABA_Odometro'] - $abasteceu[0]->ABA_Odometro;
				$autonomia = $abasteceu[0]->ABA_Autonomia;
				$diferenca = $autonomia - $percorrido;
				$porcentagem = ($tolerancia / 100) * $autonomia;
				$autonomia = $autonomia - $porcentagem;

				if ($percorrido >= $autonomia) {
					$consumo_status = "Normal";
				} else {
                        if($_POST['ABA_EstadoTanque'] == 1){
                           $consumo_status = "Alto";
                        }
                        else{
                              $_POST['ABA_Autonomia'] = $autonomia_original + $diferenca;
				              $consumo_status = "Completado";
                        }

                 }

				$data = array(
					'ABA_Consumo' => $consumo_status,
					'ABA_Status' => "Fechado",
					'ABA_Percorrido' => $_POST['ABA_Odometro'] - $abasteceu[0]->ABA_Odometro

				);
				
				if ($this->mabastecer->editAbastecimento($abasteceu[0]->ABA_Id, $data)) {
					$this->session->set_flashdata('sucesso', 'O Odometro foi Atualizado.');
				} else {
					$this->session->set_flashdata('erro', 'O Abastecimento não foi Registrado.');
					redirect('abastece/listing', 'refresh');
				}
				
			}	
			return TRUE;	
	}

	function create()
	{
		if ($this->validation()) {
			if($this->prepararAbastecimento('create')){	
				if ($this->mabastecer->addAbastecimento($_POST)) {
					$this->session->set_flashdata('sucesso', 'O Abastecimento foi Registrado.');
					redirect('abastece/listing', 'refresh');
				} else {
					$this->session->set_flashdata('erro', 'O Abastecimento não foi Registrado.');
					$this->add();
				}
			}else{
				$this->session->set_flashdata('erro', 'Problema na Preparação.');
				$this->add();
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->add();
		}
	}

	function edit($id)
	{
		$this->load->model('mabastecer');
		$data['abastece'] = $this->mabastecer->getAbastecimento($id)->result();
		$data['update'] = true;
		$data['title'] = "Registro de Abastecimentos - SG Transportes";
		$data['headline'] = "Registro de Abastecimento";
		$data['include'] = "abastece_add_edit";
		$this->load->model('mveiculo');
		$data['veiculos'] = $this->mveiculo->listVeiculo();
		$this->load->model('mposto');
		$data['postos'] = $this->mposto->listPosto();
		$this->load->model('musuario');
		$data['motoristas'] = $this->musuario->listUsuario();
		$data['edit'] = 'disabled';
		$this->load->view('template', $data);
	}

	function validationUpdate(){
		$this->load->model('mabastecer');
		$abastecimento = $this->mabastecer->getAbastecimento($_POST['ABA_Id'])->result();
		$_POST['VEI_Id'] = $abastecimento[0]->VEI_Id;
		$_POST['ABA_EstadoTanque'] = $abastecimento[0]->ABA_EstadoTanque;
		$abastecimento = $this->mabastecer->getOdometroUpdate($abastecimento[0]->VEI_Id)->result();
		return	($_POST['ABA_Odometro'] < $abastecimento[0]->ABA_Odometro) ? FALSE : TRUE;
	}

	function update()
	{
		if ($this->validationUpdate()) {
			if($this->prepararAbastecimento('update')){
				$this->load->model('mabastecer');
				
				$abastecido = $_POST['ABA_Litros'];
				$abastecidoR = str_replace(',', '.', $abastecido);
				$_POST['ABA_Litros'] = $abastecidoR;
				
				$abasteceUpdate = array(
					'ABA_Odometro' => $_POST['ABA_Odometro']
				);

				if ($this->mabastecer->editAbastecimento($_POST['ABA_Id'], $abasteceUpdate)) {
					$this->session->set_flashdata('sucesso', 'Abastecimento Atualizado.');
					redirect('abastece/listing');
				} else {
					$this->session->set_flashdata('erro', 'Abastecimento não Atualizado.');
					$this->edit($_POST['ABA_Id']);
				}
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro de Validação.');
			$this->edit($_POST['ABA_Id']);
		}
	}

	function listing($id = null)
	{
		$data['title'] = "Registro de Abastecimentos - SG Transportes";
		$data['headline'] = "Registros de Abastecimentos";
		$data['include'] = "abastece_listing";
		$this->load->model('mabastecer');
		$this->load->model('musuario');
		if($id){
			$qry = $this->mabastecer->listAbastecimento($id);
		}else{
			$qry = $this->mabastecer->listAbastecimentos();
		}
		
		$tmpl = array('table_open'  => '<table id="abasteceTable" class="table table-bordered table-hover table-sm text-center ">',
						'tbody_open' => '<tbody class="text-light">'
					);
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Data', 'Posto', 'Veículo - Placa', 'Motorista', 'Odometro', 'Litros', 'Autonomia', 'Percorrido', 'Valor',  'Ações');
		$table_row = array();
		$this->load->model('MModelo', '', true);

		foreach ($qry->result() as $abastecimento) {

			$table_row = null;
			$table_row[] = (mysql_to_pt($abastecimento->ABA_Data));
			$table_row[] = ($abastecimento->POS_RazaoSocial);

			$modelo = $this->MModelo->getModelo($abastecimento->VEI_Modelo)->result();
			$table_row[] = ($modelo[0]->MOD_Nome . " " . $abastecimento->VEI_Cilindrada . " - " . $abastecimento->VEI_Placa);

			$motorista = $this->musuario->getUsuario($abastecimento->USU_Id)->result();
			$table_row[] = $motorista[0]->USU_Nome;

			$table_row[] = ($abastecimento->ABA_Odometro . " Km");
			$table_row[] = (number_format($abastecimento->ABA_Litros, 2, ',', '.') . " L ");

			$table_row[] = ($abastecimento->ABA_Autonomia . " Km");

			if ($abastecimento->ABA_Percorrido == 0) {
				$table_row[] = ("Rodando");
			} else {

				$table_row[] = ($abastecimento->ABA_Percorrido . " Km");
			}

			$table_row[] = ('R$ ' . number_format($abastecimento->ABA_ValorAbastecido, 2, ',', '.'));

			if ($abastecimento->ABA_Status == "Aberto") {
				$table_row[] = (anchor('abastece/edit/' . $abastecimento->ABA_Id, '<i class="fas fa-pencil-alt"></i>') .
					" &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;" .
					anchor(
						'abastece/listing',
						'<i class="fas fa-trash-alt"></i>',
						"data-toggle='modal' data-target='#modalexcluir' title='Excluir' data-transfer=" . $abastecimento->VEI_Placa . " data-id=" . $abastecimento->ABA_Id
					));
			} else {
				$table_row[] = $abastecimento->ABA_Consumo;
			}

			$this->table->add_row($table_row);
		}
		$table = $this->table->generate();
		$data['data_table'] = $table;
		$this->load->view('template', $data);
	}

	function getOdometro($VER_Id)
	{
		$this->load->model('mabastecer');
		$this->load->model('mveiculo');
		$d = $this->mabastecer->getOdometro($VER_Id)->result();
		$car = $this->mveiculo->getVeiculo($VER_Id)->result();
		if ($d) {
			$outp = '';
			$outp .= '{"odometro":"' . $d[0]->ABA_Odometro . '",';
			$outp .= '"combustivel":"' .$car[0]->VEI_Combustivel. '",';
			$outp .= '"autonomia":"' .$d[0]->ABA_Autonomia. '"}';
			echo $outp;
		} else {
			$outp = '';
			$outp .= '{"odometro":"0",';
			$outp .= '"combustivel":"' .$car[0]->VEI_Combustivel. '",';
			$outp .= '"autonomia":"0"}';
			echo $outp;
		}
	}

	function delete()
	{
		$ABA_Id = $this->uri->segment(3);
		$this->load->model('mabastecer', '', true);
		$this->mabastecer->deleteAbastecimento($ABA_Id);
		$this->session->set_flashdata('sucesso', 'Abastecimento Deletado.');
		redirect('abastece/listing', 'refresh');
	}
}
