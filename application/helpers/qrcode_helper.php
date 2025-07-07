<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper para geração de QR Code
 */

if (!function_exists('generate_qr_code')) {
    /**
     * Gera QR Code usando API externa (Google Charts API)
     * @param string $data - Dados para o QR Code
     * @param int $size - Tamanho do QR Code (padrão: 200)
     * @return string - URL do QR Code
     */
    function generate_qr_code($data, $size = 200) {
        $encoded_data = urlencode($data);
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encoded_data}";
    }
}

if (!function_exists('generate_qr_code_base64')) {
    /**
     * Gera QR Code em base64 para incorporar no HTML
     * @param string $data - Dados para o QR Code
     * @param int $size - Tamanho do QR Code (padrão: 200)
     * @return string - QR Code em base64
     */
    function generate_qr_code_base64($data, $size = 200) {
        $url = generate_qr_code($data, $size);
        
        // Tentar baixar a imagem e converter para base64
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'user_agent' => 'Sistema Estacionamento/1.0'
            ]
        ]);
        
        $image_data = @file_get_contents($url, false, $context);
        
        if ($image_data !== false) {
            return 'data:image/png;base64,' . base64_encode($image_data);
        }
        
        return null;
    }
}

if (!function_exists('format_ticket_code')) {
    /**
     * Formata código do ticket
     * @param int $id - ID do estacionamento
     * @return string - Código formatado
     */
    function format_ticket_code($id) {
        return 'EST' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('generate_ticket_qr_data')) {
    /**
     * Gera dados para QR Code do ticket
     * @param object $ticket - Dados do ticket
     * @return string - Dados formatados para QR Code
     */
    function generate_ticket_qr_data($ticket) {
        $codigo = format_ticket_code($ticket->estacionar_id);
        $placa = strtoupper($ticket->estacionar_placa_veiculo);
        $entrada = date('Y-m-d H:i:s', strtotime($ticket->estacionar_data_entrada));
        $vaga = $ticket->estacionar_numero_vaga;
        
        return "{$codigo}|{$placa}|{$entrada}|VAGA:{$vaga}";
    }
}
