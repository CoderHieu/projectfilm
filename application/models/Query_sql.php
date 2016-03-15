<?php
	class Query_sql extends CI_Model{
		function __construct()
		{
			parent::__construct();
			echo $this->input->post('title');
		}
		function add($table = '', $data = NULL){
			$this->db->insert($table, $data);
			$flag = $this->db->affected_rows();
			if($flag > 0){
				return array(
					'type'		=> 'successful',
					'message'	=> 'Thêm dữ liệu thành công!',
				);
			}
			else
			{
				return array(
					'type'		=> 'error',
					'message'	=> 'Thêm dữ liệu không thành công!',
				);
			}
		}
		function edit($table = '', $data = NULL, $where = NULL){
			$this->db->where($where)->update($table, $data);
			$flag = $this->db->affected_rows();
			if($flag > 0){
				return array(
					'type'		=> 'successful',
					'message'	=> 'Cập nhật dữ liệu thành công!',
				);
			}
			else
			{
				return array(
					'type'		=> 'error',
					'message'	=> 'Cập nhật dữ liệu không thành công!',
				);
			}
		}
		function del($table = '', $where = NULL){
			$this->db->delete($table, $where); 
		}
		function select_like($table = '', $data = NULL, $like = NULL, $order = ''){
			$result = $this->db->select($data)->from($table);
			if($like!=''){
				$result = $this->db->like($like);
			}
			if($order!=''){
				$result = $this->db->order_by($order);
			}
			$result = $this->db->get()->result_array();
			return $result;
		}
		function select_array($table = '', $data = NULL, $where = NULL, $order = '', $like = NULL){
			$result = $this->db->select($data)->from($table);
			if($where!=''){
				$result = $this->db->where($where);
			}
			if($like!=''){
				$result = $this->db->like($like);
			}
			if($order!=''){
				$result = $this->db->order_by($order);
			}
			$result = $this->db->get()->result_array();
			return $result;
		}
		function select_row($table = '', $data = NULL, $where = NULL, $order = ''){
			$result = $this->db->select($data)->from($table);
			if($where!=''){
				$result = $this->db->where($where);
			}
			if($order!=''){
				$result = $this->db->order_by($order);
			}
			$result = $this->db->get()->row_array();
			return $result;
		}
		function total($table){
			return $this->db->from($table)->count_all_results();
		}
		function total_where($table,$where){
			return $this->db->from($table)->where($where)->count_all_results();
		}
		function view($select, $table, $start, $limit){
			return $this->db->select($select)->from($table)->order_by('id desc')->limit($limit, $start)->get()->result_array();
		}
		function view_where($select, $table, $where, $start, $limit){
			return $this->db->select($select)->from($table)->order_by('id desc')->where($where)->limit($limit, $start)->get()->result_array();
		}
		function _pagination()
		{
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			
			$config['next_link'] = 'Next &raquo;';
			$config['next_tag_open'] = '<li class="paginate_button next">';
			$config['next_tag_close'] = '</li>';
			
			$config['prev_link'] = '&laquo; Previous';
			$config['prev_tag_open'] = '<li class="paginate_button previous">';
			$config['prev_tag_close'] = '</li>';
			
			$config['cur_tag_open'] = '<li class="paginate_button active"><a class="number current">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$config['num_links'] = 5;
			$config['uri_segment'] = 3;
			
			$config['use_page_numbers'] = TRUE;
			$config['per_page'] = 10;
			return $config;
		}
		function check_code($code = '', $table = ''){
			$results = $this->db->select('id')->from($table)->where('code',$code)->get()->row_array();
			if($results!=NULL){
				return true;
			}else{
				return false;
			}
		}
		function check_parent($id = '', $table = ''){
			$results = $this->db->select('id_parent')->from($table)->where('id',$id)->get()->row_array();
			if($results!=NULL){
				$data = $results['id_parent'];
			}else{
				$data = '';
			}
			return $data;
		}
		function check_maxid($table = ''){
			$results = $this->db->select_max('id')->from($table)->get()->row_array();
			$data = $results['id'] + 1;
			return $data;
		}
	}
?>