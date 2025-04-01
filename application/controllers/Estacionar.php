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
			),
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'datatables.net/js/estacionamento.js',
				'datatables.net/js/flashcards.js',
			),
			'estacionados' => $this->estacionar_model->get_all(),
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

				redirect($this->router->fetch_class().'/acoes/'.$this->session->userdata('last_id'));
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

	public function del($estaionar_id = null)
	{
		if(!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
			$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado para exclusão!');
			redirect('estacionar');
		}else{
			$this->core_model->delete('estacionar', array('estacionar_id' => $estacionar_id));
			redirect($this->router->fetch_class());
		}
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
}
