<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends MY_Controller {
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
		$data['title'] = 'Quản lý media';
		$data['template'] = 'backend/media/index';

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/media/index/';
		$config['total_rows'] = $this->query_sql->total('dev_media');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['media'] = $this->query_sql->view('id, created, name,publish,image','dev_media',($page * $config['per_page']),$config['per_page']);
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
		$data['title'] = 'Thêm media';
		$data['template'] = 'backend/media/add';
		if($this->input->post()){
			$alias = $this->CI_function->check_alias(0,$this->CI_function->create_alias($this->input->post('name')),'','dev_media');
			if($_FILES["image"]["name"]){
				$album_dir = 'upload/media/';
				if(!is_dir($album_dir)){ create_dir($album_dir); } 
				$config['upload_path']	= $album_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config['max_size'] = 5120;

				
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				$image = $this->upload->do_upload("image");
				$image_data = $this->upload->data();

			    $name_img = $image_data['file_name'];
			}else{
				$name_img = '';
			}
			if($_FILES["image_bg"]["name"]){
				$album_dir_bg = 'upload/media/';
				if(!is_dir($album_dir_bg)){ create_dir($album_dir_bg); } 
				$config_bg['upload_path']	= $album_dir_bg;
				$config_bg['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config_bg['max_size'] = 5120;

				
				$this->load->library('upload', $config_bg); 
				$this->upload->initialize($config_bg); 
				$image_bg = $this->upload->do_upload("image_bg");
				$image_data_bg = $this->upload->data();

			    $name_image_bg = $image_data_bg['file_name'];
			}else{
				$name_image_bg = '';
			}
			$data_insert = array(
				'name' 			=> 	$this->input->post('name'),
				'title' 		=> 	$this->input->post('title'),
				'alias' 		=> 	$alias,
				'link' 			=> 	$this->input->post('link'),
				'publish' 		=> 	$this->input->post('publish'),
				'image'			=>	$name_img,
				'image_bg'		=>	$name_image_bg,
				'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
				'meta_description' 	=> 	$this->input->post('meta_description'),
				'content'		=>	$this->input->post('content'),
				'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
			);

			
			$flag = $this->query_sql->add('dev_media', $data_insert);
			$flag = $this->db->affected_rows();
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/media/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/media/index',$data);
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
			$data = $this->query_sql->select_row('dev_media', 'image,image_bg', array('id' => $id));
			$alias = $this->CI_function->check_alias($id,$this->CI_function->create_alias($this->input->post('name')),$this->input->post('name'),'dev_media');
			if($_FILES["image"]["name"]){
				$file = "upload/media/".$data['image'];
				unlink($file);

				$album_dir = 'upload/media/';
				if(!is_dir($album_dir)){ create_dir($album_dir); } 
				$config['upload_path']	= $album_dir;
				$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config['max_size'] = 5120;
				
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				$image = $this->upload->do_upload("image");
				$image_data = $this->upload->data();

			    $name_img = $image_data['file_name'];

			}else{
				$name_img = $data['image'];
				$name_img_thumb = $data['image_thumb'];
			}
			if($_FILES["image_bg"]["name"]){
				$file_bg = "upload/media/".$data['image_bg'];
				unlink($file_bg);

				$album_dir_bg = 'upload/media/';
				if(!is_dir($album_dir_bg)){ create_dir($album_dir_bg); } 
				$config_bg['upload_path']	= $album_dir_bg;
				$config_bg['allowed_types'] = 'jpg|png|jpeg|gif'; 
				$config_bg['max_size'] = 5120;
				
				$this->load->library('upload', $config_bg); 
				$this->upload->initialize($config_bg); 
				$image_bg = $this->upload->do_upload("image_bg");
				$image_data_bg = $this->upload->data();

			    $name_image_bg = $image_data_bg['file_name'];

			}else{
				$name_image_bg = $data['image_bg'];
			}
			$data_update = array(
				'name' 			=> 	$this->input->post('name'),
				'title' 		=> 	$this->input->post('title'),
				'alias' 		=> 	$alias,
				'link' 			=> 	$this->input->post('link'),
				'publish' 		=> 	$this->input->post('publish'),
				'image'			=>	$name_img,
				'image_bg'		=>	$name_image_bg,
				'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
				'meta_description' 	=> 	$this->input->post('meta_description'),
				'content'		=>	$this->input->post('content'),
				'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
			);
			$flag = $this->query_sql->edit('dev_media', $data_update, array('id' => $id));
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/media/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/media/index',$data);
			}	
		}
		$data['media'] = $this->query_sql->select_row('dev_media', '*', array('id' => $id));
		$data['title'] = 'Cập nhật media';
		$data['template'] = 'backend/media/edit';
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
		$data = $this->query_sql->select_row('dev_media', 'image,image_bg', array('id' => $id));
		$file = "upload/media/".$data['image'];
		$file_bg = "upload/media/".$data['image_bg'];
		unlink($file);
		unlink($file_bg);
		$this->query_sql->del('dev_media',array('id' => $id));
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
		$sql = $this->query_sql->select_row('dev_media','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_media', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('dev_media','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/media/show', $data_publish);
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
		$sql = $this->query_sql->select_row('dev_media','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_media', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('dev_media','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/media/showall', $data_publish);
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
        	$data = $this->query_sql->select_row('dev_media', 'image,image_bg', array('id' => $value));
			$file = "upload/media/".$data['image'];
			$file_bg = "upload/media/".$data['image_bg'];
			unlink($file);
			unlink($file_bg);
        	$this->query_sql->del('dev_media',array('id' => $value));
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
		$this->query_sql->edit('dev_media', $data_update, array('id' => $id));
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
    	$data_like['name'] = $keyword;
    	$data['media'] = $this->query_sql->select_like('dev_media','id, created, name,publish,image',$data_like,'');
		$this->load->view('backend/media/search', isset($data)?$data:NULL);
    }
}
