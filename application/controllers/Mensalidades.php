<?php
defined('BASEPATH') or exit('Ação não permitida');

class Mensalidades extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('login');
		}

		$this->load->model('mensalidades_model');
	}

	public function index()
	{
		$data = array(
			'titulo' => 'Mensalidades Cadastradas',
			'subtitulo' => 'Aqui você pode visualizar, adicionar, editar e excluir as mensalidades cadastradas no sistema',
			'icone_view' => 'fas fa-hand-holding-usd',
			'styles' => array(
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'datatables.net/js/mensalidades.js',
				'datatables.net/js/flashcards.js',
			),
			'mensalidades' => $this->mensalidades_model->get_all(),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('mensalidades/index');
		$this->load->view('layout/footer');
	}

	public function core($mensalidade_id = null)
	{
		if(!$mensalidade_id){
			$data = array(
				'titulo' => 'Cadastrar Mensalidade',
				'subtitulo' => 'Aqui você pode cadastrar uma nova mensalidade',
				'icone_view' => 'fas fa-hand-holding-usd',
				'styles' => array(
					'mask/jquery.mask.min.css',
				),
				'scripts' => array(
					'mask/jquery.mask.min.js',
					'mask/custom.js',
				),
				'mensalistas' => $this->core_model->get_all('mensalistas'),
				'precificacoes' => $this->core_model->get_all('precificacoes'),
			);

			$this->form_validation->set_rules('mensalidade_mensalista_id', 'Mensalista', 'trim|required');
			$this->form_validation->set_rules('mensalidade_precificacao_id', 'Precificação', 'trim|required');
			$this->form_validation->set_rules('mensalidade_valor_mensalidade', 'Valor da Mensalidade', 'trim|required');
			$this->form_validation->set_rules('mensalidade_mensalista_dia_vencimento', 'Dia de Vencimento', 'trim|required');
			$this->form_validation->set_rules('mensalidade_data_vencimento', 'Data de Vencimento', 'trim|required');
			$this->form_validation->set_rules('mensalidade_status', 'Status', 'trim|required');

			if($this->form_validation->run()) {
				$data = elements(
					array(
						'mensalidade_mensalista_id',
						'mensalidade_precificacao_id',
						'mensalidade_valor_mensalidade',
						'mensalidade_mensalista_dia_vencimento',
						'mensalidade_data_vencimento',
						'mensalidade_status',
					),
					$this->input->post()
				);

				$data = html_escape($data);

				$this->core_model->insert('mensalidades', $data);
				$this->session->set_flashdata('sucesso', 'Mensalidade cadastrada com sucesso');
				redirect('mensalidades');
			}else{
				$this->load->view('layout/header', $data);
				$this->load->view('mensalidades/core');
				$this->load->view('layout/footer');
			}
		}else{
			if(!$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))){
				$this->session->set_flashdata('error', 'Mensalidade não encontrada');
				redirect('mensalidades');
			}else{
		    	$this->form_validation->set_rules('mensalidade_mensalista_id', 'Mensalista', 'trim|required');
				$this->form_validation->set_rules('mensalidade_precificacao_id', 'Precificação', 'trim|required');
				$this->form_validation->set_rules('mensalidade_valor_mensalidade', 'Valor da Mensalidade', 'trim|required');
				$this->form_validation->set_rules('mensalidade_mensalista_dia_vencimento', 'Dia de Vencimento', 'trim|required');
				$this->form_validation->set_rules('mensalidade_data_vencimento', 'Data de Vencimento', 'trim|required');
				$this->form_validation->set_rules('mensalidade_status', 'Status', 'trim|required');

				if($this->form_validation->run()) {
					$data = elements(
						array(
							'mensalidade_mensalista_id',
							'mensalidade_precificacao_id',
							'mensalidade_valor_mensalidade',
							'mensalidade_mensalista_dia_vencimento',
							'mensalidade_data_vencimento',
							'mensalidade_status',
						),
						$this->input->post()
					);

					$data = html_escape($data);

					$this->core_model->update('mensalidades', $data, array('mensalidade_id' => $mensalidade_id));
					redirect('mensalidades');
				}else{
					$data = array(
						'titulo' => 'Editar Mensalidade',
						'subtitulo' => 'Aqui você pode editar a mensalidade',
						'icone_view' => 'fas fa-hand-holding-usd',
						'styles' => array(
							'select2/dist/css/select2.min.css',
						),
						'scripts' => array(
							'mask/jquery.mask.min.js',
							'mask/custom.js',
							'select2/dist/js/select2.min.js',
						),
						'mensalidade' => $this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id)),
						'mensalistas' => $this->core_model->get_all('mensalistas'),
						'precificacoes' => $this->core_model->get_all('precificacoes'),
					);

					$this->load->view('layout/header', $data);
					$this->load->view('mensalidades/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function del($mensalidade_id = null)
	{
		if(!$mensalidade_id || !$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))){
			$this->session->set_flashdata('error', 'Mensalidade não encontrada');
			redirect('mensalidades');
		}

		if($this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id, 'mensalidade_status' => 1))){
			$this->session->set_flashdata('error', 'Mensalidade ativa não pode ser excluída');
			redirect('mensalidades');
		}

		$this->core_model->delete('mensalidades', array('mensalidade_id' => $mensalidade_id));
		$this->session->set_flashdata('sucesso', 'Mensalidade excluída com sucesso');
		redirect('mensalidades');
	}
}
