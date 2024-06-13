<?php
class GET_DATA_NEW_FA extends CI_Controller
{
	public function CHECK_LINE_MASTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_cd = $_GET["line_cd"];
		$sql  = "select *  from mst_equip_ctrl where me_line_cd = '$line_cd'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function JOIN_CHECK_LINE_MASTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_cd = $_GET["line_cd"];
		$sql  = "select *  from 
		mst_equip_ctrl mec_master,
		mst_equip_count mec,
		mst_equip_count_typ mect ,
		mst_equip_scanner mes,
		mst_equip_printer mep,
		mst_equip_count_grp mecg ,
		sys_line_mst slm
		where mec_master.me_line_cd = '$line_cd' and 
		mec_master.me_line_cd = slm.line_cd and 
		mec_master.mec_id = mec.mec_id and 
		mec_master.mect_id = mect.mect_id and 
		mec_master.mes_id = mes.mes_id and 
		mec_master.mep_id = mep.mep_id and 
		mec.mecg_id = mecg.mecg_id  
		";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}

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

	public function GET_SCANNER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select * from mst_equip_scanner where mes_status_flg = '1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GET_CAT_COUNTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql = "select * from mst_equip_count_grp where mecg_status_flg = '1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GET_DIO_PORT(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$device_name = $_GET["device_name"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select * from mst_equip_count_grp mecg ,  
		mst_equip_count mec 
		where 
		mecg.mecg_id = mec.mecg_id and  
		mec.mec_status_flg = '1' and 
		mecg.mecg_name = '$device_name'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GET_PRINTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select * from mst_equip_printer where mep_status_flg = '1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}



	public function GET_COUNTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select * from mst_equip_count_typ where mect_status_flg = '1'";
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
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
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
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
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
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
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
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
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
}
?>