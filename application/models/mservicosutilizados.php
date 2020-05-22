<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mservicosutilizados extends CI_Model
{

	function addServicoUtilizado($data)
	{
		$this->db->insert('servico_utilizado', $data);
		return ($this->db->affected_rows()) ? TRUE : FALSE;
	}

	function getServicosUtilizados($MAN_Id)
	{
		return $this->db->where('MAN_Id', $MAN_Id)
					->join('servicos', 'servicos.SER_Id = servico_utilizado.SER_Id')
					->get('servico_utilizado');
	}

	function verificarServicosUtilizados($SER_Id)
	{
		return $this->db->where('SER_Id', $SER_Id)
						->count_all_results('servico_utilizado');
	}

	function deletarServicosUtilizados($MAN_Id)
	{
		$this->db->where('MAN_Id', $MAN_Id)
				->delete('servico_utilizado');
		return $this->db->affected_rows() ? TRUE : FALSE;
	}
}