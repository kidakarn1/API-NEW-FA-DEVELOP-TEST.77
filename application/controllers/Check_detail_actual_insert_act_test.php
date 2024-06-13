<?php
class Check_detail_actual_insert_act_test extends CI_Controller
{
	public function index(){
		echo "TEST";
	}
	public function Daily_balance_actual(){
		$this->connect_tbkk = $this->load->database('test_new_fa02', true);
		$sql = "select * from sys_line_mst where chk_sys_flg = '1'";
		$query_get_detail = $this->connect_tbkk->query($sql_get_detail);
		$result = $query_get_detail->result_array();
		foreach ($result as $key => $value) {
			echo $value["line_cd"]."<br>";
		}
	}

	public function GETLOT_TBKKFATHAILAND($lot_dt)
  {
   $G_WI = "";
   $_YEARS = array ('J', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
   $_MONTH = array ('L', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');

   $D = date('d',strtotime($lot_dt));
   $M = date('m',strtotime($lot_dt));
   $Y = date('y',strtotime($lot_dt));

   //echo $_YEARS[($Y % 10)].$_MONTH[($M % 12)].$D; exit();
   return $_YEARS[($Y % 10)].$_MONTH[($M % 12)].$D;
  }
    public function Get_detail_act(){
	
			date_default_timezone_set('Asia/bangkok');
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			$line_cd = $_GET["line_cd"]; 
			$date_now = date('Y-m-d');
			$date_now_1 = date('Y-m-d');
			$updated_date = date('Y-m-d H:i:s');
			$time_n = date('H:i:s');
			$date_del = date("Y-m-d",strtotime("-1 days",strtotime($date_now)));
			// $time_n = "07:28:00";
			 $date_now_plus = date("Y-m-d",strtotime("+1 days",strtotime($date_now)));
			 if ($time_n>="08:00:00" and $time_n<="20:00:00"){
			 	echo "IF"."<br>";
			 	$date_now = $date_del." 08:00:00";
			 	$date_now_plus = $date_now_1." 20:00:00";

			 }else{
			 	echo "ELSE";
				 if ($time_n>="00:00:00" and $time_n<="07:59:59"){
				 	echo "<br>"."ELSE (IF)";
				 	 $date_now = date("Y-m-d",strtotime("-1 days",strtotime($date_now)))." 20:00:00";
				 }else{
				 	echo "<br>"."ELSE (ELSE)";
			 		  $date_now = strval($date_now)." 20:00:00";
				 }
			 	$date_now_plus = strval($date_now_plus)." 08:00:00";
			 }
			$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
			//$date_now = date('Y-m-d');
			$time_n = date('H:i:s');
			//$date_now_old = $date_now." 08:00:00";//date("Y-m-d",strtotime("-1 days",strtotime($date_now)))." 08:00:00";
			// $date_now_plus = date("Y-m-d",strtotime("+1 days",strtotime($date_now)))." 08:00:00";
			echo $sql_get_detail = "SELECT MAX (id) AS max_id, sum(qty) as total_qty , line_cd, wi_plan, seq_no, item_cd FROM production_actual_detail WHERE st_time >= '$date_now' AND st_time <= '$date_now_plus' AND line_cd = '$line_cd' GROUP BY line_cd, wi_plan, seq_no, item_cd";
			$query_get_detail = $this->TBK_FA01->query($sql_get_detail);
			$get_detail = $query_get_detail->result_array();
			// echo "<pre>";
			// 	print_r($get_detail);
			// echo "</pre>";
			foreach ($get_detail as $key => $value) {
				$line_cd = $value["line_cd"];
			 	$seq_no = $value["seq_no"];
			 	$item_cd = $value["item_cd"];
			 	$max_id = $value["max_id"];
			 	$total_qty = $value["total_qty"];
			 	$wi_plan = $value["wi_plan"];
			 	$sql_actual = "select  count(id) as c_id from production_actual where wi='$wi_plan' and seq_no = '$seq_no' and prd_st_date >= '$date_now' and prd_st_date <= '$date_now_plus'";
		 		$query_check_actual = $this->TBK_FA01->query($sql_actual);
				$result_check_actual = $query_check_actual->result_array();
				$check_data_act = $result_check_actual[0]["c_id"];
			 	$sql_get_plan_qty = "select QTY from sup_work_plan_supply_dev where WI ='$wi_plan'";
		   	 	$query_get_plan_qty = $this->TBK_FA01->query($sql_get_plan_qty);
			 	$get_plan_qty = $query_get_plan_qty->result_array();
			 	$plan_qty = $get_plan_qty[0]["QTY"];
			 	$sql_detail_stdate  = "select  TOP 1 st_time  from production_actual_detail where  wi_plan = '$wi_plan' and seq_no = '$seq_no' and st_time >= '$date_now' and st_time <= '$date_now_plus' order by  id asc";
				$query_detail_stdate = $this->TBK_FA01->query($sql_detail_stdate);
				$get_detail_st_date = $query_detail_stdate->result_array();
				$sql_detail_enddate  = "select  TOP 1 end_time  from production_actual_detail where  wi_plan = '$wi_plan' and seq_no = '$seq_no' and st_time >= '$date_now' and st_time <= '$date_now_plus'order by  id desc";
				$query_detail_dendate = $this->TBK_FA01->query($sql_detail_enddate);
				$get_detail_end_date = $query_detail_dendate->result_array();
			 	$st_time = $get_detail_st_date["0"]["st_time"];
			 	$end_time = $get_detail_end_date["0"]["end_time"];
			 	$st_time_short = substr($st_time,10);
		 		$end_time_short = substr($end_time,10);
			 	$newDateTime = date('H:i:s', strtotime($st_time));
			 	$sql = "select count(id) as c_id from production_emp_detail_realtime where wi_plan = '$wi_plan' and prd_seq_no = '$seq_no'";
				$query = $this->TBK_FA01->query($sql);
	 			$get_count_man = $query->result_array();
	 			$manpower_no = $get_count_man[0]["c_id"];
			 	if ($newDateTime >= "00:00:00 AM" and  $newDateTime <= "07:59:59" ){
			 		$date_lot_no = date("Y-m-d",strtotime("-1 days",strtotime(substr($st_time,0,10))));
			 		$lot_no = $this->GETLOT_TBKKFATHAILAND($date_lot_no);
				 }else{
		 	  	 	$date_lot_no =substr($st_time,0,10);
			 	  	$lot_no = $this->GETLOT_TBKKFATHAILAND($date_lot_no);
			 	 }	
				if ($check_data_act == "0"){
					$sql_get_sum_act = "select  sum(act_qty) as act_qty from production_actual where wi = '$wi_plan'";
					$query_get_sum_act = $this->TBK_FA01->query($sql_get_sum_act);
	 				$result_get_sum_act = $query_get_sum_act->result_array();
	 				$total_qty_of_wi = $total_qty+$result_get_sum_act[0]["act_qty"];
			 		if($newDateTime >= "08:00:00" and  $newDateTime <= "20:00:00"){
						$shift = "P";
			 		}else if($newDateTime >= "20:00:00" and  $newDateTime <= "23:59:59" ){
			 			$shift = "Q";
			 		}else if($newDateTime >= "00:00:00" and  $newDateTime <= "07:59:59" ){
						$shift = "Q";
			 		}
		 			if ($total_qty_of_wi<$plan_qty){
		 				$comp_flg = "0";
		 			}else{
		 				$comp_flg = "1";
		 			}
		 			if ($total_qty>0){

		 			}else{
		 				$total_qty = 0;
		 			}
					 $sql = "insert into production_actual
			 		 (wi ,		
			 		 line_cd ,
			 		 item_cd , 
			 		 plan_qty , 
			 		 act_qty ,
			 		 seq_no ,  
			 		 shift_prd , 
			 		 manpower_no , 
			 		 prd_st_date , 
			 		 prd_st_time , 
			 		 prd_end_date , 
			 		 prd_end_time , 
			 		 lot_no ,
			 		 comp_flg ,
			 		 transfer_flg , 
			 		 del_flg,
			 		 updated_date,
			 		 close_lot_flg  )
			 		 values(
			 		   '$wi_plan',
			 		   '$line_cd',
			 		   '$item_cd',
			 		   '$plan_qty',
			 		   '$total_qty',
			 		   '$seq_no',
			 		   '$shift',
			 		   '$manpower_no',
			 		   '$st_time',
			 		   '$st_time_short',
			 		   '$end_time',
			 		   '$end_time_short',
			 		   '$lot_no',
			 		   '$comp_flg',
			 		   '1',
			 		   '0',
			 		   '$updated_date',
			 		   '2'
			 		)";
			 		$query_detail_dendate = $this->TBK_FA01->query($sql);
			 		if($query_detail_dendate){
			 			echo "INSERT OK";
			 			echo "<br>";
			 		}else{
			 			echo "INSERT FALL";
			 			echo "<br>";
			 		}
					echo "<br>";

				}else{
					echo "HAVE DATA";
					echo "<br>";
				}
			} //end foreach
		}
	}
?>