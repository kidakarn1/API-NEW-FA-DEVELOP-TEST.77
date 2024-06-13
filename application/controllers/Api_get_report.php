<?php
class Api_get_report extends CI_Controller
{
	public function index(){
	
	 }
	public function get_data(){
		$this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$sql = "select sys_user.emp_id , 
				sys_user.fname , 
				sys_user.lname , 
				sys_line_mst.dep_cd,
				sys_line_mst.line_cd,
				sup_work_plan_supply_dev.ITEM_CD,
				sup_work_plan_supply_dev.MODEL,
				sup_work_plan_supply_dev.CT ,
				sum(production_actual.act_qty) as total_qty
				 from sys_line_mst , 
				sup_work_plan_supply_dev ,
				production_emp_detail_realtime,
				sys_user,
				production_actual
				where 
				sup_work_plan_supply_dev.WORK_ODR_DLV_DATE BETWEEN '2022-09-01 00:00:00' and '2022-09-30 23:59:59' and
				sup_work_plan_supply_dev.LVL = '1' and
				sys_line_mst.line_cd = sup_work_plan_supply_dev.LINE_CD and 
				sup_work_plan_supply_dev.WI = production_emp_detail_realtime.wi_plan and 
				production_emp_detail_realtime.staff_cd = sys_user.emp_id  and 
				sup_work_plan_supply_dev.WI = production_actual.wi
				GROUP BY
				 sys_user.emp_id , 
				sys_user.fname , 
				sys_user.lname , 
				sys_line_mst.dep_cd,
				sys_line_mst.line_cd,
				sup_work_plan_supply_dev.ITEM_CD,
				sup_work_plan_supply_dev.MODEL,
				sup_work_plan_supply_dev.CT 
				 ORDER BY sys_line_mst.line_cd
";
		$query = $this->tbkkfa01_db->query($sql);
		$get = $query->result_array();
       echo "<table border='1'>";
       echo "<tr>";
       echo "<td>"."emp ID"."</td>";
   	   echo "<td>"."NAME"."</td>";
       echo "<td>"."LASTNAME"."</td>";
       echo "<td>"."PD"."</td>";
       echo "<td>"."LINE CD"."</td>";
       echo "<td>"."ITEM CD"."</td>";
       echo "<td>"."MODEL"."</td>";
       echo "<td>"."STD CT"."</td>";
       echo "<td>"."WORK DAY"."</td>";
       echo "<td>"."NORMAL QTY"."</td>";
       echo "<td>"."OT QTY"."</td>";
       echo "<td>"."TOTAL QTY"."</td>";
 	   echo "<td>"."NORMAL WORKING TIME ( SHIFT A )"."</td>";
       echo "<td>"."TOTAL WORKING TIME ( SHIFT A )"."</td>";
	   echo "<td>"."NORMAL WORKING TIME ( SHIFT B )"."</td>";
	   echo "<td>"."OT WORKING TIME ( SHIFT B )"."</td>";
	   echo "<td>"."TOTAL WORKING TIME ( SHIFT B )"."</td>";
       echo "</tr>";
       foreach ( $get as $key => $value ) {
       	$sql_work_day = "select   
		COUNT(format(updated_date, 'yyyy-MM-dd')) as c
			from 
				production_emp_detail_realtime
			where 
				format(updated_date, 'yyyy-MM-dd') BETWEEN '2022-09-01' and '2022-09-30' and 
				staff_cd = '{$value['emp_id']}' GROUP BY 
	format(updated_date, 'yyyy-MM-dd')
 ";
 		$query_work_day  = $this->tbkkfa01_db->query($sql_work_day);
		$get_work_day = $query_work_day->result_array();
		$i=0;
 		foreach ($get_work_day as $key2 => $value2 ) {
			$i+=1;
 		}

       echo "<tr>";
       echo "<td>".$value['emp_id']."</td>";
   	   echo "<td>".$value['fname']."</td>";
       echo "<td>".$value['lname']."</td>";
       echo "<td>".$value['dep_cd']."</td>";
       echo "<td>".$value['line_cd']."</td>";
       echo "<td>".$value['ITEM_CD']."</td>";
       echo "<td>".$value['MODEL']."</td>";
       echo "<td>".$value['CT']."</td>";
       echo "<td>".$i."</td>";
       echo "<td>".$value['emp_id']."</td>";
       echo "<td>".$value['emp_id']."</td>";
 	   echo "<td>".$value['total_qty']."</td>";
 	   echo "<td>".$value['emp_id']."</td>";
       echo "<td>".$value['emp_id']."</td>";
	   echo "<td>".$value['emp_id']."</td>";
	   echo "<td>".$value['emp_id']."</td>";
	   echo "<td>".$value['emp_id']."</td>";
       echo "</tr>";
       }
       echo "</table>";
	} 

}
?>