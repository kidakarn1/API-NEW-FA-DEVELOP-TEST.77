<?php
class Check_detail_actual extends CI_Controller
{
	public function index(){
		echo "TEST";
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
		$date_now = date('Y-m-d');
		$time_n = date('H:i:s');
		$date_now_plus = date("Y-m-d",strtotime("+1 days",strtotime($date_now)));
		if ($time_n>="08:00:00" and $time_n<="20:05:00"){
			$date_now = $date_now." 08:00:00";
			$date_now_plus = $date_now_plus." 20:00:00";
		}else{
			$date_now = strval($date_now)." 20:00:00";
			$date_now_plus = strval($date_now_plus)." 08:00:00";
		}
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		// $line_cd = $_GET["line_cd"]; 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		   $sql  = "select  max(number_qty) as max_qty , line_cd , wi_plan , seq_no ,  item_cd from production_actual_detail where st_time >= '$date_now' and st_time<='$date_now_plus'  group by line_cd , wi_plan , seq_no ,  item_cd";
		  echo "<br>";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		// if(empty($get)){
			// echo "0";
		// }else{
			// echo json_encode($get);
	// print_r($get);
		 $total_act = 0;
		 $index = 0;
	 	 $G_WI = $get[0]["wi_plan"];
	 	 $G_INDEX = 0;
	 	 echo $G_WI;
		foreach ($get as $key => $value) {
				$wi = $value["wi_plan"];
				if($wi != $G_WI){
					echo "<br>"."-----------------------------------------------------=";
					$G_WI = $wi;
					echo $G_WI;
					echo "<br>"; 
					$total_act = 0;
					$total_qty_act = 0;
					$index = 0;
				}
				$line_cd = $value["line_cd"];
			 	$seq_no = $value["seq_no"];
			 	$item_cd = $value["item_cd"];
			 	$act_qty = $value["max_qty"];
	 	 		$sql_detail_stdate  = "select  TOP 1 st_time  from production_actual_detail where  wi_plan = '$wi' and seq_no = '$seq_no' order by  id asc";
				echo "<br>";
				$query_detail_stdate = $this->TBK_FA01->query($sql_detail_stdate);
		 		$get_detail_st_date = $query_detail_stdate->result_array();
	 	 		 $sql_detail_enddate  = "select  TOP 1 end_time  from production_actual_detail where  wi_plan = '$wi' and seq_no = '$seq_no' order by  id desc";
				$query_detail_dendate = $this->TBK_FA01->query($sql_detail_enddate);
		 		$get_detail_end_date = $query_detail_dendate->result_array();
				echo "<br>";
			 	$st_time = $get_detail_st_date["0"]["st_time"];
			 	$end_time = $get_detail_end_date["0"]["end_time"];
			 	$st_time_naja = substr($st_time,10);
			 	$end_time_naja = substr($end_time,10);

			 	echo $sql_get_id = "select max(id) as c_m_id from production_actual_detail where wi_plan='$wi' and seq_no = '$seq_no' and line_cd = '$line_cd'";
 				$query_get_id = $this->TBK_FA01->query($sql_get_id);
			 	$get_get_id = $query_get_id->result_array();
			 	echo "<br>";
			 	echo  $m_id= $get_get_id[0]["c_m_id"];
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo $sql_get_number_qty = "select number_qty from production_actual_detail where id='$m_id'";
				$query_get_number_qty = $this->TBK_FA01->query($sql_get_number_qty);
			 	$get_get_number_qty = $query_get_number_qty->result_array();
				echo $qty_seq = $get_get_number_qty[0]["number_qty"];
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "qty_seq===>".$qty_seq;
			 	$sql_check_act = "select count(id) as c_id from production_actual_copy where wi='$wi' and line_cd = '$line_cd' and seq_no ='$seq_no'";
			    $query_check_act = $this->TBK_FA01->query($sql_check_act);
			 	$get_check_act = $query_check_act->result_array();
			 	$sql_get_total_act = "select sum(act_qty) as m_qty from production_actual_copy where wi='$wi' and line_cd = '$line_cd'";
			    $query_get_total_act = $this->TBK_FA01->query($sql_get_total_act);
			 	$get_total_act = $query_get_total_act->result_array();
				$total_qty_act =  $qty_seq - $get_total_act[0]["m_qty"];
			 	$check_data = $get_check_act["0"]["c_id"];
    		 	$sql_get_plan_qty = "select QTY from sup_work_plan_supply_dev where WI ='$wi'";
			    $query_get_plan_qty = $this->TBK_FA01->query($sql_get_plan_qty);
			 	$get_plan_qty = $query_get_plan_qty->result_array();
				$data_plan_qty = $get_plan_qty["0"]["QTY"];
			 	$check_data = $get_check_act["0"]["c_id"];
			 	 $newDateTime = date('H:i:s', strtotime($st_time));
			 	 $check_a = date('A', strtotime($st_time)); 
			 	 $shift = "";
			 	 $total_data_qty = 0;
 			 	if ($check_data == "0") {
			 		if($newDateTime >= "08:00:00" and  $newDateTime <= "20:00:00"){
						$shift = "P";
	 			 	}else if($newDateTime >= "20:00:00" and  $newDateTime <= "23:59:59" ){
	 			 		$shift = "Q";
	 			 	}else if($newDateTime >= "00:00:00" and  $newDateTime <= "07:59:59" ){
						$shift = "Q";
	 			 	}
					// }else if ($check_a == "PM") {
						 
					// }

				 	if ($newDateTime >= "00:00:00 AM" and  $newDateTime <= "07:59:59" ){
				 		$date_lot_no = date("Y-m-d",strtotime("-1 days",strtotime(substr($st_time,0,10))));
				 		$lot_no = $this->GETLOT_TBKKFATHAILAND($date_lot_no);
				 	 }
				 	  else
			 	  	 {
			 	  	 	$date_lot_no =substr($st_time,10);
				 	  	$lot_no = $this->GETLOT_TBKKFATHAILAND($date_lot_no);
				 	 }
				 	// echo  $lot_no."====>".$st_time;
				 	echo "<br>";
				 	echo "<br>";
				 	echo "<br>";
				 	$sql = "select count(id) as c_id from production_emp_detail_realtime where wi_plan = '$wi' and prd_seq_no = '$seq_no'";
 					$query = $this->TBK_FA01->query($sql);
		 			$get_count_man = $query->result_array();
		 			$manpower_no = $get_count_man[0]["c_id"];	

		 			 $sql_total =  "select max(id) M_id  ,sum(qty)as number_qty , wi_plan from production_actual_detail where wi_plan = '$wi' and line_cd = '$line_cd' group by  wi_plan , seq_no";
					$query_total = $this->TBK_FA01->query($sql_total);
		 			$get_count_total = $query_total->result_array();
				// exit();
	 				// foreach ($get_count_total as $key3 => $value3) {
	 					$tmp_act_qty = 0;
	 					if ($get_count_total[$index]["number_qty"]> 0 ){
			 				 $total_act += $get_count_total[$index]["number_qty"];
	 					}
		 				 // $tmp_act_qty = $total_qty_act;
	 					//else{
	 					//	 $tmp_act_qty = 0;
	 					//}
	 				// }
		 			if ($total_act<$data_plan_qty){
		 				$comp_flg = "0";
		 			}else{
		 				$comp_flg = "1";
		 			}
		 			// if ($get_count_total[$index]["number_qty"]>=0 ){
		 				 $sql = "insert into production_actual_copy
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
				 		 close_lot_flg  )
				 		 values(
				 		   '$wi',
				 		   '$line_cd',
				 		   '$item_cd',
				 		   '$data_plan_qty',
				 		   '$total_qty_act',
				 		   '$seq_no',
				 		   '$shift',
				 		   '$manpower_no',
				 		   '$st_time',
				 		   '$st_time_naja',
				 		   '$end_time',
				 		   '$end_time_naja',
				 		   '$lot_no',
				 		   '$comp_flg',
				 		   '1',
				 		   '0',
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
		 			 // }//else{
		 			// 	$seq_no -=1;
		 			// 	echo $sql = "select id , act_qty  from production_actual where wi='$wi' and line_cd = '$line_cd' and seq_no ='$seq_no'";
		 			// 		$query = $this->TBK_FA01->query($sql);
		 			// 		$result = $query->result_array();
		 			// 		if(!empty($result[0]["id"])){
						// 	$id = $result[0]["id"];
		 			// 		echo "<br>".$act_qty = $result[0]["act_qty"];
		 			// 		echo "<br>".$act_qty_update = $result[0]["act_qty"] - abs($get_count_total[$index]["number_qty"]);
		 			// 		$update = "update production_actual set act_qty = '$act_qty_update' where id='$id'";
		 			// 		$query_update = $this->TBK_FA01->query($update);
		 			// 		}
		 			// }
		 			$index++;
			 	}
		}
	}
}
?>