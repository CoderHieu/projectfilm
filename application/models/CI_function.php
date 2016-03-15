<?php
	class CI_function extends CI_Model{
		function __construct()
		{
			parent::__construct();
			echo $this->input->post('title');
		}
		function create_alias($bien)
		{
			if($bien != '')
			{
				$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
				"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
				,"ế","ệ","ể","ễ",
				"ì","í","ị","ỉ","ĩ",
				"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
				,"ờ","ớ","ợ","ở","ỡ",
				"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
				"ỳ","ý","ỵ","ỷ","ỹ",
				"đ",
				"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
				,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
				"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
				"Ì","Í","Ị","Ỉ","Ĩ",
				"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
				,"Ờ","Ớ","Ợ","Ở","Ỡ",
				"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
				"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
				"Đ",
				"!","@","#","$","%","^","&","*","(",")");
				
				$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
				,"a","a","a","a","a","a",
				"e","e","e","e","e","e","e","e","e","e","e",
				"i","i","i","i","i",
				"o","o","o","o","o","o","o","o","o","o","o","o"
				,"o","o","o","o","o",
				"u","u","u","u","u","u","u","u","u","u","u",
				"y","y","y","y","y",
				"d",
				"A","A","A","A","A","A","A","A","A","A","A","A"
				,"A","A","A","A","A",
				"E","E","E","E","E","E","E","E","E","E","E",
				"I","I","I","I","I",
				"O","O","O","O","O","O","O","O","O","O","O","O"
				,"O","O","O","O","O",
				"U","U","U","U","U","U","U","U","U","U","U",
				"Y","Y","Y","Y","Y",
				"D",
				"","","","","","","","","","");
				$bien = trim($bien);
				$bien = str_replace("/","",$bien);
				$bien = str_replace(":","",$bien);
				$bien = str_replace("!","",$bien);
				$bien = str_replace("(","",$bien);
				$bien = str_replace(")","",$bien);
				$bien = str_replace($marTViet,$marKoDau,$bien);
				$bien = str_replace("-","",$bien);
				$bien = str_replace("  "," ",$bien);
				$bien = str_replace(" ","-",$bien);
				$bien = str_replace("%","-",$bien);
				$bien = str_replace("'","",$bien);
				$bien = str_replace("“","",$bien);
				$bien = str_replace("”","",$bien);
				$bien = str_replace(",","",$bien);
				$bien = str_replace(".","",$bien);
				$bien = str_replace('"',"",$bien);
				$bien = str_replace('\\','',$bien);
				$bien = str_replace('//','',$bien);
				$bien = str_replace('?','',$bien);
				$bien = str_replace('&','',$bien);
				$bien = strtolower($bien);
				return $bien;
			}
		}

		function stripUnicode($str){ 
			if(!$str) return false; 
				$unicode = array( 
				'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ', 
				'd'=>'đ', 'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 
				'i'=>'í|ì|ỉ|ĩ|ị', 
				'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ', 
				'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 
				'y'=>'ý|ỳ|ỷ|ỹ|ỵ', ); 
				foreach($unicode as $nonUnicode=>$uni) 
				$str = preg_replace("/($uni)/i",$nonUnicode,$str); 
			return $str; 
		}
		function check_alias($id = 0, $alias = '', $name = '', $table = ''){
			$random = random_string('nozero', 3);
			if($id>0){
				$results = $this->db->select('id, name, alias')->from($table)->where('id',$id)->get()->row_array();
				if($results['name'] == $name){
					$alias = $results['alias'];
				}else{
					$result = $this->db->select('id')->from($table)->where('alias',$alias)->get()->result_array();
					if($result!=NULL){
						$alias = $alias.'-'.$random;
					}else{
						$alias = $alias;
					}
				}
			}else{
				$result = $this->db->select('id')->from($table)->where('alias',$alias)->get()->result_array();
				if($result!=NULL){
					$alias = $alias.'-'.$random;
				}else{
					$alias = $alias;
				}
			}
			return $alias;
		}
	}
?>