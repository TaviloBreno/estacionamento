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

	public function core($forma_pagamento_id = null)
	{
		if (!$forma_pagamento_id) {
			// Cadastro de nova forma de pagamento
			$data = array(
				'titulo' => 'Cadastrar Forma de Pagamento',
				'subtitulo' => 'Aqui você pode cadastrar uma nova forma de pagamento',
				'icone_view' => 'ik ik-credit-card',
				'styles' => array(
					'plugins/mask/jquery.mask.min.css',
				),
				'scripts' => array(
					'plugins/mask/jquery.mask.min.js',
					'plugins/mask/app.js',
				),
			);

			$this->form_validation->set_rules('forma_pagamento_nome', 'Nome da Forma de Pagamento', 'trim|required|min_length[5]|max_length[30]|is_unique[formas_pagamentos.forma_pagamento_nome]');
			$this->form_validation->set_rules('forma_pagamento_ativa', 'Ativa', 'required');

			if ($this->form_validation->run()) {
				$data = elements(
					array(
						'forma_pagamento_nome',
						'forma_pagamento_ativa',
					),
					$this->input->post()
				);

				// Adiciona a data de alteração no momento do cadastro
				$data['forma_pagamento_data_alteracao'] = date('Y-m-d H:i:s');

				// Corrigido html_escape para arrays
				$data = array_map('html_escape', $data);

				$this->core_model->insert('formas_pagamentos', $data);
				$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
				redirect($this->router->fetch_class());
			} else {
				// Mantém o valor padrão para o campo ativo
				$data['forma_pagamento_ativa'] = set_value('forma_pagamento_ativa', 1);
			}

			$this->load->view('layout/header', $data);
			$this->load->view('formas/core');
			$this->load->view('layout/footer');

		} else {
			// Edição de forma de pagamento
			$forma_pagamento = $this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id));

			if (!$forma_pagamento) {
				$this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
				redirect($this->router->fetch_class());
			}

			$data = array(
				'titulo' => 'Editar Forma de Pagamento',
				'subtitulo' => 'Aqui você pode editar a forma de pagamento',
				'icone_view' => 'ik ik-credit-card',
				'styles' => array(
					'plugins/mask/jquery.mask.min.css',
				),
				'scripts' => array(
					'plugins/mask/jquery.mask.min.js',
					'plugins/mask/app.js',
				),
				'forma_pagamento' => $forma_pagamento,
			);

			$this->form_validation->set_rules('forma_pagamento_nome', 'Nome da Forma de Pagamento', 'trim|required|min_length[5]|max_length[30]|callback_check_nome_forma_pagamento');
			$this->form_validation->set_rules('forma_pagamento_ativa', 'Ativa', 'required');

			if ($this->form_validation->run()) {
				$data = elements(
					array(
						'forma_pagamento_nome',
						'forma_pagamento_ativa',
					),
					$this->input->post()
				);

				// Atualiza a data de alteração no momento da edição
				$data['forma_pagamento_data_alteracao'] = date('Y-m-d H:i:s');

				// Corrigido html_escape para arrays
				$data = array_map('html_escape', $data);

				$this->core_model->update('formas_pagamentos', $data, array('forma_pagamento_id' => $forma_pagamento_id));

				$this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso');
				redirect($this->router->fetch_class());
			}

			$this->load->view('layout/header', $data);
			$this->load->view('formas/core');
			$this->load->view('layout/footer');
		}
	}

	public function check_nome_forma_pagamento($forma_pagamento_nome)
	{
		$forma_pagamento_id = $this->input->post('forma_pagamento_id');

		if ($this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_nome' => $forma_pagamento_nome, 'forma_pagamento_id !=' => $forma_pagamento_id))) {
			$this->form_validation->set_message('check_nome_forma_pagamento', 'Essa forma de pagamento já existe');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function del($forma_pagamento_id = null)
	{
		if (!$forma_pagamento_id || !$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))) {
			$this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id));
		$this->session->set_flashdata('sucesso', 'Forma de pagamento excluída com sucesso');
		redirect($this->router->fetch_class());
	}
}
