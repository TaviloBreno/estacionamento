<?php
defined('BASEPATH') OR exit('Ação não permitida');

class Estacionar_model extends CI_Model
{
	public function get_all()
	{
		$this->db->select([
			'estacionar.*',
			'precificacoes.precificacao_id',
			'precificacoes.precificacao_categoria',
			'precificacoes.precificacao_valor_hora',
			'formas_pagamentos.forma_pagamento_id',
			'formas_pagamentos.forma_pagamento_nome',
		]);

		$this->db->join('precificacoes', 'precificacoes.precificacao_id = estacionar.estacionar_precificacao_id', 'LEFT');
		$this->db->join('formas_pagamentos', 'formas_pagamentos.forma_pagamento_id = estacionar.estacionar_forma_pagamento_id', 'LEFT');

		return $this->db->get('estacionar')->result();
	}

	public function get_by_id($estacionar_id = NULL)
	{
		if ($estacionar_id) {
			$this->db->select([
				'estacionar.*',
				'precificacoes.precificacao_id',
				'precificacoes.precificacao_categoria',
				'precificacoes.precificacao_valor_hora',
				'formas_pagamentos.forma_pagamento_id',
				'formas_pagamentos.forma_pagamento_nome',
			]);

			$this->db->join('precificacoes', 'precificacoes.precificacao_id = estacionar.estacionar_precificacao_id', 'LEFT');
			$this->db->join('formas_pagamentos', 'formas_pagamentos.forma_pagamento_id = estacionar.estacionar_forma_pagamento_id', 'LEFT');

			$this->db->where('estacionar.estacionar_id', $estacionar_id);
			$this->db->limit(1);

			return $this->db->get('estacionar')->row();
		}
	}

	public function get_numero_vagas($precificacao_id = NULL)
	{
		$this->db->select('precificacao_ativa');
		$this->db->select('precificacao_numero_vagas as vagas');

		$this->db->where('precificacao_id', $precificacao_id);
		return $this->db->get('precificacoes')->row();
	}
}
