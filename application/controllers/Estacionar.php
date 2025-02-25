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

		}else{
			if(!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
				$this->session->set_flashdata('error', 'Ticket de estacionamento não encontrado para encerramento!');
				redirect('estacionar');
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
}
