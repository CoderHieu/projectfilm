<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('query_sql');

	}
	public function __destruct(){
	}
	public function index()
	{
		$data['data_index'] = $this->get_index();
		if($this->CI_auth->check_logged()=== true){
			$data['title'] = 'Quản lý website';
			$data['template'] = 'backend/home/index';
			$this->load->view('backend/index', isset($data)?$data:NULL);
		}else{
			redirect(base_url().'admin/dang-nhap.html');
		}
	}
	public function login()
	{
		$data['data_index'] = $this->get_index();
		if($this->CI_auth->check_logged()=== true){
			$data['title'] = 'Quản trị';
			$data['data'] = $this->get_index();
			$data['template'] = 'backend/home/index';
			$this->load->view('backend/index', isset($data)?$data:NULL);
		}else{
			$data['title'] = 'Đăng nhập';
			$data['data'] = $this->get_index();
			$data['template'] = 'backend/home/login';
			$this->load->view('backend/index', isset($data)?$data:NULL);
			if($this->input->post()){
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$login_array = array($username, $password);
				if($this->CI_auth->process_login($login_array))
				{
					redirect(base_url().'admin/');
				}
			}
		}
	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'admin/dang-nhap.html');
	}
}
