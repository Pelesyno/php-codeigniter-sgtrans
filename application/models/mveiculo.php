<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MVeiculo extends CI_Model
{

	function addVeiculo($data)
	{
		$this->db->insert('veiculo', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function listVeiculo()
	{
        $this->db->join('modeloveiculo', 'modeloveiculo.MOD_Id = veiculo.VEI_Modelo');
		$this->db->order_by('VEI_Placa', 'asc');
		return $this->db->get('veiculo');
	}

	function getVeiculo($VEI_Id)
	{
		return $this->db
			->join('modeloveiculo', 'modeloveiculo.MOD_Id = veiculo.VEI_Modelo')
			->where('VEI_Id', $VEI_Id)
			->get('veiculo');
	}

	function updateVeiculo($VEI_Id, $data)
	{
		$this->db
			->where('VEI_Id', $VEI_Id)
			->update('veiculo', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function deleteVeiculo($VEI_Id)
	{
		$this->db->where('VEI_Id', $VEI_Id);
		$this->db->delete('veiculo');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

	function verificarModelo($MOD_Id)
	{
		return $this->db->where('VEI_Modelo', $MOD_Id)
						->count_all_results('veiculo');
	}

	function countTipoVeiculo($VEI_Tipo)
	{
		return $this->db->where('VEI_Tipo', $VEI_Tipo)
					->count_all_results('veiculo');
	}

	function getTipoVeiculo($VEI_Tipo)
	{
		return $this->db->where('VEI_Tipo', $VEI_Tipo)
					->get('veiculo');
	}

	function informarEmplacamento($IPVA_Id){
		$this->db
				->set('IPVA_Emplacado', 1)
				->where('IPVA_Id', $IPVA_Id)
				->update('IPVA');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}
}
