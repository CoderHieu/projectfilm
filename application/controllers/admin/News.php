<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {
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
		$data['title'] = 'Quản lý bài viết';
		$data['template'] = 'backend/news/index';

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/news/index/';
		$config['total_rows'] = $this->query_sql->total('dev_news');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['news'] = $this->query_sql->view('id, created, name,publish,image_thumb,typeid','dev_news',($page * $config['per_page']),$config['per_page']);
			if(isset($data['news']) && $data['news']!=NULL){
				foreach ($data['news'] as $key => $val) {
					$type = $this->query_sql->select_row('dev_menu', 'name', array('id' => $val['typeid']));
					$data['news'][$key]['type_name'] = $type['name'];
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
		$data['title'] = 'Thêm bài viết';
		$data['template'] = 'backend/news/add';
		if($this->input->post()){
			$alias = $this->CI_function->check_alias(0,$this->CI_function->create_alias($this->input->post('name')),'','dev_news');
			if($_FILES["image"]["name"]){
				$album_dir = 'upload/news/';
				if(!is_dir($album_dir)){ create_dir($album_dir); } 
				$config['upload_path']	= $album_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config['max_size'] = 5120;

				
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				$image = $this->upload->do_upload("image");
				$image_data = $this->upload->data();


				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'upload/news/'.$image_data['file_name'];
				$config['new_image'] = 'upload/news/thumb/'.$image_data['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 100;

				$name_img = explode('.',$image_data['file_name']);
				$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];
				
			    $this->image_lib->initialize($config);
			    $this->image_lib->resize();

			    $name_img = $image_data['file_name'];
			}else{
				$name_img = '';
				$name_img_thumb = '';
			}
			$data_insert = array(
				'typeid' 		=> 	$this->input->post('typeid'),
				'name' 			=> 	$this->input->post('name'),
				'title' 		=> 	$this->input->post('title'),
				'alias' 		=> 	$alias,
				'publish' 		=> 	$this->input->post('publish'),
				'is_hot' 		=> 	$this->input->post('is_hot'),
				'is_home' 		=> 	$this->input->post('is_home'),
				'image'			=>	$name_img,
				'image_thumb'	=>	$name_img_thumb,
				'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
				'meta_description' 	=> 	$this->input->post('meta_description'),
				'content'		=>	$this->input->post('content'),
				'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
			);

			
			$flag = $this->query_sql->add('dev_news', $data_insert);
			$flag = $this->db->affected_rows();
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/news/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/news/index',$data);
			}	
		}
		$data['type'] = $this->query_sql->select_array('dev_menu','id, name',array('parentid' => 0,'type' => 2));
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
			$data = $this->query_sql->select_row('dev_news', 'image,image_thumb', array('id' => $id));
			$alias = $this->CI_function->check_alias($id,$this->CI_function->create_alias($this->input->post('name')),$this->input->post('name'),'dev_news');
			if($_FILES["image"]["name"]){
				$file = "upload/news/".$data['image'];
				$file_thumb = "upload/news/thumb/".$data['image_thumb'];
				unlink($file);
				unlink($file_thumb);

				$album_dir = 'upload/news/';
				if(!is_dir($album_dir)){ create_dir($album_dir); } 
				$config['upload_path']	= $album_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config['max_size'] = 5120;
				
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				$image = $this->upload->do_upload("image");
				$image_data = $this->upload->data();

				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'upload/news/'.$image_data['file_name'];
				$config['new_image'] = 'upload/news/thumb/'.$image_data['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 300;

				$name_img = explode('.',$image_data['file_name']);
				$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];

				$this->image_lib->initialize($config);
			    $this->image_lib->resize();

			    $name_img = $image_data['file_name'];

			}else{
				$name_img = $data['image'];
				$name_img_thumb = $data['image_thumb'];
			}
			$data_update = array(
				'typeid' 		=> 	$this->input->post('typeid'),
				'name' 			=> 	$this->input->post('name'),
				'title' 		=> 	$this->input->post('title'),
				'alias' 		=> 	$alias,
				'publish' 		=> 	$this->input->post('publish'),
				'is_hot' 		=> 	$this->input->post('is_hot'),
				'is_home' 		=> 	$this->input->post('is_home'),
				'image'			=>	$name_img,
				'image_thumb'	=>	$name_img_thumb,
				'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
				'meta_description' 	=> 	$this->input->post('meta_description'),
				'content'		=>	$this->input->post('content'),
				'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
			);
			$flag = $this->query_sql->edit('dev_news', $data_update, array('id' => $id));
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/news/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/news/index',$data);
			}	
		}
		$data['news'] = $this->query_sql->select_row('dev_news', '*', array('id' => $id));
		$data['type'] = $this->query_sql->select_array('dev_menu','id, name',array('parentid' => 0,'type' => 2));
		$data['title'] = 'Cập nhật bài viết';
		$data['template'] = 'backend/news/edit';
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
		$data = $this->query_sql->select_row('dev_news', 'image,image_thumb', array('id' => $id));
		$file = "upload/news/".$data['image'];
		$file_thumb = "upload/news/thumb/".$data['image_thumb'];
		unlink($file);
		unlink($file_thumb);
		$this->query_sql->del('dev_news',array('id' => $id));
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
		$sql = $this->query_sql->select_row('dev_news','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_news', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('dev_news','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/news/show', $data_publish);
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
		$sql = $this->query_sql->select_row('dev_news','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_news', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('dev_news','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/news/showall', $data_publish);
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
        	$data = $this->query_sql->select_row('dev_news', 'image,image_thumb', array('id' => $value));
			$file = "upload/news/".$data['image'];
			$file_thumb = "upload/news/thumb/".$data['image_thumb'];
			unlink($file);
			unlink($file_thumb);
        	$this->query_sql->del('dev_news',array('id' => $value));
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
		$this->query_sql->edit('dev_news', $data_update, array('id' => $id));
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
    	if($keyword != ''){
    		$data_like['name'] = $keyword;
    		$data['news'] = $this->query_sql->select_like('dev_news','id,created, name,publish,image_thumb,typeid',$data_like,'');
    		if(isset($data['news']) && $data['news']!=NULL){
				foreach ($data['news'] as $key => $val) {
					$type = $this->query_sql->select_row('dev_menu', 'name', array('id' => $val['typeid']));
					$data['news'][$key]['type_name'] = $type['name'];
				}
			}
		}
		$this->load->view('backend/news/search', isset($data)?$data:NULL);
    }
}
