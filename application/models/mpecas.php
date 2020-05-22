<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mpecas extends CI_Model
{

	function addPeca($data)
	{
		$this->db->insert('pecas', $data);
		return ($this->db->affected_rows()) ? TRUE : FALSE;
	}

	function getPeca($PEC_Id)
	{
		return $this->db->where('PEC_Id', $PEC_Id)
						->get('pecas');
	}

	function editPeca($PEC_Id, $data)
	{
		$this->db->where('PEC_Id', $PEC_Id)
				->update('pecas', $data);
		return ($this->db->affected_rows()) ? TRUE : FALSE;
	}

	function listPecas()
	{
		$this->db->order_by('PEC_Nome', 'asc');
		return $this->db->get('pecas');
	}

	function deletePeca($PEC_Id)
	{
		$this->db->where('PEC_Id', $PEC_Id);
		$this->db->delete('pecas');
		return ($this->db->affected_rows()) ? TRUE : FALSE;
	}
}