<?php
class Api_next_process extends CI_Controller
{
	public function index(){
		$this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"]; 
		$item_cd = $_GET["item_cd"]; 
		 $sql = "select * from sys_line_mst where line_cd =  '$line_cd' order by chk_qgate_flg asc ";
		$query_get_detail = $this->tbkkfa01_db->query($sql);
		$get_detail = $query_get_detail->result_array();
		foreach ($get_detail as $key => $value) {
			 if ($value["chk_qgate_flg"] == "1"){
			 	 echo "Q-GATE";
			 	 return "Q-GATE";
			 	// return "Q-GATE";
			 }
		}
		$sql_check_data2 = "select top 1 * from tag_fg_next_proc where item_cd = '$item_cd' order by status_flg asc";
		$query_get_detail2 = $this->tbkkfa01_db->query($sql_check_data2);
		$get_detail2 = $query_get_detail2->result_array();
		$product_typ = 0;
		$status_flg = 0;
		$cust_grp_name = "";
		if(empty($get_detail2)){
			 echo "-";
		 	// echo "<br>";
		 	// echo "02";
			return "-";
		}else{
			foreach ($get_detail2 as $key => $value) {
		 		$product_typ  = $value["product_typ"];
		 		$status_flg =  $value["status_flg"];
		 		$cust_grp_name =  $value["cust_grp_name"];
		 		goto next_process;
			}
			next_process:
			if($product_typ=="10"){
				 echo $cust_grp_name;
				 return $cust_grp_name;
				//return  $cust_grp_name;
			}else{
				if ($status_flg == "0") {
					 echo "-";
					return "-";
				 	// echo "<br>";
				 	// echo "03";
					//return "-";
				}else{
					 echo $cust_grp_name;
					 return $cust_grp_name;
					//return  $cust_grp_name;
				}
			}
		}
				//$date_now = date('Y-m-d');
	}
}
?>