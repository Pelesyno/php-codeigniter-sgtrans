<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mAbastecer extends CI_Model
{

	function addAbastecimento($data)
	{
		$this->db->set('ABA_ValorAbastecido', str_replace(',', '.', $data['ABA_ValorAbastecido']));
		$this->db->set('ABA_Odometro', $data['ABA_Odometro']);
		$this->db->set('ABA_Litros', str_replace(',', '.', $data['ABA_Litros']));
		$this->db->set('ABA_Data', $data['ABA_Data']);
		$this->db->set('ABA_Combustivel', $data['ABA_Combustivel']);
		$this->db->set('VEI_Id', $data['VEI_Id']);
		$this->db->set('POS_Id', $data['POS_Id']);
		$this->db->set('USU_Id', $data['USU_Id']);
		$this->db->set('ABA_Autonomia', $data['ABA_Autonomia']);
		$this->db->set('ABA_Status', $data['ABA_Status']);
		$this->db->set('ABA_EstadoTanque', $data['ABA_EstadoTanque']);
		$this->db->insert('abastece');

		return ($this->db->affected_rows()) ? true : false;
	}

	function editAbastecimento($ABA_Id, $data)
	{
		$this->db->where('ABA_Id', $ABA_Id)
			->update('abastece', $data);
		return ($this->db->affected_rows()) ? true : false;
	}

	function listAbastecimentos()
	{
		$this->db->join('veiculo', 'veiculo.VEI_Id = abastece.VEI_Id');
		$this->db->join('posto', 'posto.POS_Id = abastece.POS_Id');
		$this->db->order_by('ABA_Id', 'DESC');
		return $this->db->get('abastece');
	}

	function listAbastecimento($VEI_Id)
	{
		return $this->db->join('veiculo', 'veiculo.VEI_Id = abastece.VEI_Id')
						->join('posto', 'posto.POS_Id = abastece.POS_Id')
						->where('veiculo.VEI_Id', $VEI_Id)
						->order_by('ABA_Id', 'DESC')
						->get('abastece');
	}

	function getAbastecimento($ABA_Id)
	{
		return $this->db->get_where('abastece', array('ABA_Id' => $ABA_Id));
	}

	function getOdometro($VEI_Id)
	{
		return $this->db->where('VEI_Id', $VEI_Id)
			->order_by('ABA_Id', 'DESC')
			->get('abastece', 1);
	}

	function getOdometroUpdate($VEI_Id)
	{
		return $this->db->where('VEI_Id', $VEI_Id)
			->order_by('ABA_Id', 'DESC')
			->get('abastece', 1, 1);
	}

	function deleteAbastecimento($ABA_Id)
	{
		$this->db->where('ABA_Id', $ABA_Id);
		$this->db->delete('abastece');
	}

	function verificarAbastecimentos($POS_Id)
	{
		return $this->db->where('POS_Id', $POS_Id)
						->count_all_results('abastece');
	}
}
