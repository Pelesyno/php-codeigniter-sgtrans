<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MSolicitante extends CI_Model
{

	function addSolicitante($data)
	{
		$this->db->insert('solicitante', $data);
		return $this->db->affected_rows() ? true : false;
	}
	function updateSolicitante($id, $data)
	{
		$this->db->where('USU_Id', $id);
		$this->db->update('solicitante', $data);
		return $this->db->affected_rows() ? true : false;
	}
	function getSolicitante($id)
	{
		return $this->db->get_where('solicitante', array('USU_Id' => $id));
	}
}