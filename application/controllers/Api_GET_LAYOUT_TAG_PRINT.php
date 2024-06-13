<?php
class Api_GET_LAYOUT_TAG_PRINT extends CI_Controller
{
	public function index(){
		// $this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"]; 
		$this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$server_date_year = date('Y');
		$server_date_moth = date('m');
		 $SQL= "select tag_type	 from sys_line_mst , sys_tag_mst where sys_line_mst.line_cd = '$line_cd' and sys_line_mst.tag_type = sys_tag_mst.tag_type_id and sys_tag_mst.enable = '1'";
		 $query = $this->tbkkfa01_db->query($SQL);
		 $get = $query->result_array();
		 if (empty($get)){
			echo "0";
		 }else{
		  	echo $get["0"]["tag_type"];
		 }
	}
}
?>