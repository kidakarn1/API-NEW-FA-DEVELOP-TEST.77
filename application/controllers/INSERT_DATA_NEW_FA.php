<?php
class INSERT_DATA_NEW_FA extends CI_Controller
{
	public function check_line($line_cd){
		$sql = "select * from mst_equip_ctrl where me_line_cd = '$line_cd'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			return "0";
		}else{
			return "1";
		}
	}
	public function InsertLogLoss(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
 	    $lineCd = $_GET["lineCd"];
 		$wi = $_GET["wi"];
 		$seq = $_GET["seq"];
 		  $sql = "INSERT into sys_log_loss_time_ctrl (slltc_line , slltc_created_date , slltc_wi , slltc_seq , slltc_created_by) values('{$lineCd}' , CURRENT_TIMESTAMP , '{$wi}' , '{$seq}' , '{$lineCd}')";
 		$query = $this->TBK_FA01->query($sql);
		if($query){
			echo "1";
		}else{
			echo "0";
		}
	}
		public function insDataLossByLine(){
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$this->maintenance = $this->load->database('maintenance', true);
		$line_cd = $_GET["LineCd"];
		$op = $_GET["op"];
		$shift = $_GET["shift"];
		$start_breakTime = $_GET["brakTime_down"];
		  $sql = "INSERT into info_detail_repair_temporary(mc_line , mc_process , breakdown_start , shift) values('{$line_cd}' , '{$op}' , '{$start_breakTime}' , '{$shift}');
		";
		$query = $this->maintenance->query($sql);
	}
	public function INSERT_COTROL_MASTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		 $line_cd = $_GET["line_cd"];
		 $ComboBox_master_device = $_GET["ComboBox_master_device"];
 		 $device_dio_port_id = $_GET["device_dio_port_id"];
 		 $printer = $_GET["printer"];
 		 $typ_counter = $_GET["typ_counter"];
 		 $cavity = $_GET["cavity"];
 		 $total_delay = $_GET["total_delay"];
 		 $scanner = $_GET["scanner"];
 		  $mecg_id = $this->Get_ID_table("mecg_id" , "mst_equip_count_grp" , "mecg_name = '$ComboBox_master_device'");
 		  $mec_id = $this->Get_ID_table("mec_id" , "mst_equip_count" , "mec_name='$device_dio_port_id'");
 		  $mep_id = $this->Get_ID_table("mep_id" , "mst_equip_printer" , "mep_name='$printer'");
 		 $mes_id = $this->Get_ID_table("mes_id" , "mst_equip_scanner" , "mes_name='$scanner'");
		$mect_id = $this->Get_ID_table("mect_id" , "mst_equip_count_typ" , "mect_name='$typ_counter'");
 		 $me_cnt_typ = "0";

 		 if ($cavity <= "1"){
 		 	$me_cnt_typ = "1";
 		 }else{
 		 	$me_cnt_typ = "2";
 		 }
		if($this->check_line($line_cd) == "0"){
			   $sql  = "INSERT into mst_equip_ctrl(
						me_line_cd,
						mec_id,
						mect_id,
						mes_id,
						mep_id,
						me_cnt_typ,
						me_cnt_qty,
						me_sig_del,
						me_created_date,
						me_created_by ,
						me_updated_date,
						me_updated_by
						) values(
						'$line_cd',
						'$mec_id',
						'$mect_id',
						'$mes_id',
						'$mep_id',
						'$me_cnt_typ',
						'$cavity',
						'$total_delay',
						CURRENT_TIMESTAMP,
						'SYSTEM',
						CURRENT_TIMESTAMP,
						'SYSTEM'
						) ";
		}else{
			 	 $sql = "UPDATE mst_equip_ctrl set
				 		mec_id = '$mec_id',
				 		mect_id = '$mect_id',
				 		mes_id = '$mes_id',
				 		mep_id = '$mep_id',
				 		me_cnt_typ = '$me_cnt_typ',
				 		me_cnt_qty = '$cavity',
				 		me_updated_date = CURRENT_TIMESTAMP,
				 		me_updated_by = 'SYSTEM',
				 		me_sig_del = '$total_delay'
				 		where me_line_cd = '$line_cd'
				 ";
		}

					$query = $this->TBK_FA01->query($sql);
					if($query){
						echo "1";
					}else{
						echo "0";
					}
				
			}
	public function test(){
       echo  $this->Get_ID_table("mes_id" , "mst_equip_scanner" , "mes_name='USB'");
	}
	public function Get_ID_table($attr , $table , $condition ){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select $attr from $table where $condition";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			return  "0";
		}else{
			return $get["0"][$attr];
		}
	}

	public function INSERT_production_working_info(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$ind_row = $_GET["ind_row"];
		$pwi_lot_no = $_GET["pwi_lot_no"];
		$pwi_seq_no = $_GET["pwi_seq_no"];
		$pwi_shift = $_GET["pwi_shift"];
		// $wi = $this->GetWI($ind_row);
		// $this->Update_supply_dev_Working($wi);
		$sql = "
		Insert into production_working_info(
			ind_row , 
			pwi_lot_no , 
			pwi_seq_no , 
			pwi_shift , 
			pwi_created_date , 
			pwi_created_by) 
			Values(
				'{$ind_row}' , 
				'{$pwi_lot_no}' , 
				'{$pwi_seq_no}' , 
				'{$pwi_shift}' , 
				 CURRENT_TIMESTAMP , 
				'SYSTEM')
		";
		$query = $this->TBK_FA01->query($sql);
		if($query){
			echo "1";
		}else{
			echo "0";
		}
	}
	public function GET_DATA_PRODUCTION_WORKING_INFO(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$ind_row = $_GET["ind_row"];
		$pwi_lot_no = $_GET["pwi_lot_no"];
		$pwi_seq_no = $_GET["pwi_seq_no"];
		$sql = "EXEC [dbo].[GET_DATA_PRODUCTION_WORKING_INFO] @ind_row = '{$ind_row}' , @pwi_lot_no = '{$pwi_lot_no}' , @pwi_seq_no='{$pwi_seq_no}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["pwi_id"];
		}
	}
	public function GetWI($ind_row){
		$sql = "select WI from sup_work_plan_supply_dev where IND_ROW = '{$ind_row}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
 		return $get[0]["WI"];
	}
	public function Update_supply_dev_Working(){
		$wi = $_GET["wi"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "Update sup_work_plan_supply_dev set PRD_COMP_FLG = '1', UPDATE_DATE = CURRENT_TIMESTAMP where WI = '{$wi}'";
		$query = $this->TBK_FA01->query($sql);
	}
	public function Update_supply_dev_WorkingSpecial(){
		$json_data = file_get_contents('php://input');
	    $data = json_decode($json_data, true);
	    $wi_array = $data["wi"];
 		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		foreach ($wi_array as $value) {
			$wi = $value;
			$sql = "Update sup_work_plan_supply_dev set PRD_COMP_FLG = '1', UPDATE_DATE = CURRENT_TIMESTAMP where WI = '{$wi}' ";
			$query = $this->TBK_FA01->query($sql);
		}
	}
	public function UpdateFlgZero(){
		$line_cd = $_GET["line_cd"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "Update sup_work_plan_supply_dev set PRD_COMP_FLG = '0', UPDATE_DATE = CURRENT_TIMESTAMP where line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
	}
	public function UpdateFlgZeroSpecial(){
	    $json_data = file_get_contents('php://input');
	    $data = json_decode($json_data, true);
	    $wi_array = $data["wi"];
 		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
	}
	public function work_complete_offline(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$wi = $_GET["wi"];
		$currdated = $_GET["currdated"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = " UPDATE sup_work_plan_supply_dev SET PRD_COMP_FLG = '0' , UPDATE_DATE = CURRENT_TIMESTAMP WHERE WI = '{$wi}'";
		$query = $this->TBK_FA01->query($sql);
	}
}
?>