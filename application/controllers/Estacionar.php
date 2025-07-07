<?php
defined('BASEPATH') OR exit('Ação não permitida');

class Estacionar extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('info', 'Sua sessão expirou!');
			redirect('login');
		}

		$this->load->model('estacionar_model');
	}

	public function index()
	{
		$data = array(
			'titulo' => 'Tickets de Estacionamento',
			'subtitulo' => 'Listando todos os tickets de estacionamento',
			'icone_view' => 'ik ik-truck',
			'styles' => array(
				'datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'../dist/css/estacionar.css'
			),
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'datatables.net/js/estacionamento.js',
				'datatables.net/js/flashcards.js',
			),
			'estacionados' => $this->estacionar_model->get_all(),
			'numero_vagas_pequeno' => $this->estacionar_model->get_numero_vagas(1),
			'vagas_ocupadas_pequeno' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1)),
			'numero_vagas_medio' => $this->estacionar_model->get_numero_vagas(2),
			'vagas_ocupadas_medio' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 2)),
			'numero_vagas_grande' => $this->estacionar_model->get_numero_vagas(3),
			'vagas_ocupadas_grande' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 3)),
			'numero_vagas_moto' => $this->estacionar_model->get_numero_vagas(4),
			'vagas_ocupadas_moto' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 4)),
			'numero_vagas_caminhao' => $this->estacionar_model->get_numero_vagas(5),
			'vagas_ocupadas_caminhao' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 5)),
			'numero_vagas_bicicleta' => $this->estacionar_model->get_numero_vagas(6),
			'vagas_ocupadas_bicicleta' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 6)),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('estacionar/index');
		$this->load->view('layout/footer');
	}

	public function core($estacionar_id = null)
	{
		if(!$estacionar_id){
			// Cadastrando
			$this->form_validation->set_rules('estacionar_precificacao_id', 'Categoria', 'trim|required');
			$this->form_validation->set_rules('estacionar_numero_vaga', 'Número da vaga', 'required|integer|greater_than[0]|callback_check_vaga_ocupada|callback_check_range_vagas_categoria');
			$this->form_validation->set_rules('estacionar_placa_veiculo', 'Placa do veículo', 'trim|required|exact_length[8]|callback_check_placa_status_aberta');
			$this->form_validation->set_rules('estacionar_marca_veiculo', 'Marca do veículo', 'trim|required|min_length[2]|max_length[30]');
			$this->form_validation->set_rules('estacionar_modelo_veiculo', 'Modelo do veículo', 'trim|required|min_length[2]|max_length[20]');

			if($this->form_validation->run()) {
				$data = elements(
					array(
						'estacionar_valor_hora',
						'estacionar_numero_vaga',
						'estacionar_placa_veiculo',
						'estacionar_marca_veiculo',
						'estacionar_modelo_veiculo',
					), $this->input->post()
				);

				$data['estacionar_precificacao_id'] = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));
				$data['estacionar_status'] = 0;

				$data = html_escape($data);

				$this->core_model->insert('estacionar', $data, true);

				$estacionar_id = $this->session->userdata('last_id');

				// Redirecionar para página de sucesso
				redirect($this->router->fetch_class().'/sucesso/'.$estacionar_id);
			}else{
				$data = array(
					'titulo' => 'Cadastrar Ticket de Estacionamento',
					'subtitulo' => 'Cadastrando novo ticket de estacionamento',
					'valor_btn' => 'Cadastrar Ticket',
					'icone_view' => 'ik ik-truck',
					'scripts' => array(
						'mask/jquery.mask.min.js',
						'mask/estacionar.js',
						'plugins/datatables.net/js/jquery.dataTables.min.js',
						'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
						'plugins/datatables.net/js/estacionamento.js',
						'plugins/datatables.net/js/flashcards.js',
						'js/estacionar/estacionar.js'
					),
					'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
				);

				$this->load->view('layout/header', $data);
				$this->load->view('estacionar/core');
				$this->load->view('layout/footer');
			}
		}else{
			if(!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
				$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado para encerramento!');
				redirect('estacionar');
			}else{
				$estacionar_tempo_decorrido = str_replace('.', '', $this->input->post('estacionar_tempo_decorrido'));

				if($estacionar_tempo_decorrido > '015'){
					$this->form_validation->set_rules('estacionar_forma_pagamento_id', 'Forma de pagamento', 'trim|required');
				}else{
					$this->form_validation->set_rules('estacionar_valor_devido', 'Valor devido', 'trim');
				}

				if($this->form_validation->run()) {
					$data = elements(
						array(
							'estacionar_valor_devido',
							'estacionar_forma_pagamento_id',
							'estacionar_tempo_decorrido',
						), $this->input->post()
					);

					if ($data['estacionar_tempo_decorrido'] <= '015') {
						$data['estacionar_forma_pagamento_id'] = 5;
					}

					$data['estacionar_data_saida'] = date('Y-m-d H:i:s');
					$data['estacionar_status'] = 1;

					$data = html_escape($data);

					$this->core_model->update('estacionar', $data, array('estacionar_id' => $estacionar_id));
					redirect($this->router->fetch_class() . '/acoes/' . $estacionar_id);

				}else{

					$data = array(
						'titulo' => 'Encerrar Ticket de Estacionamento',
						'subtitulo' => 'Encerrando ticket de estacionamento',
						'texto_modal' => 'Deseja realmente encerrar o ticket de estacionamento?',
						'valor_btn' => 'Encerrar Ticket',
						'icone_view' => 'ik ik-truck',
						'scripts' => array(
							'mask/jquery.mask.min.js',
							'mask/estacionar.js',
							'plugins/datatables.net/js/jquery.dataTables.min.js',
							'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
							'plugins/datatables.net/js/estacionamento.js',
							'plugins/datatables.net/js/flashcards.js',
							'js/estacionar/estacionar.js'
						),
						'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
						'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
						'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
					);

					$this->load->view('layout/header', $data);
					$this->load->view('estacionar/core');
					$this->load->view('layout/footer');

				}
			}
		}
	}

	public function sucesso($estacionar_id = null)
	{
		if(!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
			$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado!');
			redirect('estacionar');
		}

		$data = array(
			'titulo' => 'Ticket Gerado com Sucesso',
			'subtitulo' => 'Veículo estacionado com sucesso',
			'icone_view' => 'ik ik-check-circle',
			'estacionado' => $this->estacionar_model->get_by_id($estacionar_id),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('estacionar/sucesso', $data);
		$this->load->view('layout/footer');
	}

	public function check_range_vagas_categoria($numero_vaga) {

		$precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));

		if ($precificacao_id) {

			$precificacao = $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id));

			if ($precificacao->precificacao_numero_vagas < $numero_vaga) {

				$this->form_validation->set_message('check_range_vagas_categoria', 'A vaga deve estar entre 1 e ' . $precificacao->precificacao_numero_vagas);

				return FALSE;
			} else {

				return TRUE;
			}
		} else {
			$this->form_validation->set_message('check_range_vagas_categoria', 'Escolha uma categoria');
			return FALSE;
		}
	}

	public function check_vaga_ocupada($estacionar_numero_vaga) {

		$estacionar_precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));

		if ($this->core_model->get_by_id('estacionar', array('estacionar_numero_vaga' => $estacionar_numero_vaga, 'estacionar_status' => 0, 'estacionar_precificacao_id' => $estacionar_precificacao_id))) {

			$this->form_validation->set_message('check_vaga_ocupada', 'Essa vaga já está ocupada para essa categoria');

			return FALSE;
		} else {

			return TRUE;
		}
	}

	public function check_placa_status_aberta($estacionar_placa_veiculo) {

		$estacionar_placa_veiculo = strtoupper($estacionar_placa_veiculo);

		if ($this->core_model->get_by_id('estacionar', array('estacionar_placa_veiculo' => $estacionar_placa_veiculo, 'estacionar_status' => 0))) {

			$this->form_validation->set_message('check_placa_status_aberta', 'Existe uma ordem aberta para essa placa');

			return FALSE;
		} else {

			return TRUE;
		}
	}

	public function del($estacionar_id = null)
	{
		if(!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
			$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado para exclusão!');
			redirect('estacionar');
		}

		if($this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id, 'estacionar_status' => 0))){
			$this->session->set_flashdata('error', 'Ticket de estacionamento não pode ser excluído, pois está em aberto!');
			redirect('estacionar');
		}

		$this->core_model->delete('estacionar', array('estacionar_id' => $estacionar_id));
	}

	public function acoes($estacionar_id = null)
	{
		if(!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
			$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado para ações!');
			redirect('estacionar');
		}else{
			$data = array(
				'titulo' => 'Ações do Ticket de Estacionamento',
				'subtitulo' => 'Ações do ticket de estacionamento',
				'icone_view' => 'fas fa-question',
				'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
			);

			$this->load->view('layout/header', $data);
			$this->load->view('estacionar/acoes');
			$this->load->view('layout/footer');
		}
	}

	public function pdf($estacionar_id = null)
	{
		if (!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
			$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado para impressão!');
			redirect('estacionar');
		} else {
			$this->load->library('pdf');

			$empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
			$ticket = $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id));

			$file_name = 'Ticket_Placa_' . $ticket->estacionar_placa_veiculo . '.pdf';

			$html = '
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; font-size: 12px; }
				.header { text-align: center; margin-bottom: 10px; }
				.header h1 { margin: 5px 0; font-size: 18px; }
				.header p { margin: 2px 0; font-size: 12px; }
				hr { margin: 10px 0; }
				.ticket-info { margin-top: 10px; }
				.ticket-info h2 { font-size: 16px; margin-bottom: 10px; }
				table { width: 100%; border-collapse: collapse; }
				td { padding: 6px 4px; border-bottom: 1px solid #ccc; }
				.label { font-weight: bold; width: 30%; }
			</style>
		</head>
		<body>
			<div class="header">
				<h1>' . $empresa->sistema_razao_social . '</h1>
				<p>' . $empresa->sistema_endereco . ', ' . $empresa->sistema_numero . '</p>
				<p>' . $empresa->sistema_cidade . ' - ' . $empresa->sistema_estado . '</p>
				<p>Telefone: ' . $empresa->sistema_telefone_fixo . '</p>
			</div>
			<hr>
			<div class="ticket-info">
				<h2>Recibo de Estacionamento</h2>
				<table>
					<tr><td class="label">Placa:</td><td>' . $ticket->estacionar_placa_veiculo . '</td></tr>
					<tr><td class="label">Marca:</td><td>' . $ticket->estacionar_marca_veiculo . '</td></tr>
					<tr><td class="label">Modelo:</td><td>' . $ticket->estacionar_modelo_veiculo . '</td></tr>
					<tr><td class="label">Vaga:</td><td>' . $ticket->estacionar_numero_vaga . '</td></tr>
					<tr><td class="label">Valor Hora:</td><td>R$ ' . number_format($ticket->estacionar_valor_hora, 2, ',', '.') . '</td></tr>
					<tr><td class="label">Data Entrada:</td><td>' . formata_data_banco_com_hora($ticket->estacionar_data_entrada) . '</td></tr>
					<tr><td class="label">Data Saída:</td><td>' . formata_data_banco_com_hora($ticket->estacionar_data_saida) . '</td></tr>
					<tr><td class="label">Tempo Decorrido:</td><td>' . $ticket->estacionar_tempo_decorrido . '</td></tr>
					<tr><td class="label">Valor Devido:</td><td><strong>R$ ' . number_format($ticket->estacionar_valor_devido, 2, ',', '.') . '</strong></td></tr>
				</table>
			</div>

			<div style="text-align:center; margin-top: 30px;">
				<p><em>"A gentileza no atendimento é o combustível que move a preferência do cliente."</em></p>
				<p><strong>– Sistema Estacionamento</strong></p>
				<p style="margin-top: 10px;"><strong>Volte sempre!</strong></p>
			</div>
		</body>
		</html>
		';

			$this->pdf->createPDF($html, $file_name, false);
		}
	}

	public function ticket_entrada($estacionar_id = null)
	{
		if (!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
			$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado!');
			redirect('estacionar');
		} else {
			$this->load->library('pdf');

			$empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
			$ticket = $this->estacionar_model->get_by_id($estacionar_id);

			// Gerar código único do ticket
			$codigo_ticket = format_ticket_code($estacionar_id);
			$qr_code_data = generate_ticket_qr_data($ticket);
			$qr_code_base64 = generate_qr_code_base64($qr_code_data, 120);

			$file_name = 'Ticket_Entrada_' . $ticket->estacionar_placa_veiculo . '_' . date('YmdHis');

			$html = '
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="UTF-8">
				<style>
					body { 
						font-family: Arial, sans-serif; 
						font-size: 11px; 
						margin: 0; 
						padding: 10px;
						width: 80mm;
					}
					.ticket-container {
						border: 2px dashed #333;
						padding: 15px;
						text-align: center;
						background: #fff;
					}
					.header { 
						text-align: center; 
						margin-bottom: 15px; 
						border-bottom: 1px solid #ddd;
						padding-bottom: 10px;
					}
					.header h1 { 
						margin: 0 0 5px 0; 
						font-size: 16px; 
						color: #333;
						text-transform: uppercase;
					}
					.header p { 
						margin: 2px 0; 
						font-size: 9px; 
						color: #666;
					}
					.ticket-code {
						background: #f0f0f0;
						border: 1px solid #ddd;
						padding: 8px;
						margin: 10px 0;
						font-size: 14px;
						font-weight: bold;
						letter-spacing: 1px;
					}
					.vehicle-info {
						margin: 15px 0;
						text-align: left;
					}
					.info-row {
						display: table;
						width: 100%;
						margin-bottom: 5px;
					}
					.info-label {
						display: table-cell;
						font-weight: bold;
						width: 40%;
						color: #333;
					}
					.info-value {
						display: table-cell;
						width: 60%;
					}
					.highlight-box {
						background: #e8f4f8;
						border: 1px solid #bee5eb;
						padding: 10px;
						margin: 10px 0;
						border-radius: 3px;
					}
					.important-info {
						background: #fff3cd;
						border: 1px solid #ffeaa7;
						padding: 8px;
						margin: 10px 0;
						border-radius: 3px;
						font-size: 9px;
					}
					.footer {
						margin-top: 15px;
						padding-top: 10px;
						border-top: 1px solid #ddd;
						font-size: 8px;
						color: #666;
					}
					.barcode {
						margin: 10px 0;
						font-family: "Courier New", monospace;
						font-size: 8px;
						letter-spacing: 1px;
					}
					.qr-code-section {
						text-align: center;
						margin: 10px 0;
						padding: 5px;
					}
				</style>
			</head>
			<body>
				<div class="ticket-container">
					<div class="header">
						<h1>' . ($empresa ? $empresa->sistema_razao_social : 'Sistema de Estacionamento') . '</h1>';
			
			if($empresa) {
				$html .= '
						<p>' . $empresa->sistema_endereco . ', ' . $empresa->sistema_numero . '</p>
						<p>' . $empresa->sistema_cidade . ' - ' . $empresa->sistema_estado . '</p>
						<p>Tel: ' . $empresa->sistema_telefone_fixo . '</p>';
			}
			
			$html .= '
					</div>

					<div class="ticket-code">
						TICKET: ' . $codigo_ticket . '
					</div>

					<div class="vehicle-info">
						<div class="info-row">
							<div class="info-label">PLACA:</div>
							<div class="info-value"><strong>' . strtoupper($ticket->estacionar_placa_veiculo) . '</strong></div>
						</div>
						<div class="info-row">
							<div class="info-label">VEÍCULO:</div>
							<div class="info-value">' . $ticket->estacionar_marca_veiculo . ' ' . $ticket->estacionar_modelo_veiculo . '</div>
						</div>
						<div class="info-row">
							<div class="info-label">VAGA:</div>
							<div class="info-value"><strong>' . $ticket->estacionar_numero_vaga . '</strong></div>
						</div>
						<div class="info-row">
							<div class="info-label">CATEGORIA:</div>
							<div class="info-value">' . $ticket->precificacao_categoria . '</div>
						</div>
					</div>

					<div class="highlight-box">
						<div class="info-row">
							<div class="info-label">ENTRADA:</div>
							<div class="info-value"><strong>' . date('d/m/Y H:i', strtotime($ticket->estacionar_data_entrada)) . '</strong></div>
						</div>
						<div class="info-row">
							<div class="info-label">VALOR/HORA:</div>
							<div class="info-value"><strong>R$ ' . number_format($ticket->estacionar_valor_hora, 2, ',', '.') . '</strong></div>
						</div>				</div>

				<div class="qr-code-section">';
			
			if ($qr_code_base64) {
				$html .= '
					<img src="' . $qr_code_base64 . '" alt="QR Code" style="width: 80px; height: 80px; margin: 10px 0;" />';
			} else {
				$html .= '
					<div class="barcode">
						||| ' . $qr_code_data . ' |||
					</div>';
			}
			
			$html .= '
				</div>

					<div class="important-info">
						<strong>IMPORTANTE:</strong><br>
						• Mantenha este ticket para a saída<br>
						• Tolerância: 15 minutos<br>
						• Perdeu o ticket? Taxa adicional<br>
						• Horário funcionamento: 24h
					</div>

					<div class="footer">
						<p>Emitido em: ' . date('d/m/Y H:i:s') . '</p>
						<p>Sistema de Estacionamento v1.0</p>
					</div>
				</div>
			</body>
			</html>';

			$this->pdf->createPDF($html, $file_name, false, 'A6', 'portrait');
		}
	}
}
