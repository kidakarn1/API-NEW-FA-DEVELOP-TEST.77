<?php
class Api_Get_plan_production extends CI_Controller
{

	public function __construct() {
		parent::__construct();

		$this->test_new_fa02 = $this->load->database('tbkkfa01_db', true);
	}

	public function index(){
		$this->test_new_fa02 = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"];
		$date_today_ins = date('Y-m-d');
	 // 	   --ISNULL(production_actual.seq_no, 0) AS seq_no,
  //  		   -- (select SUM(abs(qty)) from production_defect_detail where flg_defact = '1' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NC,
  //       --    (select SUM(abs(qty)) from production_defect_detail where flg_defact = '2' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NG";
		if ($this->checkLineType($line_cd) == 2) {
			try {
				$plan = $this->getPlan($line_cd);
				 
				if (empty($plan)) {
					throw new Exception("Today plan isn't found.", 1);
				}

				$planDate = $plan[0]["plan_date"];
				$qty = $plan[0]["QTY"];
				$prd_qty = $plan[0]["prd_qty_sum"];
				
				$partNumber = [];
				$result = [];

				foreach ($plan as $key => $value) {
				
					if (!in_array($value["ITEM_CD"], $partNumber)) {
						if ($planDate == $value["plan_date"] && $qty == $value["QTY"] && $prd_qty == $value["prd_qty_sum"]) {
							
							$partNumber[] = $value["ITEM_CD"];
							$result[] = $value;
						}
					}
				}
				// if (count($partNumber) != 5) {
				// 	throw new Exception("There must be at least 5 plans", 1);
				// }

				usort($result, function($a, $b) {
					return $a['ITEM_CD'] <=> $b['ITEM_CD'];
				});

				echo json_encode($result);
			} catch (\Throwable $th) {
				echo " ";
			}
			
		} else {

			$get = $this->getPlan($line_cd, 'TOP 1');
		// 	$SQL= "SELECT top 1 * ,
		// 	sup_work_plan_supply_dev.IND_ROW as IND_ROW,
		// 	  ISNULL(pa.prd_qty, 0) AS prd_qty_sum ,
		// 	  sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
		// 	   ISNULL(ppap.seq_no, 0) AS seq_no,
		// 	  (select SUM(abs(qty)) from production_defect_detail where flg_defact = '1' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NC,
		//   (select SUM(abs(qty)) from production_defect_detail where flg_defact = '2' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NG
		// 			FROM 
		// 				sup_work_plan_supply_dev,
		// 				control_prod_plan as cp
		// 					 LEFT JOIN (
		// 						SELECT
		// 							wi_plan,
		// 							SUM (qty) AS prd_qty
		// 						FROM
		// 							production_actual_detail
		// 						WHERE
		// 							line_cd = '$line_cd'
		// 						AND updated_date > DATEADD(MONTH, - 1, GETDATE())
		// 						GROUP BY
		// 							wi_plan
		// 					) AS pa ON cp.WI = pa.wi_plan
		// 					LEFT JOIN production_actual AS ppap ON cp.WI = ppap.WI
		// 			 where  
		// 				cp.id_plan = sup_work_plan_supply_dev.IND_ROW and 
		// 				cp.line_cd = '$line_cd' and 
		// 				cp.prod_flg = '2' and
		// 				cp.status_flg = '0' and 
		// 				sup_work_plan_supply_dev.PRD_COMP_FLG <> '9'
		// 				order by cp.order_flg asc
		// 				";
		// 	$query = $this->test_new_fa02->query($SQL);
		// 	$get = $query->result_array();
			if (empty($get)){
				echo " ";
			}else{
				echo json_encode($get);
			}
		}
		
	}

	public function checkLineType($line_cd) {
		return $this->test_new_fa02->query("select tag_type FROM sys_line_mst WHERE line_cd = ?  and enable = 1 ", $line_cd)->row('tag_type');
	}

	public function getPlan($line_cd, $option = '') {
		$sql = "SELECT $option * ,
					sup_work_plan_supply_dev.IND_ROW AS IND_ROW,
					ISNULL( pa.prd_qty, 0 ) AS prd_qty_sum,
					sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
					ISNULL( ppap.seq_no, 0 ) AS seq_no,
					ISNULL( sup_work_plan_supply_dev.PKG_UNIT_QTY, sup_work_plan_supply_dev.PS_UNIT_NUMERATOR  ) AS PS_UNIT_NUMERATOR ,
					(
					SELECT SUM
						( abs( qty ) ) 
					FROM
						production_defect_detail 
					WHERE
						flg_defact = '1' 
						AND wi_plan = sup_work_plan_supply_dev.WI 
						AND line_cd = '$line_cd' 
					) AS QTY_NC,
					(
					SELECT SUM
						( abs( qty ) ) 
					FROM
						production_defect_detail 
					WHERE
						flg_defact = '2' 
						AND wi_plan = sup_work_plan_supply_dev.WI 
						AND line_cd = '$line_cd' 
					) AS QTY_NG,
					slm.tag_type
				FROM
					sup_work_plan_supply_dev,
					sys_line_mst AS slm,
					control_prod_plan AS cp
					LEFT JOIN (
					SELECT
						wi_plan,
						SUM ( qty ) AS prd_qty 
					FROM
						production_actual_detail 
					WHERE
						line_cd = '$line_cd' 
						AND updated_date > DATEADD( MONTH, - 1, GETDATE( ) ) 
					GROUP BY
						wi_plan 
					) AS pa ON cp.WI = pa.wi_plan
					LEFT JOIN production_actual AS ppap ON cp.WI = ppap.WI
				WHERE
					cp.id_plan = sup_work_plan_supply_dev.IND_ROW 
					AND slm.line_cd = '$line_cd'
					AND slm.line_cd = sup_work_plan_supply_dev.LINE_CD
					AND slm.enable = 1
					AND cp.line_cd = '$line_cd' 
					AND cp.prod_flg = '2' 
					AND cp.status_flg = '0' 
					AND sup_work_plan_supply_dev.PRD_COMP_FLG <> '9' 
				ORDER BY
					cp.order_flg ";

		$query = $this->test_new_fa02->query($sql);
		$get = $query->result_array();
		return $get;
	}
}
?>