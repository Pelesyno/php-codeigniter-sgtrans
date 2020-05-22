<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MOcorrencia extends CI_Model
{

	function addOcorrencia($data)
	{
		$this->db->insert('ocorrencia', $data);
		return $this->db->affected_rows() ? true : false;
	}

	function listOcorrencias()
	{
		return $this->db->join('usuario', 'usuario.USU_Id = ocorrencia.MOT_Id')
					->join('tipo_ocorrencia', 'tipo_ocorrencia.TOC_Id = ocorrencia.TOC_Id')
					->join('veiculo', 'veiculo.VEI_Id = ocorrencia.VEI_Id')
					->order_by('OCO_Data', 'DESC')
					->get('ocorrencia');
	}

	function listOcorrencia($VEI_Id)
	{
		return $this->db->join('usuario', 'usuario.USU_Id = ocorrencia.MOT_Id')
					->join('tipo_ocorrencia', 'tipo_ocorrencia.TOC_Id = ocorrencia.TOC_Id')
					->join('veiculo', 'veiculo.VEI_Id = ocorrencia.VEI_Id')
					->where('veiculo.VEI_Id', $VEI_Id)
					->order_by('OCO_Data', 'DESC')
					->get('ocorrencia');
	}

	function getOcorrencia($OCO_Id)
	{
		return $this->db->get_where('ocorrencia', array('OCO_Id' => $OCO_Id));
	}

	function updateOcorrencia($OCO_Id, $data)
	{
		$this->db
			->where('OCO_Id', $OCO_Id)
			->update('ocorrencia', $data);
		return $this->db->affected_rows() ? true : false;
	}

	function deleteOcorrencia($OCO_Id)
	{
		$this->db
			->where('OCO_Id', $OCO_Id)
			->delete('ocorrencia');
		return $this->db->affected_rows() ? true : false;
	}

	function verificarTipoOcorrencia($TOC_Id)
	{
		return $this->db->where('TOC_Id', $TOC_Id)
						->count_all_results('ocorrencia');
	}
}
