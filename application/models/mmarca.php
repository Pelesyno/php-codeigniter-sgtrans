<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MMarca extends CI_Model
{
	function addMarca($data)
	{
		$this->db->insert('marcaveiculo', $data);
		return $this->db->affected_rows() ? true : false;
	}

	function getMarca($MAR_Id)
	{
		return	$this->db->where('MAR_Id', $MAR_Id)
					->get('marcaveiculo');
	}

	function updateMarca($MAR_Id, $data)
	{
		$this->db
			->where('MAR_Id', $MAR_Id)
			->update('marcaveiculo', $data);
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

	function listMarcas()
	{
		return $this->db
			->order_by('MAR_Nome', 'asc')
			->get('marcaveiculo');
	}

	function deleteMarca($MAR_Id)
	{
		$this->db->where('MAR_Id', $MAR_Id);
		$this->db->delete('marcaveiculo');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}
}