<?php
class GET_OEE extends CI_Controller
{
	public function GET_TARGET(){
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$Shift = $_GET["shift"];
		$wi = $_GET["WI"];
		$actual = $_GET["actual"];
		$this->test_new_fa02 = $this->load->database('test_new_fa02', true);
		$sql = " Select * from sup_work_plan_supply_dev where WI = '{$wi}' and LVL = '1'";
		$query = $this->test_new_fa02->query($sql);
		$get = $query->result_array();
		if(!empty($get)){
			$Target = $this->Manage_Target($Shift  , $get , $actual);
			echo $Target;
		}
	}
	public function GetDataAvailabillty(){
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$this->test_new_fa02 = $this->load->database('test_new_fa02', true);
		$line_cd = $_GET["line_cd"];
		$lot_no = $_GET["lot_no"];
		$sql = "SELECT TOP
		3 slm.loss_cd ,
		SUM ( la.loss_time ) AS lossTime,
		(
		SELECT SUM
			( la2.loss_time ) 
		FROM
			loss_actual AS la2
			INNER JOIN production_working_info AS pwi2 ON pwi2.pwi_id = la2.pwi_id 
		WHERE
			pwi2.pwi_lot_no = '{$lot_no}' 
			AND la2.line_cd = '{$line_cd}' 
		) AS AllLossTime 
	FROM
		loss_actual AS la,
		production_working_info AS pwi ,
		sys_loss_mst as slm
	WHERE
		pwi.pwi_lot_no = '{$lot_no}' 
		AND pwi.pwi_id = la.pwi_id 
		AND la.line_cd = '{$line_cd}' 
		AND la.loss_cd_id = slm.id
	GROUP BY
		slm.loss_cd 
	ORDER BY
		SUM ( la.loss_time ) DESC";
		$query = $this->test_new_fa02->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}	
	}
	public function getAccTarget(){
		// Parse the query string
		parse_str($_SERVER['QUERY_STRING'], $_GET);
	
		// Load the database
		$this->test_new_fa02 = $this->load->database('test_new_fa02', true);
	
		// Get input parameters
		$st_shift = $_GET["st_shift"];
		$std_ct = $_GET["std_ct"];
	
		// Get the current hour
		$timeCurr = date("H");
	
		// Define start date and current date/time
		$date_start = date("Y-m-d") . " " . $st_shift . ":00";
		$dateTimeCurr = date("Y-m-d H:i:s");
	
		// Adjust start date if the current time is between 0 and 7 (for night shifts)
		if($timeCurr > 0 && $timeCurr < 7){
			$date_start = date("Y-m-d", strtotime("-1 day", strtotime($date_start))) . " " . $st_shift . ":00";
		}
	
		// Calculate the difference between the start date and current date/time
		$diffdatesec = $this->dateDiffInSeconds($date_start, $dateTimeCurr);
	 
		// Output or further processing
		echo intval($diffdatesec/$std_ct);;
	}
	
	function dateDiff($date1, $date2) {
		// Create DateTime objects
		$datetime1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1);
		$datetime2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2);
	
		// Calculate the interval
		$interval = $datetime1->diff($datetime2);
	
		// Return the interval as an associative array
		return [
			'years' => $interval->y,
			'months' => $interval->m,
			'days' => $interval->d,
			'hours' => $interval->h,
			'minutes' => $interval->i,
			'seconds' => $interval->s,
			'total_days' => $interval->days,
			'formatted' => $interval->format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds')
		];
	}
	function dateDiffInSeconds($date1, $date2) {
		// Create DateTime objects from string dates
		$datetime1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1);
		$datetime2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2);
	
		// Calculate the difference in seconds
		$interval = $datetime1->diff($datetime2);
		$total_seconds = $interval->s  // seconds
					   + $interval->i * 60  // minutes
					   + $interval->h * 3600  // hours
					   + $interval->d * 86400  // days
					   + $interval->m * 2592000  // months (assuming 30 days/month)
					   + $interval->y * 31536000; // years (assuming 365 days/year)
	
		return $total_seconds;
	}
	public function Manage_Target($Shift , $get , $actual){
		if($Shift == "P" || $Shift == "Q"){
			$workTime = 12*60;
			$Break = 90;
			$ProductionTime = $workTime - $Break;
		}elseif ($Shift == "A" || $Shift == "B" || $Shift == "S") {
			$workTime = 9*60;
			$Break = 60;
			$ProductionTime = $workTime - $Break;
		}elseif ($Shift == "M" || $Shift == "N"){
			$workTime = 3*60;
			$Break = 10;
			$ProductionTime = $workTime - $Break;
		}else{
			return 0;
		}
		if(is_null($get[0]["CT"])){
			return 0;
		}else{
			$Target = $ProductionTime*$get[0]["CT"];
			$Plan = $get[0]["QTY"];
			if($Target > $Plan){
				if($Plan - $actual > 0){
					return intval($Plan) - intval($actual);
				}else{
					return 0;
				}
			}else{
				$Target_remain = $Plan - $actual;
				if($Target > $Target_remain){
					return $Target_remain;
				}else{
					return intval($Target);
				}
			}
		}
	}
	public function GetDataByHour(){
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"];
		$date = date('Y-m-d')." 08:00:00"; 
		$date2 =date('Y-m-d')." 20:00:00"; //date('Y-m-d', strtotime("tomorrow"))." 20:00:00";
		// $hour  = $_GET["hour"];
		$this->test_new_fa02 = $this->load->database('test_new_fa02', true);
		   $sql = "WITH MinuteRange AS (
			SELECT CAST('$date' AS DATETIME) AS minute_start
			UNION ALL
			SELECT DATEADD(MINUTE, 10, minute_start)
			FROM MinuteRange
			WHERE DATEADD(MINUTE, 10, minute_start) <= '$date2'
		),
		LossData AS (
			SELECT
				la.line_cd,
				la.start_loss,
				la.loss_cd_id,
				la.loss_time,
				DATEADD(MINUTE, la.loss_time, la.start_loss) AS end_loss
			FROM loss_actual la
			WHERE la.line_cd = '$line_cd'
			AND la.start_loss BETWEEN '$date' AND '$date2'
		),
		ExplodedLossData AS (
			SELECT
				minute_start,
				loss_cd_id,
				CASE 
					WHEN DATEADD(MINUTE, 10, minute_start) > end_loss THEN DATEDIFF(MINUTE, minute_start, end_loss)
					ELSE 10
				END AS loss_time
			FROM
				MinuteRange mr
			JOIN
				LossData ld
			ON mr.minute_start <= ld.end_loss
			AND DATEADD(MINUTE, 10, mr.minute_start) > ld.start_loss
		),
		AccumulatedLoss AS (
			SELECT
				minute_start,
				loss_cd_id,
				SUM(loss_time) AS total_loss_time
			FROM
				ExplodedLossData
			GROUP BY
				minute_start,
				loss_cd_id
		)
		SELECT
			LEFT(CONVERT(VARCHAR, mr.minute_start, 108), 2) AS Hour,
			LEFT(CONVERT(VARCHAR, mr.minute_start, 108), 5) AS StartTime,
			ISNULL(SUM(pad.qty), 0) AS ActualBy15Min,
			STRING_AGG(al.loss_cd_id, ', ') AS LossCdIds,
			ISNULL(STRING_AGG(CAST(al.total_loss_time AS VARCHAR), ', '), 0) AS LossTime,
			ISNULL(SUM(al.total_loss_time), 0) AS LossBy15Min
		FROM
			MinuteRange mr
		LEFT JOIN
			production_actual_detail pad
			ON pad.st_time >= mr.minute_start
			AND pad.st_time < DATEADD(MINUTE, 10, mr.minute_start)
			AND pad.line_cd = '$line_cd'
			AND pad.st_time BETWEEN '$date' AND '$date2'
		LEFT JOIN
			AccumulatedLoss al
			ON al.minute_start = mr.minute_start
		GROUP BY
			mr.minute_start
		ORDER BY
			mr.minute_start
		OPTION (MAXRECURSION 0);
		
		";
		$query = $this->test_new_fa02->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}			
	}
	public function	GetDataTime(){
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"];
		$date = date('Y-m-d'); 
		$date2 = date('Y-m-d', strtotime("tomorrow"));
		$this->test_new_fa02 = $this->load->database('test_new_fa02', true);
		  $sql = "WITH HourRange AS (
			SELECT 8 AS hour_of_day
			UNION ALL
			SELECT hour_of_day + 1
			FROM HourRange
			WHERE hour_of_day + 1 <= 20
		)
		SELECT
			hr.hour_of_day,
			ISNULL(SUM(pad.qty), 0) AS ActualByHour,
			(
				SELECT 
					ISNULL(SUM(la.loss_time), 0)
				FROM
					loss_actual la
				WHERE
					la.line_cd = '$line_cd' 
					AND DATEPART(HOUR, la.start_loss) = hr.hour_of_day 
					AND la.start_loss BETWEEN '$date 08:00:00' AND '$date2 20:00:00' 
			) AS LossByHour 
		FROM
			HourRange hr
		LEFT JOIN
			production_actual_detail pad
			ON hr.hour_of_day = DATEPART(HOUR, pad.st_time)
			AND pad.line_cd = '$line_cd' 
			AND pad.st_time BETWEEN '$date 08:00:00' AND '$date2 20:00:00' 
		GROUP BY
			hr.hour_of_day
		ORDER BY
			hr.hour_of_day;
		";
		$query = $this->test_new_fa02->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}			
	}
}
?>