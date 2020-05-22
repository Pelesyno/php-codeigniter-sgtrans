<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MModelo extends CI_Model
{
	function addModelo($data)
	{
		$this->db->insert('modeloveiculo', $data);
		return $this->db->affected_rows() ? true : false;
	}

	function updateModelo($MOD_Id, $data)
	{
		$this->db
			->where('MOD_Id', $MOD_Id)
			->update('modeloveiculo', $data);
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

	function getModeloByIdMarca($MAR_Id)
	{
		return $this->db
			->where('MAR_Id', $MAR_Id)
			->order_by('MOD_Nome', 'asc')
			->get('modeloveiculo');
	}

	function listModelos()
	{
		return $this->db
			->join('marcaveiculo', 'marcaveiculo.MAR_Id = modeloveiculo.MAR_Id')
			->order_by('MOD_Nome', 'asc')
			->get('modeloveiculo');
	}

	public function selectModelos($MAR_Id)
	{
		$modelos = $this->getModeloByIdMarca($MAR_Id);

		$totalModelos = $modelos->num_rows();

		$options = "<option>Selecione o Modelo ({$totalModelos})</option>" . PHP_EOL;
		foreach ($modelos->result() as $modelo) {
			$options .= "<option value='{$modelo->MOD_Id}' >{$modelo->MOD_Nome}</option>" . PHP_EOL;
		}
		return $options;
	}
	function getModelo($MOD_Id)
	{
		return $this->db
			->where('MOD_Id', $MOD_Id)
			->join('marcaveiculo', 'marcaveiculo.MAR_Id = modeloveiculo.MAR_Id')
			->get('modeloveiculo');
	}

	function verificarMarca($MAR_Id)
	{
		return $this->db->where('MAR_Id', $MAR_Id)
						->count_all_results('modeloveiculo');
	}

	function deleteModelo($MOD_Id)
	{
		$this->db->where('MOD_Id', $MOD_Id);
		$this->db->delete('modeloveiculo');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}
}