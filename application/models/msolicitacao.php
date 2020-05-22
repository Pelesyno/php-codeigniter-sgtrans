<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MSolicitacao extends CI_Model
{

	function addSolicitacao($data)
	{
		$this->db->insert('solicitacao', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function listSolicitacoes()
	{
		return $this->db
					->get('solicitacao');
	}

	function listSolicitacoesMotorista($SOL_MOT_Id)
	{
		return $this->db
					->where('SOL_MOT_Id', $SOL_MOT_Id)
					->get('solicitacao');
	}

	function listSolicitacoesSolicitante($SOL_USE_Id)
	{
		return $this->db
					->where('SOL_USE_Id', $SOL_USE_Id)
					->get('solicitacao');
	}

	function getSolicitacoes($SOL_Id)
	{
		return $this->db
					->join('tipo_veiculo', 'solicitacao.SOL_Tipo_Veiculo = tipo_veiculo.TVE_Id')
					->join('usuario', 'solicitacao.SOL_USE_Id = usuario.USU_Id')
					->where('SOL_Id', $SOL_Id)
					->get('solicitacao');
	}

	function listHorasAtendimento()
	{
		return $this->db
					->select('Hora')
					->get('horario_atendimentos');
	}
	
	function listSolicitacoesData($VEI_Tipo, $data)
	{
		$solicitacoes = $this->db
					->where('SOL_Data', $data)
					->where('SOL_Tipo_Veiculo', $VEI_Tipo)
					->get('solicitacao');
		return $solicitacoes->num_rows();		
	}
	
	function listSolicitacoesHora($VEI_Tipo, $data, $hora)
	{
		$solicitacoes = $this->db
					->where('SOL_Data', $data)
					->where('SOL_Hora', $hora)
					->where('SOL_Tipo_Veiculo', $VEI_Tipo)
					->get('solicitacao');
		return $solicitacoes->num_rows();		
    }

    function updateSolicitacao($SOL_Id, $data)
	{
		$this->db
			->where('SOL_Id', $SOL_Id)
			->update('solicitacao', $data);
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

    function deleteSolicitacao($SOL_Id)
	{
		$this->db->where('SOL_Id', $SOL_Id)
				->delete('solicitacao');

		return $this->db->affected_rows() ? TRUE : FALSE;
	}

	function rejeitarSolicitacao($SOL_Id){
		$this->db
				->set('SOL_Status', 2)
				->where('SOL_Id', $SOL_Id)
				->update('solicitacao');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}
}