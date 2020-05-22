<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MMotorista extends CI_Model
{

	function addMotorista($data)
	{
		$this->db->insert('motorista', $data);
		return $this->db->affected_rows() ? true : false;
	}
	function updateMotorista($id, $data)
	{
		$this->db->where('USU_Id', $id);
		$this->db->update('motorista', $data);
		return $this->db->affected_rows() ? true : false;
	}
	function getMotorista($id)
	{
		return $this->db->get_where('motorista', array('USU_Id' => $id));
	}
	function listMotorista()
	{
		$this->db->order_by('USU_Id', 'asc');
		return $this->db->get('motorista');
	}

	function vencendoMotorista()
	{
		$vencimento = date("Y-m-d",strtotime("+30 day",strtotime("now")));
		return $this->db
					->join('usuario', 'usuario.USU_Id = motorista.USU_Id')
					->where('MOT_DataValidadeCnh < ', $vencimento)
					->order_by('MOT_DataValidadeCnh', 'asc')
					->get('motorista');
	}
}