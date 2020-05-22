<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notificacoes extends CI_Controller
{
    public function index()
    {
        $this->load->model('mNotificacao');
        $data['notification_count'] = $this->mNotificacao->get_notification_count();
        $data['notifications'] = $this->mNotificacao->getNotificacoesL()->result();

        echo json_encode($data);
    }
    function listing()
    {
        $this->load->model('mNotificacao');
        $qry = $this->mNotificacao->getNotificacoes();
        //$table = $this->table->generate($qry);
        $tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('Data Ocorrencia', 'Veículo - Placa', 'Ocorrencia');
        $table_row = array();
        $this->load->model('mveiculo');

        foreach ($qry->result() as $notificacao) {
            $table_row = null;
            $table_row[] = (mysql_to_pt($notificacao->NOT_Data));
            $placa = $this->mveiculo->getVeiculo($notificacao->NOT_Placa)->result();
            $table_row[] = $placa[0]->VEI_Placa;
            $table_row[] = $notificacao->NOT_Table;
            $this->table->add_row($table_row);
        }
        $table = $this->table->generate();
        $data['data_table'] = $table;
        $data['title'] = "Notificações - SG Transportes";
        $data['headline'] = "Notificações";
        $data['include'] = "notificacoes_listing";
        $this->load->view('template', $data);
    }

    public function habilitacao()
    {
        $this->load->model('mmotorista');
        $qry = $this->mmotorista->vencendoMotorista();
        //$table = $this->table->generate($qry);
        $tmpl = array('table_open'  => '<table id="abasteceTable" class="table table-striped table-bordered table-hover table-sm">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        if ($this->session->userdata('FUN_Id') == 2) {
            $this->table->set_heading('Venc. Habilitacao', 'Motorista', 'Editar Motorista');
        } else {
            $this->table->set_heading('Venc. Habilitacao', 'Motorista');
        }

        $table_row = array();

        foreach ($qry->result() as $notificacao) {
            $table_row = null;
            $table_row[] = (mysql_to_pt($notificacao->MOT_DataValidadeCnh));
            $table_row[] = $notificacao->USU_Nome;
            if ($this->session->userdata('FUN_Id') == 2) {
                $table_row[] = anchor('usuario/edit/' . $notificacao->USU_Id, '<i class="fas fa-user-edit"></i>');
            }
            $this->table->add_row($table_row);
        }
        $table = $this->table->generate();
        $data['data_table'] = $table;
        $data['title'] = "Notificações - SG Transportes";
        $data['headline'] = "Habilitação";
        $data['include'] = "notificacoes_listing";
        $this->load->view('template', $data);
    }

    public function ipva()
    {
        $this->load->model('mnotificacao');
        $qry = $this->mnotificacao->listIPVA();
        $tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        if ($this->session->userdata('FUN_Id') == 2) {
            $this->table->set_heading('Venc. IPVA', 'Veiculo', 'Ações');
        } else {
            $this->table->set_heading('Venc. IPVA', 'Veiculo');
        }

        $table_row = array();

        $mesnome[1] = "Janeiro";
        $mesnome[2] = "Fevereiro";
        $mesnome[3] = "Março";
        $mesnome[4] = "Abril";
        $mesnome[5] = "Maio";
        $mesnome[6] = "Junho";
        $mesnome[7] = "Julho";
        $mesnome[8] = "Agosto";
        $mesnome[9] = "Setembro";
        $mesnome[10] = "Outubro";
        $mesnome[11] = "Novembro";
        $mesnome[12] = "Dezembro";

        foreach ($qry->result() as $notificacao) {
            $table_row = null;
            $table_row[] = $mesnome[$notificacao->IPVA_Mes];
            $table_row[] = $notificacao->VEI_Placa;
            if ($this->session->userdata('FUN_Id') == 2) {
                $table_row[] = anchor('veiculo/informarEmplacamento/' . $notificacao->IPVA_Id, '<i class="fas fa-info"></i>nformar Emplacamento', 'class="btn btn-info"');
            }
            $this->table->add_row($table_row);
        }
        $table = $this->table->generate();
        $data['data_table'] = $table;
        $data['title'] = "Notificações - SG Transportes";
        $data['headline'] = "IPVA";
        $data['include'] = "notificacoes_listing";
        $this->load->view('template', $data);
    }
}
