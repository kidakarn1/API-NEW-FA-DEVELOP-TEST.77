<?php
class Check_detail_actual_insert_act extends CI_Controller
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
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			$lineCd = $_GET["line_cd"]; 
			$dateNow = date('Y-m-d');
			$tmpDateNow = date('Y-m-d');
			$updatDate = date('Y-m-d H:i:s');
			$timeNow = date('H:i:s');
			$delDate = date("Y-m-d",strtotime("-1 days",strtotime($dateNow)));
			 $addDate = date("Y-m-d",strtotime("+1 days",strtotime($dateNow)));
			 if ($timeNow>="08:00:00" and $timeNow<="20:00:00"){
			 	$dateNow = $delDate." 08:00:00";
			 	$addDate = $tmpDateNow." 20:00:00";
			 }else{
				 if ($timeNow>="00:00:00" and $timeNow<="07:59:59"){
				 	$dateNow = date("Y-m-d",strtotime("-1 days",strtotime($dateNow)))." 20:00:00";
				 }else{
			 		$dateNow = strval($dateNow)." 20:00:00";
				 }
			 	$addDate = strval($addDate)." 08:00:00";
			 }
			$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
// 		 	   $sqlGetDetail = "SELECT
// 	C.line_cd AS LINE_CD,
// 	C.wi_plan AS WI_PLAN,
// 	C.seq_no AS SEQ_NO,
// 	C.item_cd AS ITEM_CD,
// 	C.st_time AS ST_DATETIME,
// 	D.end_time AS END_DATETIME,
// 	CONVERT ( DATE, C.st_time ) AS ST_DATE,
// 	CONVERT ( DATE, D.end_time ) AS END_DATE,
// 	CONVERT ( TIME, C.st_time ) AS ST_TIME,
// 	CONVERT ( TIME, D.end_time ) AS END_TIME,
// 	swpsd.QTY AS PLAN_QTY,
// 	E.qty AS ACT_QTY_DETAILS,
// 	ISNULL( G.act_qty , NULL ) AS PRD_ACT_QTY,
// 	F.manpower AS MANPOWER,
// 	ISNULL( H.ACT_TOTAL , 0 ) AS ACT_TOTAL,
// 	ISNULL( I.TOTAL_BY_WI , 0 ) AS TOTAL_BY_WI_DETAILS,
// CASE
		
// 		WHEN ISNULL( I.TOTAL_BY_WI , 0 ) < swpsd.QTY THEN
// 		'0' 
// 		WHEN ISNULL( I.TOTAL_BY_WI , 0 ) >= swpsd.QTY THEN
// 		'1' 
// 	END AS FLG_COMPLETED 
// FROM
// 	(
// 	SELECT
// 		B.line_cd AS line_cd,
// 		B.wi_plan AS wi_plan,
// 		B.seq_no AS seq_no,
// 		B.item_cd AS item_cd,
// 		B.st_time AS st_time,
// 		NULL AS end_time,
// 		NULL AS QTY 
// 	FROM
// 		(
// 		SELECT
// 			ROW_NUMBER ( ) OVER ( PARTITION BY A.chk ORDER BY A.st_time ASC ) AS row_num,
// 			A.line_cd,
// 			A.wi_plan,
// 			A.seq_no,
// 			A.item_cd,
// 			A.st_time 
// 		FROM
// 			(
// 			SELECT
// 				line_cd,
// 				wi_plan,
// 				seq_no,
// 				CONCAT ( wi_plan, seq_no ) AS chk,
// 				item_cd,
// 				st_time 
// 			FROM
// 				production_actual_detail 
// 			WHERE
// 				st_time >= '{$dateNow}' 
// 				AND st_time <= '{$addDate}' 
// 				AND line_cd = '{$lineCd}' 
// 			GROUP BY
// 				line_cd,
// 				wi_plan,
// 				seq_no,
// 				item_cd,
// 				st_time 
// 			) AS A 
// 		) AS B 
// 	WHERE
// 		B.row_num = 1 
// 	) AS C
// 	LEFT OUTER JOIN (
// 	SELECT
// 		B.line_cd AS line_cd,
// 		B.wi_plan AS wi_plan,
// 		B.seq_no AS seq_no,
// 		B.item_cd AS item_cd,
// 		NULL AS st_time,
// 		B.end_time AS end_time,
// 		NULL AS QTY 
// 	FROM
// 		(
// 		SELECT
// 			ROW_NUMBER ( ) OVER ( PARTITION BY A.chk ORDER BY A.end_time DESC ) AS row_num,
// 			A.line_cd,
// 			A.wi_plan,
// 			A.seq_no,
// 			A.item_cd,
// 			A.end_time 
// 		FROM
// 			(
// 			SELECT
// 				line_cd,
// 				wi_plan,
// 				seq_no,
// 				CONCAT ( wi_plan, seq_no ) AS chk,
// 				item_cd,
// 				end_time 
// 			FROM
// 				production_actual_detail 
// 			WHERE
// 				st_time >= '{$dateNow}' 
// 				AND st_time <= '{$addDate}' 
// 				AND line_cd = '{$lineCd}' 
// 			GROUP BY
// 				line_cd,
// 				wi_plan,
// 				seq_no,
// 				item_cd,
// 				end_time 
// 			) AS A 
// 		) AS B 
// 	WHERE
// 		B.row_num = 1 
// 	) AS D ON C.wi_plan = D.wi_plan 
// 	AND C.seq_no = D.seq_no
// 	LEFT OUTER JOIN (
// 	SELECT NULL AS
// 		line_cd,
// 		wi_plan,
// 		seq_no,
// 		NULL AS item_cd,
// 		NULL AS st_time,
// 		NULL AS end_time,
// 		SUM ( qty ) AS qty 
// 	FROM
// 		production_actual_detail 
// 	WHERE
// 		st_time >= '{$dateNow}' 
// 		AND st_time <= '{$addDate}' 
// 		AND line_cd = '{$lineCd}' 
// 	GROUP BY
// 		wi_plan,
// 		seq_no 
// 	) AS E ON D.wi_plan = E.wi_plan 
// 	AND D.seq_no = E.seq_no
// 	LEFT OUTER JOIN (
// 	SELECT NULL AS
// 		line_cd,
// 		wi_plan,
// 		prd_seq_no AS seq_no,
// 		NULL AS item_cd,
// 		NULL AS st_time,
// 		NULL AS end_time,
// 		COUNT ( id ) AS manpower 
// 	FROM
// 		production_emp_detail_realtime 
// 	WHERE
// 		updated_date >= '$dateNow' 
// 		AND updated_date <= '$addDate' 
// 	GROUP BY
// 		wi_plan,
// 		prd_seq_no 
// 	) AS F ON E.wi_plan = F.wi_plan 
// 	AND E.seq_no = F.seq_no
// 	LEFT OUTER JOIN sup_work_plan_supply_dev AS swpsd ON F.wi_plan = swpsd.WI 
// 	AND swpsd.LVL = '1'
// 	LEFT OUTER JOIN (
// 	SELECT NULL AS
// 		line_cd,
// 		wi AS wi_plan,
// 		seq_no AS seq_no,
// 		NULL AS item_cd,
// 		NULL AS st_time,
// 		NULL AS end_time,
// 		act_qty AS act_qty 
// 	FROM
// 		production_actual 
// 	) AS G ON F.wi_plan = G.wi_plan 
// 	AND F.seq_no = G.seq_no
// 	LEFT OUTER JOIN (
// 	SELECT NULL AS
// 		line_cd,
// 		wi AS wi_plan,
// 		NULL AS seq_no,
// 		NULL AS item_cd,
// 		NULL AS st_time,
// 		NULL AS end_time,
// 		SUM ( act_qty ) AS ACT_TOTAL 
// 	FROM
// 		production_actual 
// 	GROUP BY
// 		wi 
// 	) AS H ON F.wi_plan = H.wi_plan
// 		LEFT OUTER JOIN (
// 	SELECT NULL AS
// 		line_cd,
// 		wi_plan,
// 		NULL as seq_no,
// 		NULL AS item_cd,
// 		NULL AS st_time,
// 		NULL AS end_time,
// 		SUM ( qty ) AS TOTAL_BY_WI 
// 	FROM
// 		production_actual_detail 
// 	GROUP BY
// 		wi_plan,
// 		line_cd
// 	) AS I  ON D.wi_plan = I.wi_plan 
// ORDER BY
// 	C.wi_plan,Q
// 	C.seq_no ASC";
	      $sqlGetDetail = "EXEC [dbo].[TRANFER_DATA_DETAILS_ACTUAL] @dateNow = '{$dateNow}' , @addDate = '{$addDate}' , @lineCd='{$lineCd}'";
	 
			$queryGetDetail = $this->TBK_FA01->query($sqlGetDetail);
			$rsGetDetail = $queryGetDetail->result_array();
	 		foreach ($rsGetDetail as $key => $value) {
	 			if(empty($value["PRD_ACT_QTY"]) And !empty($value["PLAN_QTY"]) AND $value["PRD_ACT_QTY"] != "0"){
	 				// echo "--->INSERT DATA";
	 				// echo "<br>";
	 				//exit();
	 				$this->insertProductionActual(
	 				 $value["WI_PLAN"] ,
	 				 $value["LINE_CD"] ,
	 				 $value["ITEM_CD"] ,
	 				 $value["PLAN_QTY"],
					 $value["ACT_QTY_DETAILS"],
					 $value["SEQ_NO"],
					 $this->getShift($value["ST_TIME"]),
					 $value["MANPOWER"],
					 $value["ST_DATETIME"],
					 $value["ST_TIME"],
					 $value["END_DATETIME"],
					 $value["END_TIME"],
					 $this->getLotNo($value["ST_TIME"] , $value["ST_DATE"]),
					 $value["FLG_COMPLETED"],
					 "1",
					 "0",
					 "2"
	 				);
	 				if ($value["FLG_COMPLETED"] == "1"){
	 					$this->updatedPlan($value["WI_PLAN"]);
	 				}
	 			}
	 		}
		}
		public function test_lot(){
			date_default_timezone_set('Asia/bangkok');
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			// echo $this->getLotNo("08:09:00" , "2023-01-04");
		}
		public function getLotNo($sTime , $prdDate){
		//	echo "result==>".$sTime;
			if ($sTime >= "00:00:00" and  $sTime <= "07:59:59"){
			 	$dateLotNo = date("Y-m-d",strtotime("-1 days",strtotime($prdDate)));
			 	$lotNo = $this->GETLOT_TBKKFATHAILAND($dateLotNo);
			}else{
		 	  	$dateLotNo = $prdDate;
			 	$lotNo = $this->GETLOT_TBKKFATHAILAND($dateLotNo);
			}	
//echo $lotNo;
//exit();
			return $lotNo;
		}
		public function getShift($newDateTime){
	 		if($newDateTime >= "08:00:00" and  $newDateTime <= "20:00:00"){
				$shift = "P";
			}else if($newDateTime >= "20:00:00" and  $newDateTime <= "23:59:59" ){
			 	$shift = "Q";
			}else if($newDateTime >= "00:00:00" and  $newDateTime <= "07:59:59" ){
				$shift = "Q";
		 	}
		 	return $shift;
		}
	public function insertProductionActual($WI_PLAN,$LINE_CD,$ITEM_CD,$PLAN_QTY,$ACT_QTY,$SEQ_NO,$SHIFT,$MANPOWER,$ST_DATETIME,$ST_TIME,$END_DATETIME,$END_TIME,$LotNo,$FLG_COMPLETED,$FLG_TRANFER,$DEL_FLG,$CLOSE_LOT_FLG){
			if($ACT_QTY < 0){
				$ACT_QTY = "0";
			}
			echo    $sqlInsert = "INSERT into production_actual
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
			 		   '{$WI_PLAN}',
			 		   '{$LINE_CD}',
			 		   '{$ITEM_CD}',
			 		   '{$PLAN_QTY}',
			 		   '{$ACT_QTY}',
			 		   '{$SEQ_NO}',
			 		   '{$SHIFT}',
			 		   '{$MANPOWER}',
			 		   '{$ST_DATETIME}',
			 		   '{$ST_TIME}',
			 		   '{$END_DATETIME}',
			 		   '{$END_TIME}',
			 		   '{$LotNo}',
			 		   '{$FLG_COMPLETED}',
			 		   '1',
			 		   '0',
			 		   CURRENT_TIMESTAMP,
			 		   '2'
			 		)";
					$queryInsertProduction = $this->TBK_FA01->query($sqlInsert);
					if($queryInsertProduction){
						echo "true";
						//return true ; 	

					}else{
						echo "false";
						//return false ; 
					}
	}
	public function updatedPlan($Wi){
		  $sqlUpdate = "Update sup_work_plan_supply_dev set PRD_COMP_FLG = '9' where WI = '{$Wi}'";
		$queryInsertProduction = $this->TBK_FA01->query($sqlUpdate);
		if($queryInsertProduction){
			return "true";
			//return true ; 
		}else{
			return "false";
			//return false ; 
		}
	}













 public function Get_detail_act_old(){
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