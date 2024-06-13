<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}
th, td {
  text-align: left;
  padding: 8px;
}
tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<?php
class Api_show_data extends CI_Controller
{
	public function index(){
		$index = 0;
		$this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		$sql = "select * from sys_prod_time_ctrl where enable = '1'";
		$query_get_detail = $this->tbkkfa01_db->query($sql);
		$get_detail = $query_get_detail->result_array();
		$start_date =  "2022-06-08 07:00:00"; //date("Y-m-d 07:00:00");
		$end_date =    "2022-06-08 08:00:00"; //date("Y-m-d 08:00:00");
		$array_loss_code = array();
		// $std_ct1 = $_GET["std_ct"];
		$line_cd = $_GET["line_cd"];
		// echo $start_date;
		echo "<br>";
		echo "<button id='yesert_day'>YESER DAY</button>";
		echo "<br>";
		echo "<br>";
		echo "<button id='today'>TODAY</button>";
		echo "<br>";
		for ($i=1;$i<=24;$i++){ 
			$start_date = strtotime("+60 minutes", strtotime($start_date));
			$end_date = strtotime("+60 minutes", strtotime($end_date));
			$start_date = date('Y-m-d H:i:s', $start_date);
			$end_date =  date('Y-m-d H:i:s', $end_date);
			$sql_get_data = "SELECT
				distinct pd_act.item_cd,
				swps.CT
			FROM
				production_actual_detail_copy5 as pd_act , 
				sup_work_plan_supply_dev as swps
			WHERE
				(
					pd_act.st_time BETWEEN '$start_date'
					AND '$end_date'
					AND pd_act.line_cd = '$line_cd'
					AND pd_act.wi_plan = swps.WI
					AND swps.LVL = '1'
				)
			OR (
				pd_act.end_time BETWEEN '$start_date'
				AND '$end_date'
				AND pd_act.line_cd = '$line_cd'
					AND pd_act.wi_plan = swps.WI
					AND swps.LVL = '1'
			)
			 ";
			$query_get_data = $this->tbkkfa01_db->query($sql_get_data);
			$get_query_data = $query_get_data->result_array();	
	 	  	$sql_get_loss = "SELECT * from loss_actual , sys_loss_mst  where  flg_control != '2'  and  (start_loss between '$start_date' and '$end_date' and line_cd = '$line_cd' and loss_actual.loss_cd_id = sys_loss_mst.id ) or (end_loss between '$start_date' and '$end_date'  and   line_cd = '$line_cd' and  loss_actual.loss_cd_id = sys_loss_mst.id) ";
			 $query_loss = $this->tbkkfa01_db->query($sql_get_loss);
			 $result_loss   = $query_loss->result_array();
			// Get data and result loss 
			$loss_code_id[] = "" ;
			$total_time[] = 0 ;
			$total_good[] = 0 ;
			$total_nc[] = 0 ;
			$total_ng[] = 0 ;
			$std_ct[] = 1;
	 		if (empty($get_query_data[0]["CT"])){
	 			$std_ct[$index] = "1";	
	 		}else{
	 			 $std_ct[$index] = $get_query_data[0]["CT"];
	 		}
			 if (empty($result_loss)){
			 	 $loss_code_id[$index] = "";
			 }else{
			 	$count_length = 0;
	 			foreach ($result_loss as $key => $value) {
	 				$count_length +=1;
			 		$loss_code_id[$index] .=  $value["loss_cd"];
			 		$total_time[$index]   +=  $value["loss_time"];
			 		// echo "<br>";
			 		if ($count_length < count($result_loss)){
			 			$loss_code_id[$index] .= " / ";
			 		}
			 	}
			 }
			 // echo $loss_code_id;
			 // start get result good
		   	 $sql_get_good = "SELECT
	SUM (qty) AS good ,
(
		SELECT
			SUM (qty) AS deflg_NC
		FROM
			production_actual_detail_copy5
		WHERE
				flg_defect = 1
		AND (
			(
			    line_cd = '$line_cd'
				AND st_time BETWEEN '$start_date'
				AND '$end_date'
				
			)
			OR (
				line_cd = '$line_cd'
				AND end_time BETWEEN '$start_date'
				AND '$end_date'
				
			)
		)
	) as NC ,
(
		SELECT
			SUM (qty) AS deflg_NC
		FROM
			production_actual_detail_copy5
		WHERE
				flg_defect = 2
		AND (
			(
			    line_cd = '$line_cd'
				AND st_time BETWEEN '$start_date'
				AND '$end_date'
			)
			OR (
				line_cd = '$line_cd'
				AND end_time BETWEEN '$start_date'
				AND '$end_date'
			)
		)
	) as NG 
FROM
	 production_actual_detail_copy5
WHERE
	(
		flg_defect IS NULL
		OR flg_defect = 0
	)
AND (
	(
	    line_cd = '$line_cd'
		AND st_time BETWEEN '$start_date'
		AND '$end_date'
	)
	OR (
		line_cd = '$line_cd'
		AND end_time BETWEEN '$start_date'
		AND '$end_date'
	)
)";
			 $query_good = $this->tbkkfa01_db->query($sql_get_good);
			 $result_good   = $query_good->result_array();
			 foreach ($result_good as $key_good => $value_good) {
			 		$total_good[$index] = $value_good["good"];
			 		if (empty($value_good["NC"])){
						$total_nc[$index] = 0;
			 		}else{
			 			$total_nc[$index] = $value_good["NC"];
			 		}
			 		if (empty($value_good["NG"])){
						$total_ng[$index] = 0;
			 		}else{
			 			$total_ng[$index] = $value_good["NG"];
			 		}
			 		
			 }
			 // echo "<br>";
			 $index++;
			 // echo "<br>";
		}
		parse_str($_SERVER['QUERY_STRING'], $_GET);
	  	
	  	echo "<h1>Today</h1>";
		echo "<table border='1' width='70%'>";
		echo "<tr>";
			echo "<th rowspan ='3'>Time</th>";
			echo "<th rowspan ='3' >Plan/Hr </th>";
			echo "<th colspan='5'>Shift A </th>";
			// echo "<th colspan='5'>Shift B </th>";
		echo "</tr>";
// Shift A
		echo "<tr>";
			echo "<td rowspan='2'>OK</td>";
			// echo "<td colspan='2'>Defect</td>";
			echo "<td rowspan ='2'>Problem Loss</td>";
			echo "<td rowspan ='2'>Total Loss</td>";
			// echo "<td colspan='2'>Defect</td>";
			// echo "<td rowspan ='2'>Problem Loss</td>";
			// echo "<td rowspan ='2'>Total Loss</td>";
		echo "</tr>";
		echo "<tr>";
			// echo "<td>NC</td>";
			// echo "<td>NG</td>";
		// 	echo "<td>NC</td>";
		// 	echo "<td>NG</td>";
		echo "</tr>";
		$start_time = "7:00:00";
		$end_time =  "7:00:00";
		$plan_by_hour="";
		$i  = 0 ;
		foreach ($get_detail as $key => $value) {
			// echo $std_ct[$i];
			// echo "<br>";
			// $plan_by_hour  = intval(($value["prod_sum_time"] *60) / $std_ct);
			if ($std_ct[$i]=="1"){
				$plan_by_hour  = "NO PRODUCTION WORK.";
			}else{
				$plan_by_hour  = Intval(($value["prod_sum_time"]) /  $std_ct[$i]);
			}
			if (empty($total_good[$i])){
				$total_good[$i]  = "0";
			} 
			echo "<tr>";	
			echo "<td>".$value["prod_str_time"]." - ". $value["prod_end_time"] ."</td>";
			echo "<td>".$plan_by_hour."</td>";
			echo "<td>".$total_good[$i]."</td>";
			// echo "<td>".$total_nc[$i]."</td>";
			// echo "<td>".$total_ng[$i]."</td>";
			echo "<td>".$loss_code_id[$i]."</td>";
			echo "<td>".$total_time[$i]."</td>";
			echo "</tr>";	
			$i ++;
		}
		echo "</table>";
// end shift A
	}
}
?>