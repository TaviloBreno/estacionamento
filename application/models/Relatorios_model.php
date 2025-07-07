<?php
defined('BASEPATH') OR exit('Ação não permitida');

class Relatorios_model extends CI_Model
{
    public function get_fluxo_diario($dias = 7)
    {
        $this->db->select("DATE(estacionar_data_entrada) as data, COUNT(*) as entradas");
        $this->db->where("estacionar_data_entrada >=", date('Y-m-d', strtotime("-{$dias} days")));
        $this->db->group_by("DATE(estacionar_data_entrada)");
        $this->db->order_by("data", "ASC");
        
        return $this->db->get('estacionar')->result();
    }

    public function get_ocupacao_por_categoria()
    {
        $this->db->select("p.precificacao_categoria as categoria, COUNT(*) as ocupadas");
        $this->db->from('estacionar e');
        $this->db->join('precificacoes p', 'p.precificacao_id = e.estacionar_precificacao_id');
        $this->db->where('e.estacionar_status', 0); // Ocupadas
        $this->db->group_by("p.precificacao_categoria");
        
        return $this->db->get()->result();
    }

    public function get_faturamento_mensal($meses = 6)
    {
        $this->db->select("DATE_FORMAT(estacionar_data_entrada, '%Y-%m') as mes, SUM(estacionar_valor_final) as faturamento");
        $this->db->where("estacionar_data_entrada >=", date('Y-m-01', strtotime("-{$meses} months")));
        $this->db->where('estacionar_status', 1); // Finalizados
        $this->db->group_by("DATE_FORMAT(estacionar_data_entrada, '%Y-%m')");
        $this->db->order_by("mes", "ASC");
        
        return $this->db->get('estacionar')->result();
    }

    public function get_clientes_por_dia($dias = 30)
    {
        $this->db->select("DATE(estacionar_data_entrada) as data, COUNT(DISTINCT estacionar_cliente_nome) as clientes_unicos");
        $this->db->where("estacionar_data_entrada >=", date('Y-m-d', strtotime("-{$dias} days")));
        $this->db->group_by("DATE(estacionar_data_entrada)");
        $this->db->order_by("data", "ASC");
        
        return $this->db->get('estacionar')->result();
    }

    public function get_total_vagas()
    {
        $this->db->select_sum('precificacao_numero_vagas');
        $this->db->where('precificacao_ativa', 1);
        $result = $this->db->get('precificacoes')->row();
        
        return $result->precificacao_numero_vagas ? $result->precificacao_numero_vagas : 0;
    }

    public function get_vagas_ocupadas()
    {
        $this->db->where('estacionar_status', 0);
        return $this->db->count_all_results('estacionar');
    }

    public function get_faturamento_hoje()
    {
        $this->db->select_sum('estacionar_valor_final');
        $this->db->where('DATE(estacionar_data_entrada)', date('Y-m-d'));
        $this->db->where('estacionar_status', 1);
        $result = $this->db->get('estacionar')->row();
        
        return $result->estacionar_valor_final ? $result->estacionar_valor_final : 0;
    }

    public function get_movimentacoes_hoje()
    {
        $this->db->where('DATE(estacionar_data_entrada)', date('Y-m-d'));
        return $this->db->count_all_results('estacionar');
    }

    public function get_taxa_ocupacao()
    {
        $total_vagas = $this->get_total_vagas();
        $vagas_ocupadas = $this->get_vagas_ocupadas();
        
        if($total_vagas > 0) {
            return round(($vagas_ocupadas / $total_vagas) * 100, 2);
        }
        
        return 0;
    }

    public function get_movimentacoes_periodo($data_inicio, $data_fim)
    {
        $this->db->select([
            'estacionar.*',
            'precificacoes.precificacao_categoria',
            'formas_pagamentos.forma_pagamento_nome'
        ]);
        $this->db->join('precificacoes', 'precificacoes.precificacao_id = estacionar.estacionar_precificacao_id', 'LEFT');
        $this->db->join('formas_pagamentos', 'formas_pagamentos.forma_pagamento_id = estacionar.estacionar_forma_pagamento_id', 'LEFT');
        $this->db->where('DATE(estacionar_data_entrada) >=', $data_inicio);
        $this->db->where('DATE(estacionar_data_entrada) <=', $data_fim);
        $this->db->order_by('estacionar_data_entrada', 'DESC');
        
        return $this->db->get('estacionar')->result();
    }

    public function get_faturamento_periodo($data_inicio, $data_fim)
    {
        $this->db->select_sum('estacionar_valor_final');
        $this->db->where('DATE(estacionar_data_entrada) >=', $data_inicio);
        $this->db->where('DATE(estacionar_data_entrada) <=', $data_fim);
        $this->db->where('estacionar_status', 1);
        $result = $this->db->get('estacionar')->row();
        
        return $result->estacionar_valor_final ? $result->estacionar_valor_final : 0;
    }

    public function get_faturamento_por_categoria($data_inicio, $data_fim)
    {
        $this->db->select("p.precificacao_categoria as categoria, SUM(e.estacionar_valor_final) as faturamento");
        $this->db->from('estacionar e');
        $this->db->join('precificacoes p', 'p.precificacao_id = e.estacionar_precificacao_id');
        $this->db->where('DATE(e.estacionar_data_entrada) >=', $data_inicio);
        $this->db->where('DATE(e.estacionar_data_entrada) <=', $data_fim);
        $this->db->where('e.estacionar_status', 1);
        $this->db->group_by("p.precificacao_categoria");
        
        return $this->db->get()->result();
    }

    public function get_estatisticas_gerais()
    {
        $stats = array();
        
        // Total de clientes únicos
        $this->db->select('COUNT(DISTINCT estacionar_cliente_nome) as total_clientes');
        $result = $this->db->get('estacionar')->row();
        $stats['total_clientes'] = $result->total_clientes;
        
        // Tempo médio de permanência
        $this->db->select('AVG(TIMESTAMPDIFF(MINUTE, estacionar_data_entrada, estacionar_data_saida)) as tempo_medio');
        $this->db->where('estacionar_status', 1);
        $this->db->where('estacionar_data_saida IS NOT NULL');
        $result = $this->db->get('estacionar')->row();
        $stats['tempo_medio_permanencia'] = $result->tempo_medio ? round($result->tempo_medio) : 0;
        
        // Horário de pico
        $this->db->select('HOUR(estacionar_data_entrada) as hora, COUNT(*) as total');
        $this->db->where('DATE(estacionar_data_entrada)', date('Y-m-d'));
        $this->db->group_by('HOUR(estacionar_data_entrada)');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('estacionar')->row();
        $stats['horario_pico'] = $result ? $result->hora . ':00' : 'N/A';
        
        return $stats;
    }

    public function get_comparativo_mensal()
    {
        $mes_atual = date('Y-m');
        $mes_anterior = date('Y-m', strtotime('-1 month'));
        
        // Faturamento mês atual
        $this->db->select_sum('estacionar_valor_final');
        $this->db->where('DATE_FORMAT(estacionar_data_entrada, "%Y-%m")', $mes_atual);
        $this->db->where('estacionar_status', 1);
        $result_atual = $this->db->get('estacionar')->row();
        
        // Faturamento mês anterior
        $this->db->select_sum('estacionar_valor_final');
        $this->db->where('DATE_FORMAT(estacionar_data_entrada, "%Y-%m")', $mes_anterior);
        $this->db->where('estacionar_status', 1);
        $result_anterior = $this->db->get('estacionar')->row();
        
        $faturamento_atual = $result_atual->estacionar_valor_final ? $result_atual->estacionar_valor_final : 0;
        $faturamento_anterior = $result_anterior->estacionar_valor_final ? $result_anterior->estacionar_valor_final : 0;
        
        $percentual = 0;
        if($faturamento_anterior > 0) {
            $percentual = (($faturamento_atual - $faturamento_anterior) / $faturamento_anterior) * 100;
        }
        
        return array(
            'atual' => $faturamento_atual,
            'anterior' => $faturamento_anterior,
            'percentual' => round($percentual, 2)
        );
    }

    public function get_movimentacoes_por_categoria($data_inicio, $data_fim)
    {
        $this->db->select("p.precificacao_categoria as categoria, COUNT(*) as movimentacoes, SUM(e.estacionar_valor_final) as faturamento");
        $this->db->from('estacionar e');
        $this->db->join('precificacoes p', 'p.precificacao_id = e.estacionar_precificacao_id');
        $this->db->where('DATE(e.estacionar_data_entrada) >=', $data_inicio);
        $this->db->where('DATE(e.estacionar_data_entrada) <=', $data_fim);
        $this->db->group_by("p.precificacao_categoria");
        
        return $this->db->get()->result();
    }
}
