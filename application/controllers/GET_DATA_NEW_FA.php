<?php
class GET_DATA_NEW_FA extends CI_Controller
{
	public function CHECK_LINE_MASTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
public function Get_PD_CONFIG(){
	parse_str($_SERVER['QUERY_STRING'], $_GET); 
	$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
	 $line_cd = $_GET["line_cd"];
		$sql = "SELECT
		line_cd 
	FROM
		sys_line_multi_master 
	WHERE
		slmm_id = ( SELECT slmm_id FROM sys_line_multi_master WHERE line_cd = '{$line_cd}' and slmm_enable = '1')";
	$query = $this->TBK_FA01->query($sql);
	$get = $query->result_array();
	if(empty($get)){
		echo "0";
	}else{
		echo json_encode($get);
	}
}
public function CheckTrancetion(){
	parse_str($_SERVER['QUERY_STRING'], $_GET); 
	$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
	$pwi_id = $_GET["pwi_id"];
	$number_qty = $_GET["number_qty"];
	$st_time = $_GET["st_time"];
	    $sql = "SELECT count(id) as check_count  from production_actual_detail 
	where 
	pwi_id = '{$pwi_id}' and 
	number_qty = '{$number_qty}' and
	st_time = '{$st_time}'";
	$query = $this->TBK_FA01->query($sql);
	$get = $query->result_array();
	if($get[0]["check_count"] <= 0 ){
		echo "1";
	}else{
		echo "0";
	}
}
	public function getOpLineProduxtion(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$line_cd = $_GET["LineCd"];
		$sql = "SELECT
					* 
				FROM
					sys_line_mst as line_mst , 
				  sys_lineop_mst as lineop_mst ,
					sys_op_mst as op_mst
					Where  
					line_mst.line_cd = '{$line_cd}' and 
					line_mst.enable = '1' and 
					lineop_mst.line_id = line_mst.line_id and 
				  lineop_mst.syslineop_status = '1' and 
					lineop_mst.op_id = op_mst.op_id and 
					op_mst.op_flg = '1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}

	public function get_loss_mst(){
		$LINE_CD = $_GET["LINE_CD"];
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql  = "EXEC [dbo].[GET_LOSS_GROUP] @LINE_CD = '{$LINE_CD}'";
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		slm.enable = '1' and 
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		//$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
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
		$timeNow =  date('H:i:s'); //"00:59:59";
		$hour = "";
		$hour =  $timeNow;;
		if(substr($timeNow,0,1) == "0"){
			$timeNow = substr($timeNow, 1);
		}
		   $sql  = "EXEC [dbo].[GetTimeAutoBreakTime] @LineCd = '{$lineCd}'  , @TimeStart = '{$hour}'";
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
	public function Get_man_limit(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$line_cd = $_GET["line_cd"];
		$sql  = "Select man_limit from sys_line_mst where line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["man_limit"];
		}
	}
	public function Get_Plan_All_By_Line(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$line_cd = $_GET["line_cd"];
		$shift = $_GET["shift"];
		$dateStart = $_GET["dateStart"];
		// $Time_Shift = $_GET["Time_Shift"];
		$timeNow =  date('H:i:s');
		$rs_shift = $this->Get_time_start_shift($shift);
		if ($timeNow>="00:00:00" and $timeNow<="07:59:59"){
			$delDate = date("Y-m-d",strtotime("-1 days",strtotime($dateStart)));
			$start_date = $delDate." ".substr($rs_shift[0]["master_start_shift"], 0, 8);
		}else{
			$start_date = $dateStart." ".substr($rs_shift[0]["master_start_shift"], 0, 8);
		}
		$hour = "";
		$end_date =  date("Y-m-d")." ".$timeNow;
		$sql  = "EXEC [dbo].[GET_ALL_PLAN_BY_LINE] @line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			  echo "0";
		}else{
			 $sql  = "EXEC [dbo].[CHECK_TRANSCETION_PRODUCTION_DETAIL] @line_cd = '{$line_cd}' , @date_start = '{$start_date}' , @date_end = '{$end_date}'";
			$query = $this->TBK_FA01->query($sql);
			$get = $query->result_array();
			  $sql_check_loss  = "EXEC [dbo].[CHECK_DATA_LOSS] @line_cd = '{$line_cd}' , @date_start = '{$start_date}' , @date_end = '{$end_date}'";
			$query_check_loss = $this->TBK_FA01->query($sql_check_loss);
			$get_check_loss = $query_check_loss->result_array();
			if(empty($get)){ // Check Production actual detail
				if(empty($get_check_loss)){ // Check Loss actual  
					$dateTimeObject1 = date_create($start_date); 
					$dateTimeObject2 = date_create($end_date); 
					$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
					$minutes = $difference->days * 24 * 60;
					$minutes += $difference->h * 60;
					$minutes += $difference->i;
					$data[0] = array(
					"Time_From" => "Current",
					"Start_Loss" => $start_date,
					"End_Loss" => $end_date,
					"Loss_Time" => $minutes,
					"Loss_Code" => "36"
				);
					echo json_encode($data);
				}else{
					$dateTimeObject1 = date_create($get_check_loss[0]["end_loss"]); 
					$dateTimeObject2 = date_create($end_date); 
					$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
					$minutes = $difference->days * 24 * 60;
					$minutes += $difference->h * 60;
					$minutes += $difference->i;
					$data[0] = array(
						"Time_From" => "Loss",
						"Start_Loss" => $get_check_loss[0]["end_loss"],
						"End_Loss" => $end_date,
						"Loss_Time" => $minutes,
						"Loss_Code" => "36"
					);
					echo json_encode($data);
				}
			}else{
				// echo json_encode($get);
				// echo "<br>";
				// print_r($get_check_loss);
				if(empty($get_check_loss)){
					$dateTimeObject1 = date_create($get[0]["end_time"]); 
					$dateTimeObject2 = date_create($end_date); 
					$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
					$minutes = $difference->days * 24 * 60;
					$minutes += $difference->h * 60;
					$minutes += $difference->i;
					$data[0] = array(
						"Time_From" => "Production",
						"Start_Loss" => $get[0]["end_time"],
						"End_Loss" => $end_date,
						"Loss_Time" => $minutes,
						"Loss_Code" => "36"
					);
				}else{
					$dateTimeObject1 = date_create($get[0]["end_time"]); 
					$dateTimeObject2 = date_create($end_date); 
					$time_difference_production = date_diff($dateTimeObject1, $dateTimeObject2);
					$dateTimeObject3 = date_create($get_check_loss[0]["end_loss"]);
					$time_difference_loss_actual = date_diff($dateTimeObject3, $dateTimeObject2); 
					$minutes_production= $time_difference_production->days * 24 * 60;
					$minutes_production += $time_difference_production->h * 60;
					$minutes_production += $time_difference_production->i;
					$minutes_loss = $time_difference_loss_actual->days * 24 * 60;
					$minutes_loss += $time_difference_loss_actual->h * 60;
					$minutes_loss += $time_difference_loss_actual->i;
					// echo $minutes_loss .">". $minutes_production;
					if($minutes_production >= $minutes_loss){ //Check time production or loss มากกว่ากันว่า เอาเวลาไหน  เอาเวลา  loss Actual
						$minutes = $time_difference_loss_actual->days * 24 * 60;
						$minutes += $time_difference_loss_actual->h * 60;
						$minutes += $time_difference_loss_actual->i;
						$data[0] = array(
						"Time_From" => "Loss",
						"Start_Loss" => $get_check_loss[0]["end_loss"],
						"End_Loss" => $end_date,
						"Loss_Time" => $minutes,
						"Loss_Code" => "36"
					);
					}else{ // เอาเวลา  Production  Detail
						$minutes = $time_difference_production->days * 24 * 60;
						$minutes += $time_difference_production->h * 60;
						$minutes += $time_difference_production->i;
						$data[0] = array(
						"Time_From" => "Production",
						"Start_Loss" => $get[0]["end_time"],
						"End_Loss" => $end_date,
						"Loss_Time" => $minutes,
						"Loss_Code" => "36");
					}
				}
				echo json_encode($data);
			}
		}
	}
	public function Get_time_start_shift($shift){
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql  = "EXEC [dbo].[GET_DATA_SHIFT] @shift = '{$shift}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		return $get;
	}
	public function Get_permission_worker(){
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$emp_code = $_GET["emp_code"];
		$line_cd = $_GET["line_cd"];
		$sql  = "EXEC [dbo].[GET_USER_PERMISSION_WORKER] @emp_code = '{$emp_code}' , @line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function Get_Plan_All_Line(){
	parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dateStart =  date('Y-m-d');
		$newDateTime = "20:05:00";//date('H:i:s');
		$shift ="";
		$shift_check = "";

	 		if($newDateTime >= "08:10:00" and  $newDateTime <= "20:10:00"){
				$shift = "P";
			}else if($newDateTime >= "20:10:00" and  $newDateTime <= "23:59:59" ){
			 	$shift = "Q";
			}else if($newDateTime >= "00:00:00" and  $newDateTime <= "08:09:59" ){
				$shift = "Q";
		 	}
		// $Time_Shift = $_GET["Time_Shift"];
		$sql_line_mst ="EXEC [dbo].[Get_mst_line]";
		$query_line_mst = $this->TBK_FA01->query($sql_line_mst);
		$get_mst_line = $query_line_mst->result_array();
	foreach ($get_mst_line as $key => $value) {
				$pd = $value["dep_cd"];
				  $line_cd = $value["line_cd"];
				$timeNow =  $newDateTime;//date('H:i:s');
				$rs_shift = $this->Get_time_start_shift($shift);
				if ($timeNow>="00:00:00" and $timeNow<="07:59:59"){
					$delDate = date("Y-m-d",strtotime("-1 days",strtotime($dateStart)));
					$start_date = $delDate." ".substr($rs_shift[0]["master_start_shift"], 0, 8);
				}else{
					$start_date = $dateStart." ".substr($rs_shift[0]["master_start_shift"], 0, 8);
				}
				$hour = "";
				$end_date = ""; //date("Y-m-d")." ".$timeNow;
				if($shift == "P"){
					$end_date =  $dateStart." 20:00:00";
				}else{
					$start_date =  date("Y-m-d",strtotime("-1 days",strtotime($dateStart)));
					$start_date.=" 20:00:00";
					$end_date =  date("Y-m-d")." 08:00:00";
				}
				  $sql  = "EXEC [dbo].[GET_ALL_PLAN_BY_LINE] @line_cd = '{$line_cd}'";
				echo  $sql."<br>";
				$query = $this->TBK_FA01->query($sql);
				$get = $query->result_array();
				// if($get[0]["line_cd"] == "K1PL01"){
				// 	print_r($get[0]["line_cd"]);
					
				// }
				if (empty($get)){
					  // echo ">>>>>".$sql."===<br>";
					  // echo "0<br>";
					  // return 0;
				}else{
					 $sql_check_trans  = "EXEC [dbo].[CHECK_TRANSCETION_PRODUCTION_DETAIL] @line_cd = '{$line_cd}' , @date_start = '{$start_date}' , @date_end = '{$end_date}'";
					$query_check_trans = $this->TBK_FA01->query($sql_check_trans);
					$get_check_trans = $query_check_trans->result_array();
					  $sql_check_loss  = "EXEC [dbo].[CHECK_DATA_LOSS] @line_cd = '{$line_cd}' , @date_start = '{$start_date}' , @date_end = '{$end_date}'";
					$query_check_loss = $this->TBK_FA01->query($sql_check_loss);
					$get_check_loss = $query_check_loss->result_array();
					if(empty($get_check_trans)){ // Check Production actual detail
						if(empty($get_check_loss)){ // Check Loss actual  
							$dateTimeObject1 = date_create($start_date); 
							$dateTimeObject2 = date_create($end_date); 
							$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
							$minutes = $difference->days * 24 * 60;
							$minutes += $difference->h * 60;
							$minutes += $difference->i;
							$data[0] = array(
							"Time_From" => "Current",
							"Start_Loss" => $start_date,
							"End_Loss" => $end_date,
							"Loss_Time" => $minutes,
							"Loss_Code" => "36"
						);
							// echo $value["line_cd"].$get[0]["WI"];
							$this->Insert_loss_auto($pd,$line_cd,$get[0]["WI"],$get[0]["ITEM_CD"],"000",$shift , $data[0]["Start_Loss"],  $data[0]["End_Loss"] , $data[0]["Loss_Time"],"2" , "36" , "0" , "1"  , "1");
							// echo json_encode($data);
						}else{
							echo "--->".$get_check_loss[0]["end_loss"]."<br>";
							$dateTimeObject1 = date_create($get_check_loss[0]["end_loss"]); 
							$dateTimeObject2 = date_create($end_date); 
							$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
							$minutes = $difference->days * 24 * 60;
							$minutes += $difference->h * 60;
							$minutes += $difference->i;
							$data[0] = array(
								"Time_From" => "Loss",
								"Start_Loss" => $get_check_loss[0]["end_loss"],
								"End_Loss" => $end_date,
								"Loss_Time" => $minutes,
								"Loss_Code" => "36"
							);
						$this->Insert_loss_auto($pd,$line_cd,$get[0]["WI"],$get[0]["ITEM_CD"],"000",$shift , $data[0]["Start_Loss"],  $data[0]["End_Loss"] , $data[0]["Loss_Time"],"2" , "36" , "0" , "1"  , "1");
							// echo json_encode($data);
						}
					}else{
						// echo json_encode($get);
						// echo "<br>";
						// print_r($get_check_loss);
						if(empty($get_check_loss)){
							
							$dateTimeObject1 = date_create($get_check_trans[0]["end_time"]); 
							$dateTimeObject2 = date_create($end_date); 
							$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
							$minutes = $difference->days * 24 * 60;
							$minutes += $difference->h * 60;
							$minutes += $difference->i;
							$data[0] = array(
								"Time_From" => "Production",
								"Start_Loss" => $get_check_trans[0]["end_time"],
								"End_Loss" => $end_date,
								"Loss_Time" => $minutes,
								"Loss_Code" => "36"
							);
						}else{
							$dateTimeObject1 = date_create($get_check_trans[0]["end_time"]); 
							$dateTimeObject2 = date_create($end_date); 
							$time_difference_production = date_diff($dateTimeObject1, $dateTimeObject2);
							$dateTimeObject3 = date_create($get_check_loss[0]["end_loss"]);
							$time_difference_loss_actual = date_diff($dateTimeObject3, $dateTimeObject2); 
							$minutes_production= $time_difference_production->days * 24 * 60;
							$minutes_production += $time_difference_production->h * 60;
							$minutes_production += $time_difference_production->i;
							$minutes_loss = $time_difference_loss_actual->days * 24 * 60;
							$minutes_loss += $time_difference_loss_actual->h * 60;
							$minutes_loss += $time_difference_loss_actual->i;
							// echo $minutes_loss .">". $minutes_production;
							if($minutes_production >= $minutes_loss){ //Check time production or loss มากกว่ากันว่า เอาเวลาไหน  เอาเวลา  loss Actual
								$minutes = $time_difference_loss_actual->days * 24 * 60;
								$minutes += $time_difference_loss_actual->h * 60;
								$minutes += $time_difference_loss_actual->i;
								$data[0] = array(
								"Time_From" => "Loss",
								"Start_Loss" => $get_check_loss[0]["end_loss"],
								"End_Loss" => $end_date,
								"Loss_Time" => $minutes,
								"Loss_Code" => "36"
							);
							}else{ // เอาเวลา  Production  Detail
								$minutes = $time_difference_production->days * 24 * 60;
								$minutes += $time_difference_production->h * 60;
								$minutes += $time_difference_production->i;
								$data[0] = array(
								"Time_From" => "Production",
								"Start_Loss" => $get_check_trans[0]["end_time"],
								"End_Loss" => $end_date,
								"Loss_Time" => $minutes,
								"Loss_Code" => "36");
							}
						}
						$this->Insert_loss_auto($pd,$line_cd,$get[0]["WI"],$get[0]["ITEM_CD"],"000",$shift , $data[0]["Start_Loss"],  $data[0]["End_Loss"] , $data[0]["Loss_Time"],"2" , "36" , "0" , "1"  , "1");
						// echo json_encode($data);
					}
				}
		}
	}	
	 public function  Insert_loss_auto($pd, $line_cd, $wi_plan, $item_cd, $seq_no, $shift_prd, $st_time, $end_time, $loss_time, $loss_type, $loss_id, $op_id, $transfer_flg, $flg_control){
	  	$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
	     	$dateTime = date('Y-m-d H:i:s');
            // today = datetime.today()
            // past_date = today + timedelta(days=1)
			if ($shift_prd == "P"){
				$arr_date_start = explode(" ", $st_time);
				echo $arr_date_start[0]."<br>";
				if ($arr_date_start[1]> "20:00:00"){
					$st_time = $arr_date_start[0]." 20:00:00";
				}
			}else if($shift_prd == "Q") {
				$arr_date_start = explode(" ", $st_time);
				if ($arr_date_start[1]> "08:00:00"){
					$st_time = $arr_date_start[0]." 08:00:00";
				}
			}
            $updated_date = $dateTime;
            $sql ="
            INSERT INTO loss_actual 
            (wi,
            line_cd,
            item_cd,
            seq_no,
            shift_prd,
            start_loss,
            end_loss,
            loss_time,
            updated_date,
            loss_type,
            loss_cd_id,
            line_op_id,
            pd,
            transfer_flg,
            flg_control) 
            VALUES 
            (
            '{$wi_plan}',
            '{$line_cd}',
            '{$item_cd}',
            NULL,
            '{$shift_prd}',
            '{$st_time}',
            '{$end_time}',
            '{$loss_time}',
            '{$updated_date}',
            '{$loss_type}',
            '{$loss_id}',
            '{$op_id}',
            '{$pd}',
            '{$transfer_flg}',
            '{$flg_control}')";
            // echo $sql."<br><br>";
            $query_check_loss = $this->TBK_FA01->query($sql);
    }
	public function GET_START_END_PRODUCTION_DETAIL_SPECTAIL_TIME(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$pwi_id = $_GET["pwi_id"];
		$sql  = "EXEC [dbo].[GET_DATA_START_END_PRODUCTION_DETAIL_SPECIAL_LINE] @pwi_id = '{$pwi_id}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if($get[0]["st_time"] == NUll){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GET_STATUS_DELAY_BY_LINE(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_cd = $_GET["line_cd"];
		$sql  = "Select delay_type from sys_line_mst where  enable = '1' and line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if($get[0]["delay_type"] == NUll){
			echo "0";
		}else{
			echo  $get[0]["delay_type"];
		}
	}
	public function GetDefectMenu(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_cd = $_GET["line_cd"];
		$sql  = "select * from mst_menu_ctrl where mmc_status_flg = 1 and mmc_menug_id = 1 and mmc_line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo  "1";
		}
	}
	public function Get_tag_group_no(){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql  = "Select * from tag_group where status = '1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["Get_tag_group_no"];
		}
	}
}
?>