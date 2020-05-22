<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mmanutencao extends CI_Model
{

	function addManutencao($data)
	{
		$this->db->insert('manutencao', $data);
		return $this->db->insert_id();
	}

	function updateManutencao($MAN_Id, $data)
	{
		$this->db->where('MAN_Id', $MAN_Id)
			->update('manutencao', $data);
		return ($this->db->affected_rows()) ? true : false;
	}

	function listManutencoes()
	{
		$this->db->order_by('MAN_DataHoraSaida', 'asc');
		return $this->db->get('manutencao');
	}

	function listManutencao($VEI_Id)
	{
		return $this->db->order_by('MAN_DataHoraSaida', 'asc')
			->where('VEI_Id', $VEI_Id)
			->get('manutencao');
	}

	function getManutencao($MAN_Id)
	{
		return $this->db->get_where('manutencao', array('MAN_Id' => $MAN_Id));
	}

	function getOdometro($VEI_Id)
	{
		return $this->db->where('VEI_Id', $VEI_Id)
			->order_by('MAN_Id', 'DESC')
			->get('manutencao', 1);
	}

	function verificarOficinas($OFI_Id)
	{
		return $this->db->where('OFI_Id', $OFI_Id)
			->count_all_results('manutencao');
	}

	function deleteManutencao($MAN_Id)
	{
		$this->db->where('MAN_Id', $MAN_Id);
		$this->db->delete('manutencao');
		return ($this->db->affected_rows()) ? true : false;
	}
}
