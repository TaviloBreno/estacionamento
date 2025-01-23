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
			// Cadastrando

			$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[5]|max_length[45]');
			$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]|max_length[45]');
			$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[5]|max_length[30]|is_unique[users.username]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[30]|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[6]|max_length[200]');
			$this->form_validation->set_rules('confirm_password', 'Confirmação de Senha', 'trim|required|matches[password]');

			if ($this->form_validation->run()) {
				$data = elements(
					array(
						'first_name',
						'last_name',
						'username',
						'email',
						'password',
					),
					$this->input->post()
				);

				$data = html_escape($data);

				if($this->ion_auth->register($data['username'], $data['password'], $data['email'], array('first_name' => $data['first_name'], 'last_name' => $data['last_name']))) {
					$this->session->set_flashdata('sucesso', 'Usuário cadastrado com sucesso');
				} else {
					$this->session->set_flashdata('error', 'Erro ao cadastrar usuário');
				}

				redirect($this->router->fetch_class());

			} else {
				$data = array(
					'titulo' => 'Cadastrar Usuário',
					'subtitulo' => 'Cadastre os dados do usuário',
					'icone_view' => 'ik ik-user',
				);

				$this->load->view('layout/header', $data);
				$this->load->view('usuarios/core');
				$this->load->view('layout/footer');
			}

		} else {
			$perfil_atual = $this->ion_auth->get_users_groups($usuario_id)->row();

			$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[5]|max_length[45]');
			$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]|max_length[45]');
			$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[5]|max_length[30]|callback_username_check');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[30]|callback_email_check');
			$this->form_validation->set_rules('password', 'Senha', 'trim|min_length[6]|max_length[200]');
			$this->form_validation->set_rules('confirm_password', 'Confirmação de Senha', 'trim|matches[password]');


			if ($this->form_validation->run()) {
				$data = elements(
					array(
						'first_name',
						'last_name',
						'username',
						'email',
						'password',
						'active',
					),
					$this->input->post()
				);

				$password = $this->input->post('password');

				if (!$password) {
					unset($data['password']);
				}

				$data = html_escape($data);

				if($this->ion_auth->update($usuario_id, $data)) {
					$perfil_post = $this->input->post('perfil_usuario');

					if($perfil_atual->id != $perfil_post) {
						$this->ion_auth->remove_from_group($perfil_atual->id, $usuario_id);
						$this->ion_auth->add_to_group($perfil_post, $usuario_id);
					}

					$this->session->set_flashdata('sucesso', 'Usuário atualizado com sucesso');
				} else {
					$this->session->set_flashdata('error', 'Erro ao atualizar usuário');
				}

				redirect($this->router->fetch_class());

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

	public function username_check($username)
	{
		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))) {
			$this->form_validation->set_message('username_check', 'Esse usuário já existe');
			return false;
		} else {
			return true;
		}
	}

	public function email_check($email)
	{
		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))) {
			$this->form_validation->set_message('email_check', 'Esse email já existe');
			return false;
		} else {
			return true;
		}
	}

	public function del($usuario_id = null)
	{
		if (!$usuario_id || !$this->ion_auth->user($usuario_id)->row()) {
			$this->session->set_flashdata('error', 'Usuário não encontrado');
			redirect($this->router->fetch_class());
		}

		if ($this->ion_auth->is_admin($usuario_id)) {
			$this->session->set_flashdata('error', 'Administradores não podem ser excluídos');
			redirect($this->router->fetch_class());
		}

		if ($this->ion_auth->delete_user($usuario_id)) {
			$this->session->set_flashdata('sucesso', 'Usuário excluído com sucesso');
		} else {
			$this->session->set_flashdata('error', 'Erro ao excluir usuário');
		}

		redirect($this->router->fetch_class());
	}
}
