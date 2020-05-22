<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MUsuario extends CI_Model
{

	function addUsuario($data)
	{
		$this->db->insert('usuario', $data);
		return $this->db->insert_id();
	}

	function listUsuario()
	{
		$this->db->join('funcao', 'funcao.FUN_Id = usuario.FUN_Id');
		$this->db->where('USU_Ativo = "Ativo"');
		$this->db->order_by('USU_Nome', 'asc');
		return $this->db->get('usuario');
	}

	function listUsuarioAdm()
	{
		$this->db->join('funcao', 'funcao.FUN_Id = usuario.FUN_Id');
		$this->db->where('usuario.FUN_Id = "1"');
		$this->db->order_by('USU_Nome', 'asc');
		return $this->db->get('usuario');
	}

	function listUsuarioInativo()
	{
		$this->db->join('funcao', 'funcao.FUN_Id = usuario.FUN_Id');
		$this->db->where('USU_Ativo = "Inativo"');
		$this->db->order_by('USU_Login', 'asc');
		return $this->db->get('usuario');
	}

	function getUsuario($id)
	{
		return $this->db->get_where('usuario', array('USU_Id' => $id));
	}

	function updateUsuario($id, $data)
	{
		$this->db->where('USU_Id', $id);
		$this->db->update('usuario', $data);
	}

	function inativarUsuario($id)
	{
		$data = array('USU_Ativo' => 'Inativo');
		$this->db->where('USU_Id', $id);
		$this->db->update('usuario', $data);
	}

	function ativarUsuario($id)
	{
		$data = array('USU_Ativo' => 'Ativo');
		$this->db->where('USU_Id', $id);
		$this->db->update('usuario', $data);
	}

	function getUsuarioFuncao($FUN_Id, $data)
	{
		return $this->db
					->join('motorista', 'motorista.USU_Id = usuario.USU_Id')
					->where('MOT_DataValidadeCnh >', $data )
					->where('FUN_Id', $FUN_Id)
					->get('usuario');
	}
}