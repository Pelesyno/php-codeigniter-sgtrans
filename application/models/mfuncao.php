<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MFuncao extends CI_Model
{

	function listFuncao()
	{
		return $this->db->get('funcao');
	}

	function getPerfil($id)
	{
		return $this->db->get_where('funcao', array('FUN_Id' => $id));
	}
}