<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
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
		$data['title'] = 'Quản lý thành viên';
		
		$data['template'] = 'backend/user/index';

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/user/index/';
		$config['total_rows'] = $this->query_sql->total('ci_user');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['user'] = $this->query_sql->view('id, fullname, created, username,active,id_role,avatar_thumb','ci_user',($page * $config['per_page']),$config['per_page']);
			if(!is_null($data['user'])){
				foreach ($data['user'] as $key => $val) {
					$role_row = $this->query_sql->select_row('ci_role', 'name', array('id' => $val['id_role']));
					$data['user'][$key]['role_name'] = $role_row['name'];
				}
			}
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
		$data['title'] = 'Thêm thành viên';
		$data['template'] = 'backend/user/add';
		if($this->input->post()){
			$rand_salt = $this->CI_encrypt->genRndSalt();
			$encrypt_pass = $this->CI_encrypt->encryptUserPwd( $this->input->post('password'),$rand_salt);

			if($_FILES["avatar"]["name"]){
				$album_dir = 'upload/user/';
				if(!is_dir($album_dir)){ create_dir($album_dir); } 
				$config['upload_path']	= $album_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config['max_size'] = 5120;

				
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				$image = $this->upload->do_upload("avatar");
				$image_data = $this->upload->data();


				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'upload/user/'.$image_data['file_name'];
				$config['new_image'] = 'upload/user/thumb/'.$image_data['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 30;
				$config['height'] = 30;

				$name_img = explode('.',$image_data['file_name']);
				$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];
				
			    $this->image_lib->initialize($config);
			    $this->image_lib->resize();


			    $data_insert = array(
					'username' 		=> 	$this->input->post('username'),
					'password' 		=> 	$encrypt_pass,
					'sex' 			=> 	$this->input->post('sex'),
					'birthday' 		=> 	$this->input->post('birthday'),
					'email' 		=> 	$this->input->post('email'),
					'phone' 		=> 	$this->input->post('phone'),
					'id_role' 		=> 	$this->input->post('id_role'),
					'avatar'		=>	$image_data['file_name'],
					'avatar_thumb'	=>	$name_img_thumb,
					'salt' 			=>  $rand_salt,
					'fullname' 		=> 	$this->input->post('fullname'),
					'active'		=>	$this->input->post('active'),
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
			}else{
				$data_insert = array(
					'username' 		=> 	$this->input->post('username'),
					'password' 		=> 	$encrypt_pass,
					'sex' 			=> 	$this->input->post('sex'),
					'birthday' 		=> 	$this->input->post('birthday'),
					'email' 		=> 	$this->input->post('email'),
					'phone' 		=> 	$this->input->post('phone'),
					'id_role' 		=> 	$this->input->post('id_role'),
					'salt' 			=>  $rand_salt,
					'fullname' 		=> 	$this->input->post('fullname'),
					'active'		=>	$this->input->post('active'),
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
			}

			
			$flag = $this->query_sql->add('ci_user', $data_insert);
			$flag = $this->db->affected_rows();
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/user/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/user/index',$data);
			}	
		}
		$data['role'] = $this->query_sql->select_array('ci_role','id, name, created, publish',NULL);
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
			$rand_salt = $this->CI_encrypt->genRndSalt();
			if($_FILES["avatar"]["name"]){
				$data = $this->query_sql->select_row('ci_user', 'avatar,avatar_thumb', array('id' => $id));
				$file = "upload/user/".$data['avatar'];
				$file_thumb = "upload/user/thumb/".$data['avatar_thumb'];
				unlink($file);
				unlink($file_thumb);

				$album_dir = 'upload/user/';
				if(!is_dir($album_dir)){ create_dir($album_dir); } 
				$config['upload_path']	= $album_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config['max_size'] = 5120;
				
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				$image = $this->upload->do_upload("avatar");
				$image_data = $this->upload->data();

				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'upload/user/'.$image_data['file_name'];
				$config['new_image'] = 'upload/user/thumb/'.$image_data['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 30;
				$config['height'] = 30;

				$name_img = explode('.',$image_data['file_name']);
				$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];

				$this->image_lib->initialize($config);
			    $this->image_lib->resize();

			    if($this->input->post('password') != ''){
			    	$data_edit = array(
			    		'password' 		=> 	$encrypt_pass,
			    		'salt' 			=>  $rand_salt,
						'sex' 			=> 	$this->input->post('sex'),
						'birthday' 		=> 	$this->input->post('birthday'),
						'email' 		=> 	$this->input->post('email'),
						'phone' 		=> 	$this->input->post('phone'),
						'id_role' 		=> 	$this->input->post('id_role'),
						'fullname' 		=> 	$this->input->post('fullname'),
						'avatar'		=>	$image_data['file_name'],
						'avatar_thumb'	=>	$name_img_thumb,
						'active'		=>	$this->input->post('active'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
					);
			    }else{
			    	$data_edit = array(
						'sex' 			=> 	$this->input->post('sex'),
						'birthday' 		=> 	$this->input->post('birthday'),
						'email' 		=> 	$this->input->post('email'),
						'phone' 		=> 	$this->input->post('phone'),
						'id_role' 		=> 	$this->input->post('id_role'),
						'fullname' 		=> 	$this->input->post('fullname'),
						'avatar'		=>	$image_data['file_name'],
						'avatar_thumb'	=>	$name_img_thumb,
						'active'		=>	$this->input->post('active'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
					);
			    }
			}else{
				if($this->input->post('password') != ''){
					$encrypt_pass = $this->CI_encrypt->encryptUserPwd( $this->input->post('password'),$rand_salt);
					$data_edit = array(
						'password' 		=> 	$encrypt_pass,
						'salt' 			=>  $rand_salt,
						'sex' 			=> 	$this->input->post('sex'),
						'birthday' 		=> 	$this->input->post('birthday'),
						'email' 		=> 	$this->input->post('email'),
						'phone' 		=> 	$this->input->post('phone'),
						'id_role' 		=> 	$this->input->post('id_role'),
						'fullname' 		=> 	$this->input->post('fullname'),
						'active'		=>	$this->input->post('active'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
					);
				}else{
					$data_edit = array(
						'sex' 			=> 	$this->input->post('sex'),
						'birthday' 		=> 	$this->input->post('birthday'),
						'email' 		=> 	$this->input->post('email'),
						'phone' 		=> 	$this->input->post('phone'),
						'id_role' 		=> 	$this->input->post('id_role'),
						'fullname' 		=> 	$this->input->post('fullname'),
						'active'		=>	$this->input->post('active'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
					);
				}
			}
			$flag = $this->query_sql->edit('ci_user', $data_edit, array('id' => $id));
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/user/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/user/index',$data);
			}	
		}
		$data['role'] = $this->query_sql->select_array('ci_role','id, name, created, publish',NULL);
		$data['user'] = $this->query_sql->select_row('ci_user', 'id, fullname, created, sex,avatar_thumb, id_role, username,active,birthday,phone,email', array('id' => $id));
		$data['title'] = 'Cập nhật thành viên';
		$data['template'] = 'backend/user/edit';
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
		$data = $this->query_sql->select_row('ci_user', 'avatar,avatar_thumb', array('id' => $id));
		$file = "upload/user/".$data['avatar'];
		$file_thumb = "upload/user/thumb/".$data['avatar_thumb'];
		unlink($file);
		unlink($file_thumb);
		$this->query_sql->del('ci_user',array('id' => $id));
	}
	public function active()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		$id = $_POST['id'];
		$sql = $this->query_sql->select_row('ci_user','active',array('id' => $id));
		if($sql['active']==1){
			$active = 0;
		}else{
			$active = 1;
		}
		$data_update['active'] = $active;
		$this->query_sql->edit('ci_user', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('ci_user','active',array('id' => $id));
		$data_active['active'] = $data_sql['active'];
		$this->load->view('backend/user/active', $data_active);
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
        	$data = $this->query_sql->select_row('ci_user', 'avatar,avatar_thumb', array('id' => $value));
			$file = "upload/user/".$data['avatar'];
			$file_thumb = "upload/user/thumb/".$data['avatar_thumb'];
			unlink($file);
			unlink($file_thumb);
        	$this->query_sql->del('ci_user',array('id' => $value));
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
		$this->query_sql->edit('ci_user', $data_update, array('id' => $id));
    }
    public function search()
    {
    	if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
    	$keyword = $_POST['keyword'];
    	$data_like['fullname'] = $keyword;
    	$data['user'] = $this->query_sql->select_like('ci_user','id, fullname, created, username,active,id_role,avatar_thumb',$data_like,'');
    	if(!is_null($data['user'])){
			foreach ($data['user'] as $key => $val) {
				$role_row = $this->query_sql->select_row('ci_role', 'name', array('id' => $val['id_role']));
				$data['user'][$key]['role_name'] = $role_row['name'];
			}
		}
		$this->load->view('backend/user/search', isset($data)?$data:NULL);
    }
}
