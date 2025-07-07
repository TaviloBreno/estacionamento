<?php
defined('BASEPATH') OR exit('Ação não permitida');

class Relatorios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('info', 'Sua sessão expirou!');
			redirect('login');
		}

		$this->load->model('relatorios_model');
		$this->load->model('estacionar_model');
		$this->load->model('core_model');
		$this->load->library('pdf');
	}

	public function index()
	{
		$data = array(
			'titulo' => 'Relatórios',
			'subtitulo' => 'Relatórios e Estatísticas do Sistema',
			'icone_view' => 'ik ik-bar-chart-2',
			'styles' => array(
				'plugins/chart.js/Chart.min.css',
				'datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'plugins/chart.js/Chart.min.js',
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'../dist/js/relatorios.js',
			)
		);

		$this->load->view('layout/header', $data);
		$this->load->view('relatorios/index');
		$this->load->view('layout/footer');
	}

	public function dashboard()
	{
		// Dados para gráficos
		$fluxo_diario = $this->relatorios_model->get_fluxo_diario();
		$ocupacao_por_categoria = $this->relatorios_model->get_ocupacao_por_categoria();
		$faturamento_mensal = $this->relatorios_model->get_faturamento_mensal();
		$clientes_por_dia = $this->relatorios_model->get_clientes_por_dia();

		// Estatísticas gerais
		$stats = array(
			'total_vagas' => $this->relatorios_model->get_total_vagas(),
			'vagas_ocupadas' => $this->relatorios_model->get_vagas_ocupadas(),
			'faturamento_hoje' => $this->relatorios_model->get_faturamento_hoje(),
			'movimentacoes_hoje' => $this->relatorios_model->get_movimentacoes_hoje(),
			'taxa_ocupacao' => $this->relatorios_model->get_taxa_ocupacao()
		);

		$data = array(
			'titulo' => 'Dashboard de Relatórios',
			'subtitulo' => 'Visão geral das estatísticas',
			'icone_view' => 'ik ik-trending-up',
			'fluxo_diario' => $fluxo_diario,
			'ocupacao_por_categoria' => $ocupacao_por_categoria,
			'faturamento_mensal' => $faturamento_mensal,
			'clientes_por_dia' => $clientes_por_dia,
			'stats' => $stats,
			'styles' => array(
				'plugins/chart.js/Chart.min.css',
			),
			'scripts' => array(
				'plugins/chart.js/Chart.min.js',
				'../dist/js/relatorios-dashboard.js',
			)
		);

		$this->load->view('layout/header', $data);
		$this->load->view('relatorios/dashboard');
		$this->load->view('layout/footer');
	}

	public function movimentacoes()
	{
		$data_inicio = $this->input->get('data_inicio') ? $this->input->get('data_inicio') : date('Y-m-01');
		$data_fim = $this->input->get('data_fim') ? $this->input->get('data_fim') : date('Y-m-t');

		$movimentacoes = $this->relatorios_model->get_movimentacoes_periodo($data_inicio, $data_fim);

		$data = array(
			'titulo' => 'Relatório de Movimentações',
			'subtitulo' => 'Movimentações por período',
			'icone_view' => 'ik ik-activity',
			'movimentacoes' => $movimentacoes,
			'data_inicio' => $data_inicio,
			'data_fim' => $data_fim,
			'styles' => array(
				'datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
			)
		);

		$this->load->view('layout/header', $data);
		$this->load->view('relatorios/movimentacoes');
		$this->load->view('layout/footer');
	}

	public function faturamento()
	{
		$data_inicio = $this->input->get('data_inicio') ? $this->input->get('data_inicio') : date('Y-m-01');
		$data_fim = $this->input->get('data_fim') ? $this->input->get('data_fim') : date('Y-m-t');

		$faturamento = $this->relatorios_model->get_faturamento_periodo($data_inicio, $data_fim);
		$faturamento_categoria = $this->relatorios_model->get_faturamento_por_categoria($data_inicio, $data_fim);

		$data = array(
			'titulo' => 'Relatório de Faturamento',
			'subtitulo' => 'Faturamento por período',
			'icone_view' => 'ik ik-dollar-sign',
			'faturamento' => $faturamento,
			'faturamento_categoria' => $faturamento_categoria,
			'data_inicio' => $data_inicio,
			'data_fim' => $data_fim,
			'styles' => array(
				'plugins/chart.js/Chart.min.css',
				'datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'plugins/chart.js/Chart.min.js',
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'../dist/js/relatorios-faturamento.js',
			)
		);

		$this->load->view('layout/header', $data);
		$this->load->view('relatorios/faturamento');
		$this->load->view('layout/footer');
	}

	public function exportar_pdf($tipo = 'dashboard')
	{
		$this->load->library('pdf');

		switch($tipo) {
			case 'dashboard':
				$this->_exportar_dashboard_pdf();
				break;
			case 'movimentacoes':
				$this->_exportar_movimentacoes_pdf();
				break;
			case 'faturamento':
				$this->_exportar_faturamento_pdf();
				break;
			default:
				show_404();
		}
	}

	private function _exportar_dashboard_pdf()
	{
		$stats = array(
			'total_vagas' => $this->relatorios_model->get_total_vagas(),
			'vagas_ocupadas' => $this->relatorios_model->get_vagas_ocupadas(),
			'faturamento_hoje' => $this->relatorios_model->get_faturamento_hoje(),
			'movimentacoes_hoje' => $this->relatorios_model->get_movimentacoes_hoje(),
			'taxa_ocupacao' => $this->relatorios_model->get_taxa_ocupacao()
		);

		$data = array(
			'titulo' => 'Relatório Dashboard - ' . date('d/m/Y'),
			'stats' => $stats,
			'data_geracao' => date('d/m/Y H:i:s')
		);

		$html = $this->load->view('relatorios/pdf/dashboard', $data, true);
		$this->pdf->createPDF($html, 'relatorio-dashboard-' . date('Y-m-d'), false);
	}

	private function _exportar_movimentacoes_pdf()
	{
		$data_inicio = $this->input->get('data_inicio') ? $this->input->get('data_inicio') : date('Y-m-01');
		$data_fim = $this->input->get('data_fim') ? $this->input->get('data_fim') : date('Y-m-t');

		$movimentacoes = $this->relatorios_model->get_movimentacoes_periodo($data_inicio, $data_fim);

		$data = array(
			'titulo' => 'Relatório de Movimentações',
			'periodo' => date('d/m/Y', strtotime($data_inicio)) . ' a ' . date('d/m/Y', strtotime($data_fim)),
			'movimentacoes' => $movimentacoes,
			'data_geracao' => date('d/m/Y H:i:s')
		);

		$html = $this->load->view('relatorios/pdf/movimentacoes', $data, true);
		$this->pdf->createPDF($html, 'relatorio-movimentacoes-' . date('Y-m-d'), false);
	}

	private function _exportar_faturamento_pdf()
	{
		$data_inicio = $this->input->get('data_inicio') ? $this->input->get('data_inicio') : date('Y-m-01');
		$data_fim = $this->input->get('data_fim') ? $this->input->get('data_fim') : date('Y-m-t');

		$faturamento = $this->relatorios_model->get_faturamento_periodo($data_inicio, $data_fim);
		$faturamento_categoria = $this->relatorios_model->get_faturamento_por_categoria($data_inicio, $data_fim);

		$data = array(
			'titulo' => 'Relatório de Faturamento',
			'periodo' => date('d/m/Y', strtotime($data_inicio)) . ' a ' . date('d/m/Y', strtotime($data_fim)),
			'faturamento' => $faturamento,
			'faturamento_categoria' => $faturamento_categoria,
			'data_geracao' => date('d/m/Y H:i:s')
		);

		$html = $this->load->view('relatorios/pdf/faturamento', $data, true);
		$this->pdf->createPDF($html, 'relatorio-faturamento-' . date('Y-m-d'), false);
	}

	public function ajax_dados_grafico()
	{
		$tipo = $this->input->post('tipo');
		
		switch($tipo) {
			case 'fluxo_diario':
				$dados = $this->relatorios_model->get_fluxo_diario();
				break;
			case 'ocupacao_categoria':
				$dados = $this->relatorios_model->get_ocupacao_por_categoria();
				break;
			case 'faturamento_mensal':
				$dados = $this->relatorios_model->get_faturamento_mensal();
				break;
			case 'clientes_por_dia':
				$dados = $this->relatorios_model->get_clientes_por_dia();
				break;
			case 'estatisticas_rapidas':
				$dados = array(
					'vagas_ocupadas' => $this->relatorios_model->get_vagas_ocupadas(),
					'faturamento_hoje' => number_format($this->relatorios_model->get_faturamento_hoje(), 2, ',', '.'),
					'movimentacoes_hoje' => $this->relatorios_model->get_movimentacoes_hoje(),
					'taxa_ocupacao' => $this->relatorios_model->get_taxa_ocupacao()
				);
				break;
			case 'movimentacoes_categoria':
				$data_inicio = $this->input->post('data_inicio');
				$data_fim = $this->input->post('data_fim');
				$dados = array('success' => true, 'data' => $this->relatorios_model->get_movimentacoes_por_categoria($data_inicio, $data_fim));
				break;
			default:
				$dados = array();
		}

		header('Content-Type: application/json');
		echo json_encode($dados);
	}
}
