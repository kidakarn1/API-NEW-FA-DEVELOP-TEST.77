<?php
class TESTAPITRANFER extends CI_Controller
{
	  public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('AutoTransfer_model', 'transfer');
    }
	public function GETLOT_TBKKFATHAILAND($lot_dt)
  {
   $G_WI = "";
   $_YEARS = array ('J', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
   $_MONTH = array ('L', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
   $D = date('d',strtotime($lot_dt));
   $M = date('m',strtotime($lot_dt));
   $Y = date('y',strtotime($lot_dt));
   //echo $_YEARS[($Y % 10)].$_MONTH[($M % 12)].$D; exit();
   return $_YEARS[($Y % 10)].$_MONTH[($M % 12)].$D;
  }
 public function Get_detail_act(){
			date_default_timezone_set('Asia/bangkok');
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			// $lineCd = $_GET["line_cd"]; 
			// $dateNow = date('Y-m-d');
			// $tmpDateNow = date('Y-m-d');
			// $updatDate = date('Y-m-d H:i:s');
			// $timeNow = "02:00:00"; //date('H:i:s');
			// $delDate = date("Y-m-d",strtotime("-1 days",strtotime($dateNow)));
			//  $addDate = date("Y-m-d",strtotime("+1 days",strtotime($dateNow)));
			//  if ($timeNow>="08:00:00" and $timeNow<="20:00:00"){
			//  	$dateNow = $delDate." 08:00:00";
			//  	$addDate = $tmpDateNow." 20:00:00";
			//  }else{
			// 	 if ($timeNow>="00:00:00" and $timeNow<="07:59:59"){
			// 	 	$dateNow = date("Y-m-d",strtotime("-1 days",strtotime($dateNow)))." 20:00:00";
			// 	 }else{
			//  		$dateNow = strval($dateNow)." 20:00:00";
			// 	 }
			//  	$addDate = strval($addDate)." 08:00:00";
			//  }
			// $this->TBK_FA01 = $this->load->database('test_new_fa02', true);
			// $sqlGetDetail = "EXEC [dbo].[TRANFER_DATA_DETAILS_ACTUAL] @dateNow = '{$dateNow}' , @addDate = '{$addDate}' , @lineCd='{$lineCd}'";
 		// 	$queryGetDetail = $this->TBK_FA01->query($sqlGetDetail);
			// $rsGetDetail = $queryGetDetail->result_array();
	 	// 	foreach ($rsGetDetail as $key => $value) {
	 	// 		if(is_null($value["PRD_ACT_QTY"]) And !empty($value["PLAN_QTY"])){
	 	// 			$this->insertProductionActual(
	 	// 			 $value["WI_PLAN"] ,
	 	// 			 $value["LINE_CD"] ,
	 	// 			 $value["ITEM_CD"] ,
	 	// 			 $value["PLAN_QTY"],
			// 		 $value["ACT_QTY_DETAILS"],
			// 		 $value["SEQ_NO"],
			// 		 $this->getShift($value["ST_TIME"]),
			// 		 $value["MANPOWER"],
			// 		 $value["ST_DATETIME"],
			// 		 $value["ST_TIME"],
			// 		 $value["END_DATETIME"],
			// 		 $value["END_TIME"],
			// 		 $this->getLotNo($value["ST_TIME"] , $value["ST_DATE"]),
			// 		 $value["FLG_COMPLETED"],
			// 		 "1",
			// 		 "0",
			// 		 "2"
	 	// 			);
	 	// 			if ($value["FLG_COMPLETED"] == "1"){
	 	// 				//echo "1234";
	 	// 				$this->updatedPlan($value["WI_PLAN"]);
	 	// 			}
	 	// 		}
	 	// 	}

  		$line_cd = $this->input->get('line_cd');
		// $line_cd = $_GET('line_cd');
        $result = $this->transfer->transferProduction($line_cd);
        echo json_encode($result);
		}
		public function UpdateFlgZero(){
			// $line_cd = $this->input->get('line_cd');
			date_default_timezone_set('Asia/bangkok');
			$line_cd =$_GET["line_cd"];
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			$this->transfer->GetPlan($line_cd);
		}

		public function getLotNo($sTime , $prdDate){
			if ($sTime >= "00:00:00" and  $sTime <= "07:59:59" ){
			    $sTime = date('H:i:s',strtotime($sTime));
			 	$dateLotNo = date("Y-m-d",strtotime("-1 days",strtotime($sTime)));
			 	$lotNo = $this->GETLOT_TBKKFATHAILAND($prdDate);
			}else{
				$sTime = date('H:i:s',strtotime($sTime));
		 	  	$dateLotNo = $sTime;
			 	$lotNo = $this->GETLOT_TBKKFATHAILAND($dateLotNo);
			}	
			return $lotNo;
		}
		public function getShift($newDateTime){
	 		if($newDateTime >= "08:00:00" and  $newDateTime <= "20:00:00"){
				$shift = "P";
			}else if($newDateTime >= "20:00:00" and  $newDateTime <= "23:59:59" ){
			 	$shift = "Q";
			}else if($newDateTime >= "00:00:00" and  $newDateTime <= "07:59:59" ){
				$shift = "Q";
		 	}
		 	return $shift;
		}
		public function getLot() {
       		echo json_encode($this->transfer->getProductionLot(date('Y-m-d H:i:s')));
    	}
	public function insertProductionActual($WI_PLAN,$LINE_CD,$ITEM_CD,$PLAN_QTY,$ACT_QTY,$SEQ_NO,$SHIFT,$MANPOWER,$ST_DATETIME,$ST_TIME,$END_DATETIME,$END_TIME,$LotNo,$FLG_COMPLETED,$FLG_TRANFER,$DEL_FLG,$CLOSE_LOT_FLG){
				if($ACT_QTY < 0){
					$ACT_QTY = "0";
				}
			   $sqlInsert = "INSERT into production_actual
			 		 (wi ,		
			 		 line_cd ,
			 		 item_cd , 
			 		 plan_qty , 
			 		 act_qty ,
			 		 seq_no ,  
			 		 shift_prd , 
			 		 manpower_no , 
			 		 prd_st_date , 
			 		 prd_st_time , 
			 		 prd_end_date , 
			 		 prd_end_time , 
			 		 lot_no ,
			 		 comp_flg ,
			 		 transfer_flg , 
			 		 del_flg,
			 		 updated_date,
			 		 close_lot_flg  )
			 		 values(
			 		   '{$WI_PLAN}',
			 		   '{$LINE_CD}',
			 		   '{$ITEM_CD}',
			 		   '{$PLAN_QTY}',
			 		   '{$ACT_QTY}',
			 		   '{$SEQ_NO}',
			 		   '{$SHIFT}',
			 		   '{$MANPOWER}',
			 		   '{$ST_DATETIME}',
			 		   '{$ST_TIME}',
			 		   '{$END_DATETIME}',
			 		   '{$END_TIME}',
			 		   '{$LotNo}',
			 		   '{$FLG_COMPLETED}',
			 		   '1',
			 		   '0',
			 		   CURRENT_TIMESTAMP,
			 		   '2'
			 		)";
					$queryInsertProduction = $this->TBK_FA01->query($sqlInsert);
					if($queryInsertProduction){
						echo "true";
						//return true ; 	
					}else{
						echo "false";
						//return false ; 
					}
	}
	public function updatedPlan($Wi){
		$sqlUpdate = "Update sup_work_plan_supply_dev set PRD_COMP_FLG = '9' where WI = '{$Wi}'";
		$queryInsertProduction = $this->TBK_FA01->query($sqlUpdate);
		if($queryInsertProduction){
			return "true";
			//return true ; 
		}else{
			return "false";
			//return false ; 
		}
	}
}
?>