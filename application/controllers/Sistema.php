<?php
defined('BASEPATH') or exit('Ação não permitida');

class Sistema extends CI_Controller
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
			'titulo' => 'Gerenciar Sistema',
			'subtitulo' => 'Aqui você pode visualizar, adicionar, editar e excluir os usuários cadastrados no sistema',
			'icone_view' => 'ik ik-settings',
			'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('sistema/index');
		$this->load->view('layout/footer');
	}
}
