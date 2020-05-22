<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MLogin extends CI_Model
{

    function validate()
    {
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));

        $this->db->where('USU_Login', $username);
        $this->db->where('USU_Password', $password);

        $this->db->join('funcao', 'funcao.FUN_Id = usuario.FUN_Id');
        //$this->db->join('setor', 'setor.id_setor = usuario.setor');

        $query = $this->db->get('usuario');
        if ($query->num_rows == 1) {
                $row = $query->row();
                $data = array(
                    'USU_Id' => $row->USU_Id,
                    'USU_Login' => $row->USU_Login,
                    'USU_Nome' => $row->USU_Nome,
                    'FUN_Nome' => $row->FUN_Nome,
                    'FUN_Id' => $row->FUN_Id,
                    'validated' => true
                );
                $this->session->set_userdata($data);
                return true;
            }
        return false;
    }
}