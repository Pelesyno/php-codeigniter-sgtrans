<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MEmpresa extends CI_Model
{

	function getEmpresa($EMP_Id)
	{
		return $this->db->get_where('empresa', array('EMP_Id' => $EMP_Id));
	}

	function updateEmpresa($EMP_Id, $data)
	{
		$this->db->where('EMP_Id', $EMP_Id);
		$this->db->update('empresa', $data);
	}
	function listEmpresa()
	{
		$this->db->order_by('EMP_Id', 'asc');
		return $this->db->get('empresa');
	}
}
