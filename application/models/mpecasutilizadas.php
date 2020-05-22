<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mpecasutilizadas extends CI_Model
{

	function addPecaUtilizada($data)
	{
		$this->db->insert('peca_utilizada', $data);
		return ($this->db->affected_rows()) ? TRUE : FALSE;
	}

	function getPecasUtilizadas($MAN_Id)
	{
		return $this->db->where('MAN_Id', $MAN_Id)
					->join('pecas', 'pecas.PEC_Id = peca_utilizada.PEC_Id')
					->get('peca_utilizada');
	}

	function verificarPecasUtilizadas($PEC_Id)
	{
		return $this->db->where('PEC_Id', $PEC_Id)
						->count_all_results('peca_utilizada');
	}

	function deletarPecasUtilizadas($MAN_Id)
	{
		$this->db->where('MAN_Id', $MAN_Id)
				->delete('peca_utilizada');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}
}