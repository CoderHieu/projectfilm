<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {
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
		$data['title'] = 'Quản lý danh mục';
		$data['template'] = 'backend/menu/index';

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/menu/index/';
		$config['total_rows'] = $this->query_sql->total('dev_menu');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['menu'] = $this->query_sql->view_where('id, name, created, publish, sort, parentid','dev_menu',array('parentid' => 0),($page * $config['per_page']),$config['per_page']);
			foreach ($data['menu'] as $key => $val) {
				$data_child = $this->query_sql->select_array('dev_menu','id, name, created, publish, sort, parentid',array('parentid' => $val['id']));
				$data['menu'][$key]['menu_child'] = $data_child;
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
		$data['title'] = 'Thêm danh mục';
		$data['template'] = 'backend/menu/add';
		if($this->input->post()){
			$this->form_validation->set_rules('name','Tên','trim|required');
			if($this->form_validation->run()){
				$alias = $this->CI_function->check_alias(0,$this->CI_function->create_alias($this->input->post('name')),'','dev_menu');
				$data_insert = array(
					'name' 			=> 	$this->input->post('name'),
					'parentid' 		=> 	$this->input->post('parentid'),
					'type' 			=> 	$this->input->post('type'),
					'alias' 		=> 	$alias,
					'title' 		=> 	$this->input->post('title'),
					'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
					'meta_description' 	=> 	$this->input->post('meta_description'),
					'publish'		=>	$this->input->post('publish'),
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->add('dev_menu', $data_insert);
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/menu/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/menu/index',$data);
				}	
			}
		}
		$data['menu'] = $this->query_sql->select_array('dev_menu','id, name, created, publish, sort',array('parentid' => 0));
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
				$alias = $this->CI_function->check_alias($id,$this->CI_function->create_alias($this->input->post('name')),$this->input->post('name'),'dev_menu');
				$data_update = array(
					'name' 			=> 	$this->input->post('name'),
					'parentid' 		=> 	$this->input->post('parentid'),
					'type' 			=> 	$this->input->post('type'),
					'alias' 		=> 	$alias,
					'title' 		=> 	$this->input->post('title'),
					'meta_keyword' 	=> 	$this->input->post('meta_keyword'),
					'meta_description' 	=> 	$this->input->post('meta_description'),
					'publish'		=>	$this->input->post('publish'),
					'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->edit('dev_menu', $data_update, array('id' => $id));
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/menu/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/menu/index',$data);
				}	
			}
		}
		
		$data['menu'] = $this->query_sql->select_row('dev_menu', 'id, name, meta_keyword, meta_description, title, created, publish, parentid, type', array('id' => $id));

		$data['menus'] = $this->query_sql->select_array('dev_menu','id, name, created, publish, sort, parentid, type',array('parentid' => 0));
		
		$data['title'] = 'Cập nhật danh mục';
		$data['template'] = 'backend/menu/edit';
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
		$this->query_sql->del('dev_menu',array('id' => $id));
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
		$sql = $this->query_sql->select_row('dev_menu','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_menu', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('dev_menu','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/menu/show', $data_publish);
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
		$sql = $this->query_sql->select_row('dev_menu','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('dev_menu', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('dev_menu','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/menu/showall', $data_publish);
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
        	$this->query_sql->del('dev_menu',array('id' => $value));
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
		$this->query_sql->edit('dev_menu', $data_update, array('id' => $id));
    }
    public function changeparentid()
    {
    	if($this->CI_auth->check_logged() === false){
			redirect(base_url().'admin/dang-nhap.html');
		}
		$data['data_index'] = $this->get_index();
		if($data['data_index']['permission'] == 0){
			redirect(base_url().'admin/');
		}
    	$id = $_POST['id'];
    	$parentid = $_POST['parentid'];
    	$data['parentid'] = $parentid;
    	$this->query_sql->edit('dev_menu', $data, array('id' => $id));
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
    	$data['menu'] = $this->query_sql->select_like('dev_menu','id, name, created, publish, sort, parentid',$data_like,'');
    	foreach ($data['menu'] as $key => $val) {
			$data_child = $this->query_sql->select_array('dev_menu','id, name, created, publish, sort, parentid',array('parentid' => $val['id']));
			$data['menu'][$key]['menu_child'] = $data_child;
		}
		$this->load->view('backend/menu/search', isset($data)?$data:NULL);
    }
}
