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

		}else{
			if(!$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))){
				$this->session->set_flashdata('error', 'Mensalidade não encontrada');
				redirect('mensalidades');
			}else{
		    	$this->form_validation->set_rules('mensalidade_mensalista_id', 'Mensalista', 'trim|required');
				$this->form_validation->set_rules('mensalidade_precificacao_id', 'Precificação', 'trim|required');
				$this->form_validation->set_rules('mensalidade_data_inicio', 'Data de Início', 'trim|required');
				$this->form_validation->set_rules('mensalidade_data_fim', 'Data de Fim', 'trim|required');
				$this->form_validation->set_rules('mensalidade_valor_mensalidade', 'Valor da Mensalidade', 'trim|required');
				$this->form_validation->set_rules('mensalidade_mensalista_dia_vencimento', 'Dia de Vencimento', 'trim|required');
				$this->form_validation->set_rules('mensalidade_data_vencimento', 'Data de Vencimento', 'trim|required');
				$this->form_validation->set_rules('mensalidade_status', 'Status', 'trim|required');

				if($this->form_validation->run()) {
					$data = elements(
						array(
							'mensalidade_mensalista_id',
							'mensalidade_precificacao_id',
							'mensalidade_data_inicio',
							'mensalidade_data_fim',
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
						'scripts' => array(
							'mask/jquery.mask.min.js',
							'mask/custom.js',
						),
						'mensalidade' => $this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id)),
					);

					$this->load->view('layout/header', $data);
					$this->load->view('mensalidades/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}
}
