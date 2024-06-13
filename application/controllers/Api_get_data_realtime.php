<?php

// require_once('Api_exp_get_cal_mst.php');
class Api_get_data_realtime extends CI_Controller
{
	// var $ins;

public function getDataOeeRealtime ()
	{
	$dataActualOee = $this->getActualOeeRealtime();
	echo json_encode($recFa);
	// return $recFa;
}
public function getActualOeeRealtime () 
{
	$this->new_fa = $this->load->database('tbkkfa01_db', true);
	$sqlFa = " SELECT DEP_CD, LINE_CD FROM SYS_LINE_MST WHERE CHK_SYS_FLG ='1' AND ENABLE = '1' ORDER BY DEP_CD, LINE_CD ASC ";
	$excFa = $this->new_fa->query( $sqlFa );
	$recFa = $excFa->result_array();

	return $recFa;
}

}
?>