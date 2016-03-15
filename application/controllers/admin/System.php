<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('query_sql');

	}
	public function __destruct(){
	}
	public function index()
	{
		if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
		if($this->input->post()){
			$this->form_validation->set_rules('title','Tiêu đề','trim|required');
			if($this->form_validation->run()){
				$status = $this->input->post('status');
				$content = $this->input->post('content');
				$close_site = array(
					'status' 	=> $status,
					'content'	=> $content
				);
				$close_site = json_encode($close_site);
				
				if($_FILES["favicon"]["name"]){

					$data = $this->query_sql->select_row('dev_system', 'favicon', array('id' => 1));
					if($data['favicon'] != ''){
						$file = "upload/system/".$data['favicon'];
						unlink($file);
					}

					$album_dir = 'upload/system/';
					if(!is_dir($album_dir)){ create_dir($album_dir); } 
					$config['upload_path']	= $album_dir;
					$config['allowed_types'] = 'jpg|png|jpeg|gif'; 
					$config['max_size'] = 5120;
					
					$this->load->library('upload', $config); 
					$this->upload->initialize($config); 
					$image = $this->upload->do_upload("favicon");
					$image_data = $this->upload->data();

					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image'] = 'upload/system/'.$image_data['file_name'];
					$config['create_thumb'] = TRUE;
    				$config['maintain_ratio'] = TRUE;
					$config['width'] = 30;
					$config['height'] = 30;

					$name_img = explode('.',$image_data['file_name']);
					$name_img_thumb = $name_img[0].'_thumb.'.$name_img[1];

					$this->image_lib->initialize($config);
				    $this->image_lib->resize();

					$data_update = array(
						'title' 		=> 	$this->input->post('title'),
						'close_site' 		=> 	$close_site,
						'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
						'meta_description' 	=> 	$this->input->post('meta_description'),
						'favicon'		=>	$name_img_thumb,
						'analytics'		=>	$this->input->post('analytics'),
						'webmaster'		=>	$this->input->post('webmaster'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600),
					);

				}else{
					$data_update = array(
						'title' 		=> 	$this->input->post('title'),
						'close_site' 		=> 	$close_site,
						'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
						'meta_description' 	=> 	$this->input->post('meta_description'),
						'analytics'		=>	$this->input->post('analytics'),
						'webmaster'		=>	$this->input->post('webmaster'),
						'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600),
					);
				}
				$flag = $this->query_sql->edit('dev_system', $data_update, array('id' => 1));
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/system/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/system/index',$data);
				}	
			}
		}
		$data['system'] = $this->query_sql->select_row('dev_system', '*', array('id' => 1));
		$close_site = json_decode($data['system']['close_site'], true);
		$data['system']['status'] = $close_site['status'];
		$data['system']['content'] = $close_site['content'];
		$data['title'] = 'Cấu hình chung';
		$data['template'] = 'backend/system/index';
		$this->load->view('backend/index', isset($data)?$data:'');
	}
}
