<?php
defined('BASEPATH') OR exit('Ação não permitida');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->model('relatorios_model');
		
		$data = array(
			'titulo' => 'Home',
			'vagas_disponiveis' => $this->relatorios_model->get_total_vagas() - $this->relatorios_model->get_vagas_ocupadas(),
			'clientes_ativos' => $this->relatorios_model->get_vagas_ocupadas(),
			'faturamento_hoje' => $this->relatorios_model->get_faturamento_hoje(),
			'movimentacoes_hoje' => $this->relatorios_model->get_movimentacoes_hoje()
		);

		$this->load->view('layout/header', $data);
		$this->load->view('home/index', $data);
		$this->load->view('layout/footer');
	}
}
