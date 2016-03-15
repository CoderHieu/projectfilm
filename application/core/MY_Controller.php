<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('query_sql');
	}
	protected function get_index(){
		$data['moduless'] = $this->get_listmodule();
		$data['info_user'] = $this->get_user();
		$data['act'] = $this->get_act();
		$data['id_role'] = $this->get_roleid();
		$data['id_module'] = $this->get_moduleid();
		$data['permission'] = $this->checkpermission();
		return $data;
	}
	protected function get_listmodule(){
		$data = $this->query_sql->select_array('ci_module', 'id, name, created, controller, publish', array('parentid' => 0), 'sort asc,id asc');
		foreach ($data as $key => $val) {
			$data_child = $this->query_sql->select_array('ci_module', 'id, name, created, controller, publish', array('parentid' => $val['id']), 'sort asc,id asc');
			$data[$key]['child'] = $data_child;
			$data[$key]['active'] = $this->get_permission($val['id']);
			if($data[$key]['child'] != NULL){
				foreach ($data[$key]['child'] as $key_child => $val_child) {
					$data[$key]['child'][$key_child]['active'] = $this->get_permission($val_child['id']);
				}
			}
		}
		return $data;
	}
	protected function get_user(){
		if($this->CI_auth->check_logged()){
			$id_user = $this->CI_auth->logged_id();
			$data = $this->db->select('id,username,fullname,phone,email,avatar_thumb,avatar')->from('ci_user')->where('id', $id_user)->get()->row_array();
			return $data;
		}
	}
	protected function get_act(){
		$data = $this->router->fetch_method();
		return $data;
	}
	protected function get_roleid(){
		if($this->CI_auth->check_logged()){
			$id_user = $this->CI_auth->logged_id();
			$user = $this->db->select('id_role')->from('ci_user')->where('id', $id_user)->get()->row_array();
			$data = $user['id_role'];
			return $data;
		}
	}
	
	protected function get_permission($id_module = 0){
		if($this->CI_auth->check_logged()){
			$id_role = $this->get_roleid();
			$permission = $this->db->select('active')->from('dev_permission')->where(array('id_role' => $id_role, 'id_module' => $id_module))->get()->row_array();
			$data = $permission['active'];
			return $data;
		}
		
	}

	protected function get_moduleid(){
		$controller = $this->router->fetch_class();
		$module = $this->db->select('id')->from('ci_module')->where('controller', $controller)->get()->row_array();
		$data = $module['id'];
		return $data;
	}
	protected function checkpermission(){
		if($this->CI_auth->check_logged()){
			$id_role = $this->get_roleid();
			$id_module = $this->get_moduleid();
			$permission = $this->db->select('active')->from('dev_permission')->where(array('id_role' => $id_role, 'id_module' => $id_module))->get()->row_array();
			$data = $permission['active'];
			return $data;
		}
		
	}
}