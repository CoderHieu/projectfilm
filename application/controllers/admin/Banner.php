<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends MY_Controller {
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
		$data['title'] = 'Quản lý banner';
		
		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/banner/index/';
		$config['total_rows'] = $this->query_sql->total('ci_image');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['banner'] = $this->query_sql->view('id, name, created, publish, sort,image, url','ci_image',($page * $config['per_page']),$config['per_page']);
		}
		
		$data['template'] = 'backend/banner/index';
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
		$data['title'] = 'Thêm banner';
		$data['template'] = 'backend/banner/add';
		if($this->input->post()){
			$this->form_validation->set_rules('name','Tên','trim|required');
			if($this->form_validation->run()){
				if($_FILES["image"]["name"]){
					$album_dir = 'upload/banner/';
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
					$config['source_image'] = 'upload/banner/'.$image_data['file_name'];
					$config['new_image'] = 'upload/banner/thumb/'.$image_data['file_name'];
					$config['create_thumb'] = TRUE;
    				$config['maintain_ratio'] = TRUE;
					$config['width'] = 250;
					$config['height'] = 250;

					$name_img = explode('.',$image_data['file_name']);
					$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];
					
				    $this->image_lib->initialize($config);
				    $this->image_lib->resize();

					$data_insert = array(
						'name' 			=> 	$this->input->post('name'),
						'url' 			=> 	$this->input->post('url'),
						'auto' 			=> 	$this->input->post('auto'),
						'width' 		=> 	$this->input->post('width'),
						'height' 		=> 	$this->input->post('height'),
						'type' 			=> 	'banner',
						'image'			=>	$image_data['file_name'],
						'image_thumb'	=>	$name_img_thumb,
						'publish'		=>	$this->input->post('publish'),
						'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
					);

				}else{
					$data_insert = array(
						'name' 			=> 	$this->input->post('name'),
						'url' 			=> 	$this->input->post('url'),
						'auto' 			=> 	$this->input->post('auto'),
						'width' 		=> 	$this->input->post('width'),
						'height' 		=> 	$this->input->post('height'),
						'type' 			=> 	'banner',
						'publish'		=>	$this->input->post('publish'),
						'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
					);
				}
				$flag = $this->query_sql->add('ci_image', $data_insert);
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/banner/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/banner/index',$data);
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
				if($_FILES["image"]["name"]){

					$data = $this->query_sql->select_row('ci_image', 'image,image_thumb', array('id' => $id));
					$file = "upload/banner/".$data['image'];
					$file_thumb = "upload/banner/thumb/".$data['image_thumb'];
					unlink($file);
					unlink($file_thumb);

					$album_dir = 'upload/banner/';
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
					$config['source_image'] = 'upload/banner/'.$image_data['file_name'];
					$config['new_image'] = 'upload/banner/thumb/'.$image_data['file_name'];
					$config['create_thumb'] = TRUE;
    				$config['maintain_ratio'] = TRUE;
					$config['width'] = 250;
					$config['height'] = 250;

					$name_img = explode('.',$image_data['file_name']);
					$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];

					$this->image_lib->initialize($config);
				    $this->image_lib->resize();

					$data_update = array(
						'name' 			=> 	$this->input->post('name'),
						'url' 			=> 	$this->input->post('url'),
						'auto' 			=> 	$this->input->post('auto'),
						'width' 		=> 	$this->input->post('width'),
						'height' 		=> 	$this->input->post('height'),
						'image'			=>	$image_data['file_name'],
						'image_thumb'	=>	$name_img_thumb,
						'publish'		=>	$this->input->post('publish'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600),
					);

				}else{
					$data_update = array(
						'name' 			=> 	$this->input->post('name'),
						'url' 			=> 	$this->input->post('url'),
						'auto' 			=> 	$this->input->post('auto'),
						'width' 		=> 	$this->input->post('width'),
						'height' 		=> 	$this->input->post('height'),
						'publish'		=>	$this->input->post('publish'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600),
					);
				}
				$flag = $this->query_sql->edit('ci_image', $data_update, array('id' => $id));
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/banner/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/banner/index',$data);
				}	
			}
		}
		$data['banner'] = $this->query_sql->select_row('ci_image', 'id, name,url,image,width,height,type,auto, created, publish', array('id' => $id));
		$data['title'] = 'Cập nhật banner';
		$data['template'] = 'backend/banner/edit';
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
		$data = $this->query_sql->select_row('ci_image', 'image,image_thumb', array('id' => $id));
		$file = "upload/banner/".$data['image'];
		$file_thumb = "upload/banner/thumb/".$data['image_thumb'];
		unlink($file);
		unlink($file_thumb);
		$this->query_sql->del('ci_image',array('id' => $id));
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
		$sql = $this->query_sql->select_row('ci_image','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('ci_image', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('ci_image','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/banner/show', $data_publish);
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
		$sql = $this->query_sql->select_row('ci_image','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('ci_image', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('ci_image','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/banner/showall', $data_publish);
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
			$data = $this->query_sql->select_row('ci_image', 'image,image_thumb', array('id' => $value));
			$file = "upload/banner/".$data['image'];
			$file_thumb = "upload/banner/thumb/".$data['image_thumb'];
			unlink($file);
			unlink($file_thumb);
        	$this->query_sql->del('ci_image',array('id' => $value));
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
		$this->query_sql->edit('ci_image', $data_update, array('id' => $id));
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
    	$data['banner'] = $this->query_sql->select_like('ci_image','id, name, created, publish, sort,image, url',$data_like,'');
		$this->load->view('backend/banner/search', isset($data)?$data:NULL);
    }
}
