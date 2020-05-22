<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Marca extends CI_Controller
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
        $data['title'] = "Cadastro de Marca - SG Transportes";
        $data['headline'] = "Cadastro de Marca";
        $data['include'] = "marca_add_edit";
        $this->load->view('template', $data);
    }

    function validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<small class="error text-danger">', '</small>');
        if (isset($_POST['MAR_Id'])) {
            $this->form_validation->set_rules('MAR_Id', 'ID', 'required');
            $this->form_validation->set_rules('MAR_Nome', 'Nome da Marca', 'trim|required|edit_unique[marcaveiculo.MAR_Nome.' . $_POST['MAR_Id'] . ']');
        } else {
            $this->form_validation->set_rules('MAR_Nome', 'Nome da Marca', 'trim|required|is_unique[marcaveiculo.MAR_Nome]');
        }

        return $this->form_validation->run();
    }

    function create()
    {
        if ($this->validation()) {
            $this->load->model('MMarca');
            if ($this->MMarca->addMarca($_POST)) {
                $this->session->set_flashdata('sucesso', 'Marca Cadastrada.');
                redirect('marca/listing');
            } else {
                $this->session->set_flashdata('erro', 'Marca não cadastrado.');
                $this->add();
            }
        } else {
            $this->session->set_flashdata('erro', 'Erro de Validação.');
            $this->add();
        }
    }

    function edit()
    {
        $MAR_Id = $this->uri->segment(3);
        $this->load->model('MMarca', '', true);
        $data['marca'] = $this->MMarca->getMarca($MAR_Id)->result();
        $data['title'] = "Modificar Marca - SG Transportes";
        $data['headline'] = "Edição de Marca";
        $data['include'] = "marca_add_edit";
        $data['update'] = true;
        $this->load->view('template', $data);
    }

    function update()
    {
        if ($this->validation()) {
            $this->load->model('MMarca');
            if ($this->MMarca->updateMarca($_POST['MAR_Id'], $_POST)) {
                $this->session->set_flashdata('sucesso', 'Marca Atualizada.');
                redirect('marca/listing');
            } else {
                $this->session->set_flashdata('erro', 'Marca não Atualizada.');
                $this->edit();
            }
        } else {
            $this->session->set_flashdata('erro', 'Erro de Validação.');
            $this->edit();
        }
    }

    function listing()
    {
        $this->load->model('MMarca');
        $this->load->model('MModelo');
        $qry = $this->MMarca->listMarcas();
        $table = $this->table->generate($qry);
        $tmpl = array('table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover table-sm">');
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('Codigo', 'Marca', 'Ações');
        $table_row = array();

        foreach ($qry->result() as $marca) {
            $table_row = null;
            $table_row[] = $marca->MAR_Id;
            $table_row[] = $marca->MAR_Nome;
            if ($this->MModelo->verificarMarca($marca->MAR_Id)) {
                $table_row[] = (anchor('marca/edit/' . $marca->MAR_Id, '<i class="fas fa-pencil-alt"></i>')) . '&nbsp;&nbsp;|&nbsp;&nbsp; <i class="text-danger fas fa-minus-circle"></i>';
            } else {
                $table_row[] =  anchor('marca/edit/' . $marca->MAR_Id, '<i class="fas fa-pencil-alt"></i>') . '&nbsp;&nbsp;|&nbsp;&nbsp;' .  anchor(
                    'marca/delete',
                    '<i class="fas fa-trash-alt"></i>',
                    'data-toggle="modal" data-target="#modalexcluir" data-transfer="' . $marca->MAR_Nome . '" data-id="' . $marca->MAR_Id . '"'
                );
            }

            $this->table->add_row($table_row);
        }
        $table = $this->table->generate();

        $data['title'] = "Listar Marcas - SG Transportes";
        $data['headline'] = "Listar Marcas";
        $data['include'] = "marca_listing";
        $data['data_table'] = $table;
        $this->load->view('template', $data);
    }

    function delete()
    {
        $MAR_Id = $this->uri->segment(3);
        $this->load->model('MModelo');
        if ($this->MModelo->verificarMarca($MAR_Id)) {
            $this->session->set_flashdata('erro', 'Não foi possivel Excluir Modelo Vinculado.');
            $this->listing();
        } else {
            $this->load->model('mmarca');
            if ($this->mmarca->deleteMarca($MAR_Id)) {
                $this->session->set_flashdata('sucesso', 'Marca Deletada com Sucesso.');
                $this->listing();
            }
        }
    }
}
