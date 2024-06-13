<?php
// use CodeIgniter\Database\Exceptions\DatabaseException;
class RobotApppSuport extends CI_Controller
{
	public function getRequest(){
		$this->db_sys_desk_online_dev = $this->load->database('db_sys_desk_online_dev', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$line_cd = $_GET["line_cd"];
		   $sql = "SELECT
			iir_emp_location,
			iir_title 
		FROM
			info_issue_request 
		WHERE
			iir_emp_location IS NOT NULL 
			AND iir_close_job = 0 
			AND iir_support IS NULL 
			AND iir_status = 1 
			AND iir_emp_location = '{$line_cd}'
			AND iir_support IS NULL
		ORDER BY
			iir_id DESC 
			LIMIT 1
	";
		$query = $this->db_sys_desk_online_dev->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo  "0";
		}else{
			echo json_encode($get);
		}
	}
	public function Solution(){
			$this->db_sys_desk_online = $this->load->database('db_sys_desk_online', true);
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$iir_title = $_GET["iir_title"];
		  $sql = "SELECT  * from info_job_support WHERE ijs_detail LIKE '%{$iir_title}%' AND ijs_detail NOT LIKE '%ใช้งานได้ปกติ%' LIMIT 2;";
		 $query = $this->db_sys_desk_online->query($sql);
		 $get = $query->result_array();
		 if(empty($get)){
		 	echo "0";
		 }else{
		 	echo json_encode($get);
		 }
	}
}
?>
 