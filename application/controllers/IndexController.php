<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IndexController extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function __destruct(){
	}
	public function index()
	{
		$data['data_index'] = $this->get_index();
		$data['template'] = 'frontend/home/index';
		$this->load->view('frontend/index', isset($data)?$data:NULL);
	}
}