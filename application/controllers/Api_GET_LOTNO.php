<?php
class Api_GET_LOTNO extends CI_Controller
{
	public function index(){
		// $this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		$this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$server_date_year = date('Y');
		$server_date_moth = date('m');
		 $SQL= "select prod_year_lot from sys_prod_year_ctrl where prod_year = '$server_date_year'";
		 $query = $this->tbkkfa01_db->query($SQL);
		 $get = $query->result_array();
		 $lot_year =  $get[0]["prod_year_lot"];
 		 $SQL= "select prod_mth_lot from sys_prod_mth_ctrl where prod_mth_cd = '$server_date_moth'";
		 $query = $this->tbkkfa01_db->query($SQL);
		 $get = $query->result_array();
		 $lot_mouth =  $get[0]["prod_mth_lot"];
		 echo  $lot_year. $lot_mouth;
		// if (empty($get)){
		// 	echo " ";
		// }else{
		// 	echo json_encode($get);
		// }
	}
}
?>