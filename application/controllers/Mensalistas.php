<?php
defined('BASEPATH') or exit('Ação não permitida');

class Mensalistas extends CI_Controller
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
			'titulo' => 'Mensalistas Cadastrados',
			'subtitulo' => 'Aqui você pode visualizar, adicionar, editar e excluir os mensalistas cadastrados no sistema',
			'icone_view' => 'fas fa-user-tie',
			'styles' => array(
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'datatables.net/js/jquery.dataTables.min.js',
				'datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'datatables.net/js/mensalistas.js',
			),
			'mensalistas' => $this->core_model->get_all('mensalistas'),
		);

		$this->load->view('layout/header', $data);
		$this->load->view('mensalistas/index');
		$this->load->view('layout/footer');
	}

	public function core($mensalista_id = null)
	{
		if(!$mensalista_id){

		}else{
			if(!$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {
				$this->session->set_flashdata('error', 'Mensalista não encontrado');
				redirect($this->router->fetch_class());
			}else{
				$this->form_validation->set_rules('mensalista_nome', 'Nome', 'trim|required|min_length[3]|max_length[30]');
				$this->form_validation->set_rules('mensalista_sobrenome', 'Sobrenome', 'trim|required|min_length[3]|max_length[100]');
				$this->form_validation->set_rules('mensalista_data_nascimento', 'Data de Nascimento', 'trim|required');
				$this->form_validation->set_rules('mensalista_cpf', 'CPF', 'trim|required|exact_length[14]|callback_valida_cpf');
				$this->form_validation->set_rules('mensalista_rg', 'RG', 'trim|required|max_length[20]');
				$this->form_validation->set_rules('mensalista_email', 'E-mail', 'trim|required|valid_email|max_length[100]');
				$this->form_validation->set_rules('mensalista_telefone_fixo', 'Telefone Fixo', 'trim|max_length[15]');
				$this->form_validation->set_rules('mensalista_telefone_movel', 'Telefone Móvel', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('mensalista_cep', 'CEP', 'trim|required|exact_length[9]');
				$this->form_validation->set_rules('mensalista_endereco', 'Endereço', 'trim|required|max_length[155]');
				$this->form_validation->set_rules('mensalista_numero_endereco', 'Número', 'trim|required|max_length[30]');
				$this->form_validation->set_rules('mensalista_bairro', 'Bairro', 'trim|required|max_length[45]');
				$this->form_validation->set_rules('mensalista_cidade', 'Cidade', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('mensalista_estado', 'Estado', 'trim|required|exact_length[2]');
				$this->form_validation->set_rules('mensalista_complemento', 'Complemento', 'trim|max_length[145]');
				$this->form_validation->set_rules('mensalista_obs', 'Observação', 'trim|max_length[500]');
				$this->form_validation->set_rules('mensalista_ativo', 'Status', 'required|in_list[0,1]');
				$this->form_validation->set_rules('mensalista_data_alteracao', 'Data de Alteração', 'required');

				if($this->form_validation->run()){
					$data = elements(
						array(
							'mensalista_nome',
							'mensalista_sobrenome',
							'mensalista_data_nascimento',
							'mensalista_cpf',
							'mensalista_rg',
							'mensalista_email',
							'mensalista_telefone_fixo',
							'mensalista_telefone_movel',
							'mensalista_cep',
							'mensalista_endereco',
							'mensalista_numero_endereco',
							'mensalista_bairro',
							'mensalista_cidade',
							'mensalista_estado',
							'mensalista_complemento',
							'mensalista_obs',
							'mensalista_ativo',
							'mensalista_data_alteracao',
						),
						$this->input->post()
					);

					$data = html_escape($data);

					$this->core_model->update('mensalistas', $data, array('mensalista_id' => $mensalista_id));
					$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
					redirect($this->router->fetch_class());
				}else{
					$data = array(
						'titulo' => 'Editar Mensalista',
						'subtitulo' => 'Aqui você pode editar o mensalista',
						'icone_view' => 'fas fa-user-tie',
						'scripts' => array(
							'mask/jquery.mask.min.js',
							'mask/custom.js',
						),
						'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
					);

					$this->load->view('layout/header', $data);
					$this->load->view('mensalistas/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}
}
