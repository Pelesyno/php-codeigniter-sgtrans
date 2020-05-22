<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mservicos extends CI_Model
{

	function addServico($data)
	{
		$this->db->insert('servicos', $data);
		return ($this->db->affected_rows()) ? TRUE : FALSE;
	}

	function getServico($SER_Id)
	{
		return $this->db->where('SER_Id', $SER_Id)
					->get('servicos');
	}

	function updateServico($SER_Id, $data)
	{
		$this->db->where('SER_Id', $SER_Id)
				->update('servicos', $data);
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

	function listServicos()
	{
		$this->db->order_by('SER_Nome', 'asc');
		return $this->db->get('servicos');
	}

	function deleteServico($SER_Id)
	{
		$this->db->where('SER_Id', $SER_Id)
				->delete('servicos');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

}