<?php
class ApiCheckQTY extends CI_Controller
{
	public function index(){
	
	 }
	public function CheckWorking(){
		$this->tbkkfa01_db = $this->load->database('tbkkfa01_db', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$item_cd = $_GET["item_cd"];
		echo $sql = "SELECT
					* 
				FROM
					sup_work_plan_supply_dev 
				WHERE
					LVL = '1' 
					AND PRD_COMP_FLG = '1'
					AND ITEM_CD = '{$item_cd}'";
		$query = $this->tbkkfa01_db->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo  "0";
		}else{
			echo "NOT WORKING PART NO ".$item_cd;
		}
	}
}
?>