<?php
class GET_DATA_NEW_FA extends CI_Controller
{
	public function Get_Plan_All_By_Line(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_cd = $_GET["line_cd"];
		$shift = $_GET["shift"];
		$dateStart = $_GET["dateStart"];
		$rs_shift = $this->Get_time_start_shift($shift);
		$start_date = $dateStart." ".substr($rs_shift[0]["master_start_shift"], 0, 8 );
		$timeNow =  date('H:i:s'); //"00:59:59";
		$hour = "";
		$end_date =  date("Y-m-d")." ".$timeNow;
		$sql  = "EXEC [dbo].[GET_ALL_PLAN_BY_LINE] @line_cd = '{$line_cd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			  "0";
		}else{
			  $sql  = "EXEC [dbo].[CHECK_TRANSCETION_PRODUCTION_DETAIL] @line_cd = '{$line_cd}' , @date_start = '{$start_date}' , @date_end = '{$end_date}'";
			$query = $this->TBK_FA01->query($sql);
			$get = $query->result_array();
			if(empty($get)){
				$dateTimeObject1 = date_create($start_date); 
				$dateTimeObject2 = date_create($end_date); 
				$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
				$minutes = $difference->days * 24 * 60;
				$minutes += $difference->h * 60;
				$minutes += $difference->i;
				$data["Start_Loss"] = $start_date;
				$data["End_Loss"] = $end_date;
				$data["Loss_Time"] = $minutes;
				$data["Loss_Code"] = "36";
				echo json_encode($data);
			}else{
				// echo json_encode($get);
				// echo "<br>";
				$dateTimeObject1 = date_create($get[0]["end_time"]); 
				$dateTimeObject2 = date_create($end_date); 
				$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
				$minutes = $difference->days * 24 * 60;
				$minutes += $difference->h * 60;
				$minutes += $difference->i;
				// echo $minutes.' minutes';
				$data[0] = array(
					"Start_Loss" => $get[0]["end_time"],
					"End_Loss" => $end_date,
					"Loss_Time" => $minutes,

				);
				// $data["Start_Loss"] = $get[0]["end_time"];
				// $data["End_Loss"] = $end_date;
				// $data["Loss_Time"] = $minutes;
				echo json_encode($data);
			}
		}
	}
}
?>