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
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'datatables.net/js/precificacoes.js',
				'datatables.net/js/flashcards.js',
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
			$data = array(
				'titulo' => 'Cadastrar Precificação',
				'subtitulo' => 'Aqui você pode cadastrar uma nova precificação',
				'icone_view' => 'ik ik-dollar-sign',
				'styles' => array(
					'plugins/mask/jquery.mask.min.css',
				),
				'scripts' => array(
					'plugins/mask/jquery.mask.min.js',
					'plugins/mask/app.js',
				),
			);

			$this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'trim|required|min_length[5]|max_length[30]|is_unique[precificacoes.precificacao_categoria]');
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

				// Adicionando o campo `precificacao_ativa` com valor padrão
				$data['precificacao_ativa'] = 1;

				$data = html_escape($data);

				$this->core_model->insert('precificacoes', $data);
				$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
				redirect($this->router->fetch_class());
			} else {
				$this->load->view('layout/header', $data);
				$this->load->view('precificacoes/core');
				$this->load->view('layout/footer');
			}
		}else {
			if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {
				$this->session->set_flashdata('error', 'Precificação não encontrada');
				redirect($this->router->fetch_class());
			} else {
				$this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'trim|required|min_length[5]|max_length[30]|callback_check_categoria');
				$this->form_validation->set_rules('precificacao_valor_hora', 'Valor por Hora', 'trim|required|max_length[10]');
				$this->form_validation->set_rules('precificacao_valor_mensalidade', 'Valor da Mensalidade', 'trim|required|max_length[10]');
				$this->form_validation->set_rules('precificacao_numero_vagas', 'Número de Vagas', 'trim|required|integer|greater_than[0]');

				if ($this->form_validation->run()) {
					$precificacao_ativa = $this->input->post('precificacao_ativa');

					if($precificacao_ativa == 0){
						if($this->db->table_exists('estacionar')){
							if($this->core_model->get_by_id('estacionar', array('estacionar_precificacao_id' => $precificacao_id, 'estacionar_status' => 0))){
								$this->session->set_flashdata('error', 'Essa precificação não pode ser desativada, pois existem registros de estacionamento com ela');
								redirect($this->router->fetch_class());
							}
						}
					}

					if($precificacao_ativa == 0){
						if($this->db->table_exists('mensalidades')){
							if($this->core_model->get_by_id('mensalidades', array('mensalidade_precificacao_id' => $precificacao_id, 'mensalidade_status' => 0))){
								$this->session->set_flashdata('error', 'Essa precificação não pode ser desativada, pois existem mensalidades com ela');
								redirect($this->router->fetch_class());
							}
						}
					}

					$data = elements(
						array(
							'precificacao_categoria',
							'precificacao_valor_hora',
							'precificacao_valor_mensalidade',
							'precificacao_numero_vagas',
							'precificacao_ativa',
						),
						$this->input->post()
					);

					$data = html_escape($data);

					$this->core_model->update('precificacoes', $data, array('precificacao_id' => $precificacao_id));
					$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
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

	public function del($precificacao_id = null)
	{
		// Verifica se a precificação existe
		if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {
			$this->session->set_flashdata('error', 'Precificação não encontrada');
			redirect($this->router->fetch_class());
		}

		// Verifica se a precificação está ativa (não pode ser excluída)
		if ($this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id, 'precificacao_ativa' => 1))) {
			$this->session->set_flashdata('error', 'Essa precificação não pode ser excluída, pois está ativa');
			redirect($this->router->fetch_class());
		}

		// Se passou pelas verificações, pode excluir
		$this->core_model->delete('precificacoes', array('precificacao_id' => $precificacao_id));
		$this->session->set_flashdata('sucesso', 'Precificação excluída com sucesso');
		redirect($this->router->fetch_class());
	}

}
