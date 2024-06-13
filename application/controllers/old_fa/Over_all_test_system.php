<head>
  <meta charset="UTF-8">
</head>
<meta charset="character_set">
<?php
class Over_all_test_system extends CI_Controller
{
   
	public function TEST_SYSTEM(){
        parse_str($_SERVER['QUERY_STRING'], $_GET); 
        $this->new_fa = $this->load->database('tbkkfa01_db', true);
        $wi = $_GET["wi"];
        $sql = "select * from tag_print_detail  as tpd left join log_reprint_app lrp on tpd.id = lrp.log_ref_id and tpd.id = lrp.log_ref_id and  lrp.log_ref_db = '2' where  tpd.wi = '$wi'";
		$res = $this->new_fa->query($sql);
		$row = $res->result_array();
		echo json_encode($row);
		// print_r($row);
	}
	public function test_encode(){
		require_once("NoongHelper.php");
		$str = "กิดาการ อินทปัญญา|2022-08-20|2023-08-20|6|OPN:13/CAR:14";
		$hello = new NoongHelper($str);
    	echo $hello->EncryptNN($str);
	}
}