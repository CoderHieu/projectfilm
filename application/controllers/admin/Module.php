<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends MY_Controller {
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
		$data['title'] = 'Quản lý module';
		$data['template'] = 'backend/module/index';

		$config = $this->query_sql->_pagination();
		$config['base_url'] = base_url().'admin/module/index/';
		$config['total_rows'] = $this->query_sql->total('ci_module');
		$config['uri_segment'] = 4;  
		$total_page = ceil($config['total_rows']/$config['per_page']);
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page < 1)?1:$page;
		$page = $page - 1;
		
		$this->pagination->initialize($config);
		$data['list_pagination'] = $this->pagination->create_links();

		if($config['total_rows']>0){
			$data['module'] = $this->query_sql->view_where('id, name, controller, created, publish, sort, parentid','ci_module',array('parentid' => 0),($page * $config['per_page']),$config['per_page']);
			foreach ($data['module'] as $key => $val) {
				$data_child = $this->query_sql->select_array('ci_module','id, name, controller, created, publish, sort, parentid',array('parentid' => $val['id']));
				$data['module'][$key]['module_child'] = $data_child;
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
		$data['title'] = 'Thêm module';
		$data['template'] = 'backend/module/add';
		if($this->input->post()){
			$this->form_validation->set_rules('name','Tên','trim|required');
			if($this->form_validation->run()){
				$data_insert = array(
					'name' 			=> 	$this->input->post('name'),
					'parentid' 		=> 	$this->input->post('parentid'),
					'controller' 	=> 	$this->input->post('controller'),
					'publish'		=>	$this->input->post('publish'),
					'created'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->add('ci_module', $data_insert);
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/module/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/module/index',$data);
				}	
			}
		}
		$data['module'] = $this->query_sql->select_array('ci_module','id, name, controller, created, publish, sort',array('parentid' => 0));
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
					'parentid' 		=> 	$this->input->post('parentid'),
					'controller' 	=> 	$this->input->post('controller'),
					'publish'		=>	$this->input->post('publish'),
					'updated'		=>	gmdate('Y-m-d H:i:s', time()+7*3600)
				);
				$flag = $this->query_sql->edit('ci_module', $data_update, array('id' => $id));
				if($flag>0){
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'sucess',
						'message'	=> 'Thành công!',
					));
					redirect('admin/module/index',$data);
				}else{
					$this->session->set_flashdata('message_flashdata', array(
						'type'		=> 'error',
						'message'	=> 'Thất bại!',
					));
					redirect('admin/module/index',$data);
				}
			}
		}
		
		$data['module'] = $this->query_sql->select_row('ci_module', 'id, name, controller, created, publish, parentid', array('id' => $id));

		$data['modules'] = $this->query_sql->select_array('ci_module','id, name, controller, created, publish, sort, parentid',array('parentid' => 0));
		
		$data['title'] = 'Cập nhật module';
		$data['template'] = 'backend/module/edit';
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
		$sql = $this->query_sql->select_row('ci_module','publish',array('parentid' => $id));
		if($sql != NULL){
			$this->session->set_flashdata('message_flashdata', array(
				'type'		=> 'sucess',
				'message'	=> 'Không thể xóa khi có danh mục con!',
			));
			redirect('admin/module/index',$data);
		}else{
			$this->query_sql->del('ci_module',array('id' => $id));
		}
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
		$sql = $this->query_sql->select_row('ci_module','publish',array('id' => $id));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('ci_module', $data_update, array('id' => $id));
		$data_sql = $this->query_sql->select_row('ci_module','publish',array('id' => $id));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/module/show', $data_publish);
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
		$sql = $this->query_sql->select_row('ci_module','publish',array('id' => $listid));
		if($sql['publish']==1){
			$publish = 0;
		}else{
			$publish = 1;
		}
		$data_update['publish'] = $publish;
		$this->query_sql->edit('ci_module', $data_update, array('id' => $listid));
		$data_sql = $this->query_sql->select_row('ci_module','publish',array('id' => $listid));
		$data_publish['publish'] = $data_sql['publish'];
		$this->load->view('backend/module/showall', $data_publish);
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
        	$this->query_sql->del('ci_module',array('id' => $value));
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
		$this->query_sql->edit('ci_module', $data_update, array('id' => $id));
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
    	$this->query_sql->edit('ci_module', $data, array('id' => $id));
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
    	$data['module'] = $this->query_sql->select_like('ci_module','id, name, controller, created, publish,parentid, sort',$data_like,'');
    	foreach ($data['module'] as $key => $val) {
			$data_child = $this->query_sql->select_array('ci_module','id, name, controller, created, publish, sort, parentid',array('parentid' => $val['id']));
			$data['module'][$key]['module_child'] = $data_child;
		}
		$this->load->view('backend/module/search', isset($data)?$data:NULL);
    }
}
