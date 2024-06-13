<?php
class Api_Get_plan_production_critical extends CI_Controller
{
	public function index(){
		// $this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		$this->test_new_fa02 = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"];
		$date_today_ins = date('Y-m-d');
 
		//   $SQL= "SELECT * ,
		// sup_work_plan_supply_dev.IND_ROW as IND_ROW,
		//   ISNULL(pa.prd_qty, 0) AS prd_qty_sum ,
		//   sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
	 // 	  ISNULL(ppap.seq_no, 0) AS seq_no,
  //   	  (select SUM(abs(qty)) from production_defect_detail where flg_defact = '1' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NC,
  //     (select SUM(abs(qty)) from production_defect_detail where flg_defact = '2' and wi_plan = sup_work_plan_supply_dev.WI and line_cd = '$line_cd') as QTY_NG
		// 		FROM
		// 			sup_work_plan_supply_dev,
		// 			control_prod_plan as cp
  //    					LEFT JOIN (
  //                           SELECT
  //                               wi_plan,
  //                               SUM (qty) AS prd_qty
  //                           FROM
  //                               production_actual_detail
  //                           WHERE
  //                               line_cd = '$line_cd'
  //                           AND updated_date > DATEADD(MONTH, - 1, GETDATE())
  //                           GROUP BY
  //                               wi_plan
  //                       ) AS pa ON cp.WI = pa.wi_plan
  //                       LEFT JOIN production_actual AS ppap ON cp.WI = ppap.WI
		//  		where  
		// 			cp.id_plan = sup_work_plan_supply_dev.IND_ROW and 
		// 			cp.line_cd = '$line_cd' and 
		// 			cp.prod_flg = '2' and
		// 			cp.status_flg = '0' and 
		// 			sup_work_plan_supply_dev.PRD_COMP_FLG <> '9'
		// 			order by cp.order_flg asc
		// 			";

							  $SQL= "  SELECT
	sup_work_plan_supply_dev.WI , 
	* ,
	sup_work_plan_supply_dev.POSITION1 AS SPOSITION1,
	sup_work_plan_supply_dev.POSITION2 AS SPOSITION2,
	sup_work_plan_supply_dev.IND_ROW AS IND_ROW,
	ISNULL( pa.prd_qty, 0 ) AS prd_qty_sum,
	sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
		ISNULL( sup_work_plan_supply_dev.PKG_UNIT_QTY, sup_work_plan_supply_dev.PS_UNIT_NUMERATOR  ) AS PS_UNIT_NUMERATOR,
	ISNULL( ppap.seq_no, 0 ) AS seq_no,
	( SELECT SUM ( abs( qty ) ) FROM production_defect_detail WHERE flg_defact = '1' AND wi_plan = sup_work_plan_supply_dev.WI AND line_cd = '$line_cd' ) AS QTY_NC,
	( SELECT SUM ( abs( qty ) ) FROM production_defect_detail WHERE flg_defact = '2' AND wi_plan = sup_work_plan_supply_dev.WI AND line_cd = '$line_cd' ) AS QTY_NG 
FROM
	sup_work_plan_supply_dev,
	control_prod_plan AS cp
	LEFT JOIN (
	SELECT
		wi_plan,
		SUM ( qty ) AS prd_qty 
	FROM
		production_actual_detail 
	WHERE
		line_cd = '$line_cd' 
		AND updated_date > DATEADD( MONTH, - 1, GETDATE()) 
	GROUP BY
		wi_plan 
	) AS pa ON cp.WI = pa.wi_plan
	LEFT JOIN (Select top 1  * from production_actual where production_actual.wi =  '')AS ppap ON cp.WI = ppap.wi 
WHERE
	cp.id_plan = sup_work_plan_supply_dev.IND_ROW 
	AND cp.line_cd = '$line_cd' 
	AND cp.prod_flg = '2' 
	AND cp.status_flg = '0' 
	AND sup_work_plan_supply_dev.PRD_COMP_FLG <> '9' 
ORDER BY
	cp.order_flg ASC";
		$query = $this->test_new_fa02->query($SQL);
		$get = $query->result_array();
		if (empty($get)){
			echo " ";
		}else{ 
			echo json_encode($get);
		}
	}
	public function GetDataPlanCritical(){
		$this->test_new_fa02 = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$wi = $_GET["wi"];
		$line_cd = $_GET["line_cd"];
		// $sql="
		// 	SELECT * From control_prod_plan , sup_work_plan_supply_dev  where control_prod_plan.wi = '{$wi}' And control_prod_plan.id_plan = sup_work_plan_supply_dev.IND_ROW";
		  $sql= "SELECT top 1 * ,
		  	ISNULL(sup_work_plan_supply_dev.POSITION1 , '0' )  AS SPOSITION1,
		  	ISNULL(sup_work_plan_supply_dev.POSITION2 , '0' )  AS SPOSITION2,
		sup_work_plan_supply_dev.IND_ROW as IND_ROW,
		  ISNULL(pa.prd_qty, 0) AS prd_qty_sum ,
		  sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
		  	ISNULL( sup_work_plan_supply_dev.PKG_UNIT_QTY, sup_work_plan_supply_dev.PS_UNIT_NUMERATOR  ) AS PS_UNIT_NUMERATOR,
	 	  ISNULL(ppap.seq_no, 0) AS seq_no,
    	  (select SUM(abs(qty)) from production_defect_detail where flg_defact = '1' and wi_plan = sup_work_plan_supply_dev.WI and wi_plan = '$wi') as QTY_NC,
      (select SUM(abs(qty)) from production_defect_detail where flg_defact = '2' and wi_plan = sup_work_plan_supply_dev.WI and wi_plan = '$wi') as QTY_NG
				FROM
					sup_work_plan_supply_dev,
					control_prod_plan as cp
     					LEFT JOIN (
                            SELECT
                                wi_plan,
                                SUM (qty) AS prd_qty
                            FROM
                                production_actual_detail
                            WHERE
                                wi_plan = '$wi'
                            AND updated_date > DATEADD(MONTH, - 1, GETDATE())
                            GROUP BY
                                wi_plan
                        ) AS pa ON cp.WI = pa.wi_plan
                        LEFT JOIN production_actual AS ppap ON cp.WI = ppap.WI
		 		where  
					cp.id_plan = sup_work_plan_supply_dev.IND_ROW and 
					cp.WI = '{$wi}' and 
					cp.line_cd = '{$line_cd}' and 
					cp.prod_flg = '2' and
					cp.status_flg = '0' and 
					sup_work_plan_supply_dev.PRD_COMP_FLG <> '9'
					order by cp.order_flg asc
					";
		$query = $this->test_new_fa02->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo " ";
		}else{
			echo json_encode($get);
		}
	}
}
?>