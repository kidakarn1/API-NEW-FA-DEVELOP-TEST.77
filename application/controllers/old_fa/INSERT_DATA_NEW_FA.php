<?php
class INSERT_DATA_NEW_FA extends CI_Controller
{
	public function check_line($line_cd){
		$sql = "select * from mst_equip_ctrl where me_line_cd = '$line_cd'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			return "0";
		}else{
			return "1";
		}
	}
	public function INSERT_COTROL_MASTER(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		 $line_cd = $_GET["line_cd"];
		 $ComboBox_master_device = $_GET["ComboBox_master_device"];
 		 $device_dio_port_id = $_GET["device_dio_port_id"];
 		 $printer = $_GET["printer"];
 		 $typ_counter = $_GET["typ_counter"];
 		 $cavity = $_GET["cavity"];
 		 $total_delay = $_GET["total_delay"];
 		 $scanner = $_GET["scanner"];
 		  $mecg_id = $this->Get_ID_table("mecg_id" , "mst_equip_count_grp" , "mecg_name = '$ComboBox_master_device'");
 		  $mec_id = $this->Get_ID_table("mec_id" , "mst_equip_count" , "mec_name='$device_dio_port_id'");
 		  $mep_id = $this->Get_ID_table("mep_id" , "mst_equip_printer" , "mep_name='$printer'");
 		 $mes_id = $this->Get_ID_table("mes_id" , "mst_equip_scanner" , "mes_name='$scanner'");
		$mect_id = $this->Get_ID_table("mect_id" , "mst_equip_count_typ" , "mect_name='$typ_counter'");
 		 $me_cnt_typ = "0";

 		 if ($cavity <= "1"){
 		 	$me_cnt_typ = "1";
 		 }else{
 		 	$me_cnt_typ = "2";
 		 }
		if($this->check_line($line_cd) == "0"){
			   $sql  = "INSERT into mst_equip_ctrl(
						me_line_cd,
						mec_id,
						mect_id,
						mes_id,
						mep_id,
						me_cnt_typ,
						me_cnt_qty,
						me_sig_del,
						me_created_date,
						me_created_by ,
						me_updated_date,
						me_updated_by
						) values(
						'$line_cd',
						'$mec_id',
						'$mect_id',
						'$mes_id',
						'$mep_id',
						'$me_cnt_typ',
						'$cavity',
						'$total_delay',
						CURRENT_TIMESTAMP,
						'SYSTEM',
						CURRENT_TIMESTAMP,
						'SYSTEM'
						) ";
		}else{
			 	 $sql = "UPDATE mst_equip_ctrl set
				 		mec_id = '$mec_id',
				 		mect_id = '$mect_id',
				 		mes_id = '$mes_id',
				 		mep_id = '$mep_id',
				 		me_cnt_typ = '$me_cnt_typ',
				 		me_cnt_qty = '$cavity',
				 		me_updated_date = CURRENT_TIMESTAMP,
				 		me_updated_by = 'SYSTEM',
				 		me_sig_del = '$total_delay'
				 		where me_line_cd = '$line_cd'
				 ";
		}

					$query = $this->TBK_FA01->query($sql);
					if($query){
						echo "1";
					}else{
						echo "0";
					}
				
			}
	public function test(){
       echo  $this->Get_ID_table("mes_id" , "mst_equip_scanner" , "mes_name='USB'");
	}
	public function Get_ID_table($attr , $table , $condition ){
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select $attr from $table where $condition";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			return  "0";
		}else{
			return $get["0"][$attr];
		}
	}
}
?>