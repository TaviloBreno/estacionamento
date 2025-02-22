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
}
