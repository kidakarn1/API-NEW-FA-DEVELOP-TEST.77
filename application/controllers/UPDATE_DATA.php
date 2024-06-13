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
	public function UpdateMaintenance(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$breakdown_total = $_GET["breakdown_total"];
		$restart_time = $_GET["restart_time"];
		$lineCd = $_GET["lineCd"];
		$op = $_GET["op"];
		$breakdown_start = $_GET["breakdown_start"];
		// $this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$this->maintenance = $this->load->database('maintenance', true);
		echo $sql  = "
			UPDATE info_detail_repair 
				set breakdown_total = '{$breakdown_total}' , 
				restart_time = '{$restart_time}' 
				where mc_line = '{$lineCd}' and 
				mc_process = '{$op}' and 
				flg_status_rp = '3' and 
				breakdown_start = '{$breakdown_start}'
				";
		$query = $this->maintenance->query($sql);
	}
}
?>