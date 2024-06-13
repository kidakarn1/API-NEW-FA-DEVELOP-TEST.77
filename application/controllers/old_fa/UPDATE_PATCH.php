<?php
class UPDATE_PATCH extends CI_Controller
{
	public function check_version_result(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$VERSION_NAME = $_GET["VERSION_NAME"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql  = "select * from sys_version_control where version_name = '$VERSION_NAME' and version_enable = '1'";
		$query = $this->TBK_FA01->query($sql);
		$row = $query->result_array();
		if (empty($row)){
			echo "0";
		}else{
			echo "1";
		}		
	}
	public function F_UPDATE_PATCH(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$VERSION_NAME = $_GET["VERSION_NAME"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql  = "select * from sys_version_control where version_name = '$VERSION_NAME' and version_enable = '1'";
		$query = $this->TBK_FA01->query($sql);
		$row = $query->result_array();
		if (empty($row)){
			echo "0";
		}else{
			echo json_encode($row);
		}
	}

	public function GET_VERSION(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql  = "select * from sys_version_control where  version_enable = '1'";
		$query = $this->TBK_FA01->query($sql);
		$row = $query->result_array();
		if (empty($row)){
			echo "0";
		}else{
			echo json_encode($row);
		}
	}
	public function Insert_sys_log_program_version(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$version_id = $_GET["version_id"];
		$line_cd = $_GET["line_cd"];
		$status_flg = $_GET["status_flg"];
		$remark = $_GET["remark"];
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$line_notify  = "0";
		if ($status_flg == "0"){
			$line_notify = "1";
		}else{
			$line_notify = "0";
		}
		$sql = "INSERT into sys_log_program_version (
				version_id , 
				line_id, 
				status_flg , 
				created_date , 
				created_by , 
				updated_date , 
				updated_by , 
				notice_flg , 
				remark
				) values(
					'$version_id',
					'$line_cd',
					'$status_flg',
					CURRENT_TIMESTAMP,
					'SYSTEM',
					CURRENT_TIMESTAMP,
					'SYSTEM',
					'$line_notify',
					'$remark'
				)";
				$query = $this->TBK_FA01->query($sql);
				if ($status_flg == "0"){
					$this->Alert_notify_faill($version_id , $line_cd , $remark);
				}
				if ($query){
					echo "1";
				}else{
					echo "0";
				}
	} 
	public function Alert_notify_faill($version_id , $line_cd , $remark){
			define('LINE_API',"https://notify-api.line.me/api/notify");   
			    parse_str($_SERVER['QUERY_STRING'], $_GET); 
				$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
				$sql  = "select * from sys_version_control where  version_enable = '1'";
				$query = $this->TBK_FA01->query($sql);
				$row = $query->result_array();
				$VERSION_NAME = "-";
				foreach ($row as $key => $value) {
					$VERSION_NAME = $value["version_name"];
				}
			     $tokensabori =  $this->GET_TOKEN_LINE();
				 $str .= "\n"."Update Patch New FA failed ";
				 $result_version_name = $this->GET_VERSION();
				 $str .= "\n"."Version : ".$VERSION_NAME;
				 $str .= "\n"."PD : ". $this->GET_PD($line_cd);;
				 $str .= "\n"."Line Prod : ". $line_cd;
				 $str .= "\n"."Because : ".$remark;
			//	$str .= "\n"."Cr. Prasan.";  
				$stickerPkg = 6136; //stickerPackageId
				$stickerId = 10551379; //stickerId	

		 $this->notify_message($str,$stickerPkg,$stickerId,$tokensabori);
	}
	public function GET_PD($line_cd){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select * from sys_line_mst where line_cd = '$line_cd'";
		$query = $this->TBK_FA01->query($sql);
		$get_detail = $query->result_array();
		foreach ($get_detail as $key => $value) {
			$dep_cd = $value["dep_cd"];
		}
		return $dep_cd;
	}
	public function GET_TOKEN_LINE(){
		$sql = "select * from  sys_linenotify_group where group_name = 'PCS NOTIFY' and enable = '1' and del_flg = '0'";
		$query = $this->TBK_FA01->query($sql);
		$get_detail = $query->result_array();
		foreach ($get_detail as $key => $value) {
			$token_name = $value["token_name"];
		}
		return $token_name;
	}
	public function notify_message($message,$stickerPkg,$stickerId,$token)
	{
	     $queryData = array(
	      'message' => $message,
	      'stickerPackageId'=>$stickerPkg,
	      'stickerId'=>$stickerId
	     );
	     $queryData = http_build_query($queryData,'','&');
	     $headerOptions = array(
	         'http'=>array(
	             'method'=>'POST',
	             'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
	                 	   ."Authorization: Bearer ".$token."\r\n"
	                       ."Content-Length: ".strlen($queryData)."\r\n",
	             'content' => $queryData
	         ),
	     );
	     $context = stream_context_create($headerOptions);
	     $result = file_get_contents(LINE_API,FALSE,$context);
	     $res = json_decode($result);
	  return $res;

	 }
	 public function GET_VERSION_NEW_FA_BY_LINE(){
	 	$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
	 	$line_id = $_GET["line_id"];
	 	$sql  = "select top 1 sys_version_control.version_name as version_name from sys_log_program_version ,sys_version_control  where 
	 	sys_log_program_version.line_id = '$line_id' 
	 	and sys_log_program_version.version_id = sys_version_control.version_id 
	 	and sys_log_program_version.status_flg = '1' order by sys_log_program_version.log_id desc
	 	";
	 	$query = $this->TBK_FA01->query($sql);
		$get_detail = $query->result_array();
		$version_name = "0";
		foreach ($get_detail as $key => $value) {
			$version_name = $value["version_name"];
		}
		echo $version_name;
	 }

}
?>