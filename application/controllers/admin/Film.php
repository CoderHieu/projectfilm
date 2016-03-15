<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Film extends MY_Controller {
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
		$data['title'] = 'Quản lý phim';
		$data['template'] = 'backend/film/index';

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/film/index/';
		$config['total_rows'] = $this->query_sql->total('dev_film');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['film'] = $this->query_sql->view('id, created, name,publish,image_thumb,typeid,cateid,countryid','dev_film',($page * $config['per_page']),$config['per_page']);
			if(isset($data['film']) && $data['film']!=NULL){
				foreach ($data['film'] as $key => $val) {
					$type = $this->query_sql->select_row('dev_menu', 'name', array('id' => $val['typeid'],'type' => 0));
					$data['film'][$key]['type_name'] = $type['name'];

					$cate = $this->query_sql->select_row('dev_menu', 'name', array('id' => $val['cateid']));
					$data['film'][$key]['cate_name'] = $cate['name'];

					$country = $this->query_sql->select_row('dev_country', 'name', array('id' => $val['countryid']));
					$data['film'][$key]['country_name'] = $country['name'];
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
		$data['title'] = 'Thêm phim';
		$data['template'] = 'backend/film/add';
		if($this->input->post()){
			$alias = $this->CI_function->check_alias(0,$this->CI_function->create_alias($this->input->post('name')),'','dev_film');
			if($_FILES["image"]["name"]){
				$album_dir = 'upload/film/';
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
				$config['source_image'] = 'upload/film/'.$image_data['file_name'];
				$config['new_image'] = 'upload/film/thumb/'.$image_data['file_name'];
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
			if($_FILES["image_bg"]["name"]){
				$album_dir_bg = 'upload/film/';
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
				'typeid' 		=> 	$this->input->post('typeid'),
				'cateid' 		=> 	$this->input->post('cateid'),
				'name' 			=> 	$this->input->post('name'),
				'title' 		=> 	$this->input->post('title'),
				'alias' 		=> 	$alias,
				'released' 		=> 	$this->input->post('released'),
				'publish' 		=> 	$this->input->post('publish'),
				'is_hot' 		=> 	$this->input->post('is_hot'),
				'is_slider' 	=> 	$this->input->post('is_slider'),
				'image'			=>	$name_img,
				'image_thumb'	=>	$name_img_thumb,
				'image_bg'		=>	$name_image_bg,
				'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
				'meta_description' 	=> 	$this->input->post('meta_description'),
				'countryid' 	=> 	$this->input->post('countryid'),
				'qualityid'		=>	$this->input->post('qualityid'),
				'status'		=>	$this->input->post('status'),
				'content'		=>	$this->input->post('content'),
				'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
			);

			
			$flag = $this->query_sql->add('dev_film', $data_insert);
			$flag = $this->db->affected_rows();
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/film/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/film/index',$data);
			}	
		}
		$data['type'] = $this->query_sql->select_array('dev_menu','id, name',array('parentid' => 0,'type' => 0));
		$data['country'] = $this->query_sql->select_array('dev_country','id, name',NULL);
		$data['quality'] = $this->query_sql->select_array('dev_quality','id, name',NULL);
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
			$data = $this->query_sql->select_row('dev_film', 'image,image_thumb,image_bg', array('id' => $id));
			$alias = $this->CI_function->check_alias($id,$this->CI_function->create_alias($this->input->post('name')),$this->input->post('name'),'dev_film');
			if($_FILES["image"]["name"]){
				$file = "upload/film/".$data['image'];
				$file_thumb = "upload/film/thumb/".$data['image_thumb'];
				unlink($file);
				unlink($file_thumb);

				$album_dir = 'upload/film/';
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
				$config['source_image'] = 'upload/film/'.$image_data['file_name'];
				$config['new_image'] = 'upload/film/thumb/'.$image_data['file_name'];
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
			if($_FILES["image_bg"]["name"]){
				$file_bg = "upload/film/".$data['image_bg'];
				unlink($file_bg);

				$album_dir_bg = 'upload/film/';
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
				'typeid' 		=> 	$this->input->post('typeid'),
				'cateid' 		=> 	$this->input->post('cateid'),
				'name' 			=> 	$this->input->post('name'),
				'title' 		=> 	$this->input->post('title'),
				'alias' 		=> 	$alias,
				'released' 		=> 	$this->input->post('released'),
				'publish' 		=> 	$this->input->post('publish'),
				'is_hot' 		=> 	$this->input->post('is_hot'),
				'is_slider' 	=> 	$this->input->post('is_slider'),
				'image'			=>	$name_img,
				'image_thumb'	=>	$name_img_thumb,
				'image_bg'		=>	$name_image_bg,
				'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
				'meta_description' 	=> 	$this->input->post('meta_description'),
				'countryid' 	=> 	$this->input->post('countryid'),
				'qualityid'		=>	$this->input->post('qualityid'),
				'status'		=>	$this->input->post('status'),
				'content'		=>	$this->input->post('content'),
				'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
			);
			$flag = $this->query_sql->edit('dev_film', $data_update, array('id' => $id));
			if($flag>0){
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'sucess',
					'message'	=> 'Thành công!',
				));
				redirect('admin/film/index',$data);
			}else{
				$this->session->set_flashdata('message_flashdata', array(
					'type'		=> 'error',
					'message'	=> 'Thất bại!',
				));
				redirect('admin/film/index',$data);
			}	
		}
		$data['film'] = $this->query_sql->select_row('dev_film', '*', array('id' => $id));
		$data['type'] = $this->query_sql->select_array('dev_menu','id, name',array('parentid' => 0,'type' => 0));
		$data['cate'] = $this->query_sql->select_array('dev_menu','id, name',array('parentid' => $data['film']['typeid']));
		$data['country'] = $this->query_sql->select_array('dev_country','id, name',NULL);
		$data['quality'] = $this->query_sql->select_array('dev_quality','id, name',NULL);
		$data['title'] = 'Cập nhật phim';
		$data['template'] = 'backend/film/edit';
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
		$data = $this->query_sql->select_row('dev_film', 'image,image_thumb,image_bg', array('id' => $id));
		$file = "upload/film/".$data['image'];
		$file_bg = "upload/film/".$data['image_bg'];
		$file_thumb = "upload/film/thumb/".$data['image_thumb'];
		unlink($file);
		unlink($file_bg);
		unlink($file_thumb);
		$this->query_sql->del('dev_film',array('id' => $id));
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
		$sql = $this->query_sql->select_row('dev_film','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_film', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('dev_film','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/film/show', $data_publish);
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
		$sql = $this->query_sql->select_row('dev_film','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_film', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('dev_film','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/film/showall', $data_publish);
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
        	$data = $this->query_sql->select_row('dev_film', 'image,image_thumb,image_bg', array('id' => $value));
			$file = "upload/film/".$data['image'];
			$file_bg = "upload/film/".$data['image_bg'];
			$file_thumb = "upload/film/thumb/".$data['image_thumb'];
			unlink($file);
			unlink($file_bg);
			unlink($file_thumb);
        	$this->query_sql->del('dev_film',array('id' => $value));
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
		$this->query_sql->edit('dev_film', $data_update, array('id' => $id));
    }
    public function listcate()
    {
    	if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
    	$typeid = $_POST['typeid'];
    	$data['cate'] = $this->query_sql->select_array('dev_menu','id, name',array('parentid' => $typeid));
    	$this->load->view('backend/film/listcate', $data);
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
    		$data['film'] = $this->query_sql->select_like('dev_film','id, created, name,publish,image_thumb,typeid,cateid,countryid',$data_like,'');
    		if(isset($data['film']) && $data['film']!=NULL){
				foreach ($data['film'] as $key => $val) {
					$type = $this->query_sql->select_row('dev_menu', 'name', array('id' => $val['typeid'],'type' => 0));
					$data['film'][$key]['type_name'] = $type['name'];

					$cate = $this->query_sql->select_row('dev_menu', 'name', array('id' => $val['cateid']));
					$data['film'][$key]['cate_name'] = $cate['name'];

					$country = $this->query_sql->select_row('dev_country', 'name', array('id' => $val['countryid']));
					$data['film'][$key]['country_name'] = $country['name'];
				}
			}
		}
		$this->load->view('backend/film/search', isset($data)?$data:NULL);
    }
}
