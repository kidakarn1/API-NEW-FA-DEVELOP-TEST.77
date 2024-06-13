<?php
class Api_Get_plan_production_test_system extends CI_Controller
{
	public function index(){
		// $this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		$this->test_new_fa02 = $this->load->database('test_new_fa02', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"];
		$date_today_ins = date('Y-m-d');
		  $SQL= "SELECT top 1 * ,
		  ISNULL(pa.prd_qty, 0) AS prd_qty_sum ,
		  sup_work_plan_supply_dev.WORK_ODR_DLV_DATE AS ORIGINAL_PLAN,
	 	  ISNULL(ppap.seq_no, 0) AS seq_no,
    	  (select SUM(abs(qty)) from production_defect_detail , sup_work_plan_supply_dev where flg_defact = '1' and wi_plan = sup_work_plan_supply_dev.WI and sup_work_plan_supply_dev.line_cd = '$line_cd') as QTY_NC,
      	(select SUM(abs(qty)) from production_defect_detail , sup_work_plan_supply_dev where flg_defact = '2' and wi_plan = sup_work_plan_supply_dev.WI and sup_work_plan_supply_dev.line_cd = '$line_cd') as QTY_NG
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
                                line_cd = '$line_cd'
                            AND updated_date > DATEADD(MONTH, - 1, GETDATE())
                            GROUP BY
                                wi_plan
                        ) AS pa ON cp.WI = pa.wi_plan
                        LEFT JOIN production_actual AS ppap ON cp.WI = ppap.WI
		 		where  
					cp.id_plan = sup_work_plan_supply_dev.IND_ROW and 
					cp.line_cd = '$line_cd' and 
					cp.prod_flg = '2' and
					cp.status_flg = '0' and 
					sup_work_plan_supply_dev.PRD_COMP_FLG <> '9'
					order by cp.order_flg desc
					";
		$query = $this->test_new_fa02->query($SQL);
		$get = $query->result_array();
		if (empty($get)){
			echo " ";
		}else{
			echo json_encode($get);
		}
	}
}
?>