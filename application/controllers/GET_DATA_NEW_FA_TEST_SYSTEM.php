<?php
class GET_DATA_NEW_FA_TEST_SYSTEM extends CI_Controller
{
	public function GET_PD(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql  = "select DISTINCT dep_cd  as PD from sys_line_mst where  enable = '1' order by PD asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function Get_ref_start_id(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$wi = $_GET["wi"]; 
		$lot_no = $_GET["lot_no"];
		$seq_no = $_GET["seq_no"]; 
		$sql  = "select min(id) as id from tag_print_detail where wi = '$wi' and  SUBSTRING( qr_detail, 96, 3) = '$seq_no' and SUBSTRING( qr_detail, 59, 4) = '$lot_no'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["id"];
		}
	}
		public function Get_ref_end_id(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$wi = $_GET["wi"]; 
		$lot_no = $_GET["lot_no"];
		$seq_no = $_GET["seq_no"]; 
		$sql  = "select max(id) as id from tag_print_detail where wi = '$wi'  and  SUBSTRING( qr_detail, 96, 3) = '$seq_no' and SUBSTRING( qr_detail, 59, 4) = '$lot_no'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["id"];
		}
	}
	public function Get_data_picking(){
		//$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$this->PICKING = $this->load->database('PICKING', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$ref_id = $_GET["ref_id"]; 
		$sql = "select  sup_scan_pick_detail.tag_readed as tag_readed  , sup_scan_pick_detail.wi as wi from sup_pick_log , sup_scan_pick_detail where sup_pick_log.id ='$ref_id' and sup_pick_log.REF_ID = sup_scan_pick_detail.id ";
		$query = $this->PICKING->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["tag_readed"];
		}
	}
		public function GET_ID_PRINT_DETAIL(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		// test_new_fa02
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$qr_code = $_GET["qr_code"];
		 $sql  = "select  id  as id_print from tag_print_detail where qr_detail = '$qr_code'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["id_print"];
		}
	}
		public function GET_ID_PRINT_DETAIL_MAIN(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		// test_new_fa02
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		  $qr_code = $_GET["qr_code"];
		  $sql  = "select  tag_id  as id_print from tag_print_detail_main where tag_qr_detail = '{$qr_code}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["id_print"];
		}
	}

	public function GET_LINE_TYPE(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_cd = $_GET["line_cd"];
		$sql  = "select  tag_type  as status_tag_type from sys_line_mst where  enable = '1' and line_cd = '$line_cd' order by line_cd asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			// echo json_encode($get);
			echo $get[0]["status_tag_type"];
		}
	}
		public function GET_LINE(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$PD = $_GET["PD"];
		$sql  = "select  distinct  line_cd  as LINE_CD from sys_line_mst where dep_cd = '$PD' and enable = '1' order by line_cd asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GET_DATA_WORKING(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$WI = $_GET["WI"];
		$sql  = "select  * from sup_work_plan_supply_dev where WI = '$WI' and LVL = '1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}

	public function GetTimeAutoBreakTime(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$lineCd = $_GET["lineCd"];
		$timeNow = date('H:i:s'); //"00:59:59";
		if(substr($timeNow, 0,1) == 0){
			$timeNow = substr($timeNow, 1);
		}
		  $sql  = "EXEC [dbo].[GetTimeAutoBreakTime] @LineCd = '{$lineCd}'  , @TimeStart = '{$timeNow}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get) || $get[0]["sltc_rec_time"] == ""){
		  	  $sql  = "EXEC [dbo].[GetTimeAutoBreakTime] @LineCd = '{$lineCd}'  , @TimeStart = '00:00:00'";
			$query = $this->TBK_FA01->query($sql);
			$get = $query->result_array();
			if (empty($get) || $get[0]["sltc_rec_time"] == ""){
				echo "0";
			}else{
				echo json_encode($get);
			}
		}else{
			echo json_encode($get);
		}
	}
}
?>