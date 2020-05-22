<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MOficina extends CI_Model
{

	function addOficina($data)
	{
		$this->db->insert('oficina', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function listOficina()
	{
		$this->db->order_by('OFI_RazaoSocial', 'asc');
		return $this->db->get('oficina');
	}

	function getOficina($OFI_Id)
	{
		return $this->db->get_where('oficina', array('OFI_Id' => $OFI_Id));
	}

	function updateOficina($OFI_Id, $data)
	{
		$this->db
			->where('OFI_Id', $OFI_Id)
			->update('oficina', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteOficina($OFI_Id)
	{
		$this->db
			->where('OFI_Id', $OFI_Id)
			->delete('oficina');
	}
}