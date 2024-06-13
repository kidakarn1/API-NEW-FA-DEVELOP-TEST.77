<?php
class GET_DATA_NEW_FA_REPRINT extends CI_Controller
{
	public function GET_REPRINT_NORMAL(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$wi = $_GET["WI"];
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql  = " select * from tag_print_detail where wi = '$wi' And qr_detail != '' and flg_control !='2' order by id asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		// echo "<pre>";
		//  print_r($get);
		// echo "</pre>";
		$data = array();
	 	// foreach ($get[0] as $key_attr => $value_attr) { //get name attr
	 		foreach ($get as $key => $value) { //get value
		 		if ($value["flg_control"] == "9"){
		 			echo "FLG 9--->".$value["id"]."<br>";
		 			$id = $value["id"];
		 			$sql = "select log_qr_detail from log_reprint_app where log_ref_id = '$id'";
		 			$query = $this->TBK_FA01->query($sql);
					$get3 = $query->result_array();
				//	foreach ($get3 as $key3 => $value3) { //get value
						// $data[""] = $value3[""];	
				//	}
		 		}else{
		 			echo "OK===>".$value["id"]."<br>";
		 		}
	 		}
	 	// }
	}
}
?>