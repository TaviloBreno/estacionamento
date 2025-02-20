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
				'datatables.net/js/flashcards.js',
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
			$data = array(
				'titulo' => 'Cadastrar Mensalista',
				'subtitulo' => 'Aqui você pode cadastrar um novo mensalista',
				'icone_view' => 'fas fa-user-tie',
				'scripts' => array(
					'mask/jquery.mask.min.js',
					'mask/custom.js',
				),
			);

			$this->form_validation->set_rules('mensalista_nome', 'Nome', 'trim|required|min_length[3]|max_length[30]');
			$this->form_validation->set_rules('mensalista_sobrenome', 'Sobrenome', 'trim|required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('mensalista_data_nascimento', 'Data de Nascimento', 'trim|required');
			$this->form_validation->set_rules('mensalista_cpf', 'CPF', 'trim|required|exact_length[14]|is_unique[mensalistas.mensalista_cpf]|callback_valida_cpf');
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

			if($this->form_validation->run()) {
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
						'mensalista_dia_vencimento',
					),
					$this->input->post()
				);

				$data = html_escape($data);

				$this->core_model->insert('mensalistas', $data);
				$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
				redirect($this->router->fetch_class());
			}else{
				$this->load->view('layout/header', $data);
				$this->load->view('mensalistas/core');
				$this->load->view('layout/footer');
			}
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

	public function valida_cpf($cpf) {

		if ($this->input->post('mensalista_id')) {

			$mensalista_id = $this->input->post('mensalista_id');

			if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_cpf' => $cpf))) {
				$this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
				return FALSE;
			}
		}

		$cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
		// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
		if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {

			$this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
			return FALSE;
		} else {
			// Calcula os números para verificar se o CPF é verdadeiro
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf[$c] * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf[$c] != $d) {
					$this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
					return FALSE;
				}
			}
			return TRUE;
		}
	}

	public function del($mensalista_id = null)
	{
		if(!$mensalista_id || !$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {
			$this->session->set_flashdata('error', 'Mensalista não encontrado');
			redirect($this->router->fetch_class());
		}

		if($this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id, 'mensalista_ativo' => 1))) {
			$this->session->set_flashdata('error', 'Mensalista ativo não pode ser excluído');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('mensalistas', array('mensalista_id' => $mensalista_id));
		$this->session->set_flashdata('sucesso', 'Mensalista excluído com sucesso');
		redirect($this->router->fetch_class());
	}
}
