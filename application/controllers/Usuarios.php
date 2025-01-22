<?php
defined('BASEPATH') or exit('Ação não permitida');

class Usuarios extends CI_Controller
{
	public function index()
	{
		$data = array(
			'titulo' => 'Usuários Cadastrados',
			'subtitulo' => 'Aqui você pode visualizar, adicionar, editar e excluir os usuários cadastrados no sistema',
			'styles' => array(
				'datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'datatables.net/js/estacionamento.js',
			),
			'usuarios' => $this->ion_auth->users()->result(),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('usuarios/index');
		$this->load->view('layout/footer');
	}

	public function core($usuario_id = null)
	{
		if (!$usuario_id) {

		} else {
			$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[5]|max_length[20]');
			$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]|max_length[20]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[30]');
			$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[5]|max_length[30]');
			$this->form_validation->set_rules('password', 'Senha', 'trim|min_length[6]|max_length[200]');
			$this->form_validation->set_rules('confirm_password', 'Confirmação de Senha', 'trim|matches[password]');
			$this->form_validation->set_rules('perfil_usuario', 'Perfil de Acesso', 'required');

			if ($this->form_validation->run()) {

			} else {
				$data = array(
					'titulo' => 'Editar Usuário',
					'subtitulo' => 'Edite os dados do usuário',
					'icone_view' => 'ik ik-user',
					'usuario' => $this->ion_auth->user($usuario_id)->row(),
					'perfil' => $this->ion_auth->get_users_groups($usuario_id)->row(),
				);
				$this->load->view('layout/header', $data);
				$this->load->view('usuarios/core');
				$this->load->view('layout/footer');
			}
		}
	}
}
