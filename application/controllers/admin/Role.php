<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('query_sql');

	}
	public function __destruct(){
	}
	public function index($page = 1)
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$data['title'] = 'Quản lý nhóm người dùng';
		$data['template'] = 'backend/role/index';
		$data['data_index'] = $this->get_index();
		

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/role/index/';
		$config['total_rows'] = $this->query_sql->total('ci_role');
		$config['uri_segment'] = 4; 
		$config['per_page'] = 10; 
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['role'] = $this->query_sql->view('id, name, created, publish, sort','ci_role',($page * $config['per_page']),$config['per_page']);
		}

		$this->load->view('backend/index', isset($data)?$data:NULL);
	}
	public function add()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$data['title'] = 'Thêm nhóm người dùng';
		$data['template'] = 'backend/role/add';
		if($this->input->post()){
			$this->form_validation->set_rules('name','Tên','trim|required');
			if($this->form_validation->run()){
				$data_insert = array(
					'name' 			=> 	$this->input->post('name'),
					'publish'		=>	$this->input->post('publish'),
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->add('ci_role', $data_insert);
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/role/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/role/index',$data);
				}	
			}
		}
		$this->load->view('backend/index', isset($data)?$data:NULL);
	}
	public function edit($id=0)
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		if($this->input->post()){
			$this->form_validation->set_rules('name','Tiêu đề','trim|required');
			if($this->form_validation->run()){
				
				$data_update = array(
					'name' 			=> 	$this->input->post('name'),
					'publish'		=>	$this->input->post('publish'),
					'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->edit('ci_role', $data_update, array('id' => $id));
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/role/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/role/index',$data);
				}	
			}
		}
		
		$data['role'] = $this->query_sql->select_row('ci_role', 'id, name, created, publish', array('id' => $id));
		$data['title'] = 'Cập nhật nhóm người dùng';
		$data['template'] = 'backend/role/edit';
		$this->load->view('backend/index', isset($data)?$data:'');
	}
	public function delete()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$id = $_POST['id'];
		$this->query_sql->del('ci_role',array('id' => $id));
	}
	public function show()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$id = $_POST['id'];
		$sql = $this->query_sql->select_row('ci_role','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('ci_role', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('ci_role','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/role/show', $data_publish);
	}
	public function showall()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$listid = $_POST['listid'];
		$sql = $this->query_sql->select_row('ci_role','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('ci_role', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('ci_role','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/role/showall', $data_publish);
	}
	public function deleteall()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$listid = $_POST['listid'];
        $list_id = explode(',', $listid);
        foreach ($list_id as $key => $value) {
        	$this->query_sql->del('ci_role',array('id' => $value));
        }
	}
	public function sort()
    {
    	if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
    	$id = $_POST['id'];
    	$sort = $_POST['sort'];
		$data_update['sort'] = $sort;
		$this->query_sql->edit('ci_role', $data_update, array('id' => $id));
    }
    public function permission()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$data['id_role'] = $_GET['id_role'];
		$data['title'] = 'Phân quyền nhóm người dùng';
		$data['data_index'] = $this->get_index();
		$data['template'] = 'backend/role/permission';
		

		$data['module'] = $this->query_sql->select_array('ci_module','id, name',array('parentid' => 0));
		if(isset($data['module']) && $data['module'] != NULL){
			foreach ($data['module'] as $key => $val) {
				$data_child = $this->query_sql->select_array('ci_module','id, name, parentid',array('parentid' => $val['id']));
				$data['module'][$key]['module_child'] = $data_child;
				$permission = $this->query_sql->select_row('dev_permission', 'active', array('id_role' => $data['id_role'], 'id_module' => $val['id']));
				$data['module'][$key]['active'] = $permission['active'];
				if(isset($data['module'][$key]['module_child']) && $data['module'][$key]['module_child'] != NULL){
					foreach ($data['module'][$key]['module_child'] as $key_child => $val_child) {
						$permission_chil = $this->query_sql->select_row('dev_permission', 'active', array('id_role' => $data['id_role'], 'id_module' => $val_child['id']));
						$data['module'][$key]['module_child'][$key_child]['active'] = $permission_chil['active'];
					}
				}
			}
		}
		$this->load->view('backend/index', isset($data)?$data:NULL);
	}
	public function updatepermission()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$listid = $_POST['listid'];
		$unlistid = $_POST['unlistid'];
		$id_role = $_POST['id_role'];
        $list_id = explode(',', $listid);
        $unlist_id = explode(',', $unlistid);
        foreach ($list_id as $key => $value) {
        	$permission = $this->query_sql->select_row('dev_permission', 'id,active', array('id_role' => $id_role, 'id_module' => $value));
        	if($permission != NULL){
        		$data = array(
					'id_role' 		=> 	$id_role,
					'id_module'		=>	$value,
					'active'		=>	1,
					'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->edit('dev_permission', $data, array('id_role' => $id_role, 'id_module' => $value));
        	}else{
        		$data = array(
					'id_role' 		=> 	$id_role,
					'id_module'		=>	$value,
					'active'		=>	1,
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->add('dev_permission', $data);
        	}
        }
        foreach ($unlist_id as $key_un => $val_un) {
        	$permission_un = $this->query_sql->select_row('dev_permission', 'id,active', array('id_role' => $id_role, 'id_module' => $val_un));
        	if($permission_un != NULL){
        		$data_un = array(
					'id_role' 		=> 	$id_role,
					'id_module'		=>	$val_un,
					'active'		=>	0,
					'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->edit('dev_permission', $data_un, array('id_role' => $id_role, 'id_module' => $val_un));
        	}else{
        		$data_un = array(
					'id_role' 		=> 	$id_role,
					'id_module'		=>	$val_un,
					'active'		=>	0,
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->add('dev_permission', $data_un);
        	}
        }
	}
}
