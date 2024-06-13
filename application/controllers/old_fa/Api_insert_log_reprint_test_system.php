<?php
class Api_insert_log_reprint_test_system extends CI_Controller
{
	public function index(){
	
	 }
	public function ins_los_reprint(){
		$this->tbkkfa01_db = $this->load->database('test_new_fa02', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$created_by = $_GET["created_by"];
		$table_created = $_GET["table_created"];
		$log_ref_tag_id = $_GET["log_ref_tag_id"];
		  $sql = "INSERT into log_reprint_tag (log_system_typ , log_ref_db , log_ref_tag_id , log_created_date , log_created_by) values(
				'2' , 
				'$table_created',
				'$log_ref_tag_id',
				CURRENT_TIMESTAMP ,
				'$created_by'
			)";
		$query = $this->tbkkfa01_db->query($sql);
		if($query){
			echo  "1";
		}else{
			echo "0";
		}
	} 

}
?>