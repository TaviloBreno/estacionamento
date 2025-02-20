<?php
defined('BASEPATH') or exit('Ação não permitida');

class Precificacoes extends CI_Controller
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
			'titulo' => 'Precificações Cadastradas',
			'subtitulo' => 'Aqui você pode visualizar, adicionar, editar e excluir as precificações cadastradas no sistema',
			'icone_view' => 'ik ik-dollar-sign',
			'styles' => array(
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/precificacoes.js',
			),
			'precificacoes' => $this->core_model->get_all('precificacoes'),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('precificacoes/index');
		$this->load->view('layout/footer');
	}

	public function core($precificacao_id = null)
	{
		if (!$precificacao_id) {
			// Lógica para criar uma nova precificação (se necessário)
		} else {
			if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {
				$this->session->set_flashdata('error', 'Precificação não encontrada');
				redirect($this->router->fetch_class());
			} else {
				$this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'trim|required|min_length[5]|max_length[30]|callback_check_categoria');
				$this->form_validation->set_rules('precificacao_valor_hora', 'Valor por Hora', 'trim|required|max_length[10]');
				$this->form_validation->set_rules('precificacao_valor_mensalidade', 'Valor da Mensalidade', 'trim|required|max_length[10]');
				$this->form_validation->set_rules('precificacao_numero_vagas', 'Número de Vagas', 'trim|required|integer|greater_than[0]');

				if ($this->form_validation->run()) {
					$data = elements(
						array(
							'precificacao_categoria',
							'precificacao_valor_hora',
							'precificacao_valor_mensalidade',
							'precificacao_numero_vagas',
						),
						$this->input->post()
					);

					$data = html_escape($data);

					$this->core_model->update('precificacoes', $data, array('precificacao_id' => $precificacao_id));
					redirect($this->router->fetch_class());
				} else {
					$data = array(
						'titulo' => 'Atualizar Precificação',
						'subtitulo' => 'Aqui você pode atualizar a precificação',
						'icone_view' => 'ik ik-dollar-sign',
						'styles' => array(
							'plugins/mask/jquery.mask.min.css',
						),
						'scripts' => array(
							'plugins/mask/jquery.mask.min.js',
							'plugins/mask/app.js',
						),
						'categoria' => $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id)),
						'precificacao' => $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id)),
					);

					$this->load->view('layout/header', $data);
					$this->load->view('precificacoes/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function check_categoria($precificacao_categoria)
	{
		$precificacao_id = $this->input->post('precificacao_id');

		if ($this->core_model->get_by_id('precificacoes', array('precificacao_categoria' => $precificacao_categoria, 'precificacao_id !=' => $precificacao_id))) {
			$this->form_validation->set_message('check_categoria', 'Essa categoria já existe');
			return false;
		} else {
			return true;
		}
	}
}
