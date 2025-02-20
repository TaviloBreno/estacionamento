<?php
defined('BASEPATH') or exit('Ação não permitida');

class Formas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('login');
		}
	}

	public function index()
	{
		$data = array(
			'titulo' => 'Formas de Pagamento Cadastradas',
			'subtitulo' => 'Aqui você pode visualizar, adicionar, editar e excluir as formas de pagamento cadastradas no sistema',
			'icone_view' => 'ik ik-credit-card',
			'styles' => array(
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/formas.js',
			),
			'formas' => $this->core_model->get_all('formas_pagamentos'),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('formas/index');
		$this->load->view('layout/footer');
	}
}
