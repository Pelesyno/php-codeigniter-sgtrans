<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MPosto extends CI_Model
{

	function addPosto($data)
	{
		$this->db->insert('posto', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function listPosto()
	{
		$this->db->order_by('POS_RazaoSocial', 'asc');
		return $this->db->get('posto');
	}

	function getPosto($POS_Id)
	{
		return $this->db->get_where('posto', array('POS_Id' => $POS_Id));
	}

	function updatePosto($POS_Id, $data)
	{
		$this->db
			->where('POS_Id', $POS_Id)
			->update('posto', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deletePosto($POS_Id)
	{
		$this->db
			->where('POS_Id', $POS_Id)
			->delete('posto');
	}
}