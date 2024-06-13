<?php
class UPDATE_DATA extends CI_Controller
{
	public function UPDATE_PRINT(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$id = $_GET["ID"];
		$print_count = $_GET["PRINT_COUNT"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql  = "UPDATE tag_print_detail set print_count = '$print_count' , updated_date = CURRENT_TIMESTAMP where id = '$id' ";
		$query = $this->TBK_FA01->query($sql);
	}
		public function UPDATE_PRINT_test_system(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$id = $_GET["ID"];
		$print_count = $_GET["PRINT_COUNT"];
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql  = "UPDATE tag_print_detail set print_count = '$print_count' , updated_date = CURRENT_TIMESTAMP where id = '$id' ";
		$query = $this->TBK_FA01->query($sql);
	}

	public function UPDATE_PRINT_DEFETCT(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$id = $_GET["ID"];
		$print_count = $_GET["PRINT_COUNT"];
		// $this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		 $this->TBK_FA01 = $this->load->database('test_new_fa01', true);
		$sql  = "UPDATE tag_print_detail_defact set tag_defact_conter = '$print_count' , tag_defact_updated_date = CURRENT_TIMESTAMP where tag_defact_id = '$id' ";
		$query = $this->TBK_FA01->query($sql);
	}
}
?>