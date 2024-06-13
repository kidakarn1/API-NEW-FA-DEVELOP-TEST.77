<?php

// require_once('Api_exp_get_cal_mst.php');
class Api_get_prod_plan_realtime extends CI_Controller
{
	// var $ins;

	public function manage_prod_plan ()
	{
		$pd_time = $this->get_plan_date();
		$pd_time = str_replace( "/" , "-" , $pd_time );
		$pd_time = $pd_time." 00:00:00";
		$today = date('Y-m-d');
		$tomorrow = date('Y-m-d' , strtotime("tomorrow"));
		$yesterday = date('Y-m-d', strtotime("yesterday"));
		$st_cur_lot = $today." 07:30:00"; // Time follow task update plan.
		$en_cur_lot = $tomorrow." 07:29:59"; // Time follow task update plan.
		$chk_lot_time = date('Y-m-d H:i:s');
		if( $chk_lot_time >= $st_cur_lot && $chk_lot_time <= $en_cur_lot )
		{
			$st_time = $today." 00:00:00";
			$bt_time = $tomorrow." 00:00:00";
		}
		else
		{
			$st_time = $yesterday." 00:00:00";
			$bt_time = $today." 00:00:00";
		}
		// var_dump($st_cur_lot);
		// var_dump($en_cur_lot);
		// var_dump($chk_lot_time); 
		// var_dump($st_time);
		// var_dump($pd_time);
		// var_dump($bt_time);
		// exit;

		$line_mst = $this->chk_new_fa_line ();

		foreach ( $line_mst as $key => $value ) 
		{
			// var_dump($value)."\n";
			$chk_new_plan = $this->chk_new_prod_plan( $value['LINE_CD'] , $st_time , $pd_time );
			// var_dump($chk_new_plan); exit;

			foreach ( $chk_new_plan as $key2 => $value2 ) 
			{
				$chk_dup_plan = $this->compare_prod_plan( $value['LINE_CD'] , $value2['WI'] );
				// echo $chk_dup_plan;

				if( $chk_dup_plan == 0 )
				{
					if( $st_time == $value2['PLAN_DATE'] )
					{
						$type = 2;
					}
					elseif( $bt_time == $value2['PLAN_DATE'] )
					{
						$type = 3;
					}
					else
					{
						$type = 4;
					}

					$seq_plan = $this->chk_max_seq ( $value2['LINE_CD'] , $type );
					// var_dump($max_seq);

					// if( !isset($max_seq) )
					// {
					// 	$seq_plan = (int)$max_seq + 1;
					// }
					// else
					// {
					// 	$seq_plan = 1;
					// }

					// echo $seq_plan;

					$this->ins_prod_plan( $value2['IND_ROW'] , $value2['LINE_CD'] , $value2['WI'] , $value2['PLAN_DATE'] , $type , $seq_plan );
				}
			}
			// exit;
		}
	}
 
	public function chk_new_fa_line ()  //CHECK NEW FA LINE
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT DEP_CD, LINE_CD FROM SYS_LINE_MST WHERE CHK_SYS_FLG ='1' AND ENABLE = '1' ORDER BY DEP_CD, LINE_CD ASC ";
		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		return $recFa;
	}

	public function ins_prod_plan ( $id_plan , $line_cd , $wi_no , $plan_date , $type , $seq_plan )  //INSERT NEW PRODUCTION PLAN
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlIns = " INSERT INTO CONTROL_PROD_PLAN( ID_PLAN , LINE_CD , WI , PROD_FLG , ORDER_FLG , STATUS_FLG , PLAN_DATE , CREATE_DATE , CREATE_BY , UPDATE_DATE , UPDATE_BY ) VALUES ( '$id_plan' , '$line_cd' , '$wi_no' , '$type' , '$seq_plan' , '0' , '$plan_date' , GETDATE() , 'SYSTEM' , GETDATE() , 'SYSTEM' );";

		// var_dump($sqlIns); exit;

		$excIns = $this->new_fa->query( $sqlIns );
	}

	public function compare_prod_plan ( $line_cd , $wi_no )  //CHECK NEW FA LINE
	{
		$chk_dup_plan = $this->chk_cur_prod_plan( $line_cd , $wi_no );

		// var_dump($chk_dup_plan); exit;
		if( !empty ($chk_dup_plan) )
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function chk_new_prod_plan ( $line_cd , $st_time , $pd_time )  //CHECK NEW PRODUCTION PLAN
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT
						SW.IND_ROW AS IND_ROW,
						SW.LINE_CD AS LINE_CD,
						SW.WI AS WI,
						SW.WORK_ODR_DLV_DATE AS PLAN_DATE
					FROM
					( SELECT
							IND_ROW,
							LINE_CD,
							WI,
							WORK_ODR_DLV_DATE,
							PRD_COMP_FLG
						FROM
							SUP_WORK_PLAN_SUPPLY_DEV
						WHERE
							LINE_CD = '$line_cd' --Line Code
							AND ( LVL = '1' AND LVL IS NOT NULL )
							AND PRD_COMP_FLG = '0'
							AND WORK_ODR_DLV_DATE BETWEEN '$st_time' AND '$pd_time' ) SW
							LEFT OUTER JOIN
						( SELECT
								A.WI AS WI_NO
							FROM
								( SELECT
									WI AS WI,
									ROW_NUMBER() OVER (PARTITION BY WI ORDER BY LOT_NO, SEQ_NO DESC) AS SEQ_NO,
									COMP_FLG,
									DEL_FLG 
								FROM
									PRODUCTION_ACTUAL
								WHERE
									LINE_CD = '$line_cd' ) A
							WHERE
								A.SEQ_NO IS NULL OR A.SEQ_NO = 1
								AND A.COMP_FLG = 0
								AND A.DEL_FLG = 0
							) PA ON SW.WI = PA.WI_NO
							
						WHERE
						SW.PRD_COMP_FLG IS NOT NULL
						ORDER BY SW.WORK_ODR_DLV_DATE, SW.WI ASC ";

		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		return $recFa;
	}

	public function chk_cur_prod_plan ( $line_cd , $wi_no )  //CHECK CURRENT PRODUCTION PLAN
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT
						CP.ID AS ID,
						CP.ID_PLAN AS ID_PLAN,
						CP.PROD_FLG AS PROD_FLG,
						SW.LINE_CD AS LINE_CD,
						SW.WI AS WI_NO,
					  CP.PLAN_DATE AS PLAN_DATE,
					  SW.WORK_ODR_DLV_DATE AS ORG_PLAN,
					  CP.ORDER_FLG AS ORDER_FLG
					FROM
						( SELECT
								*
							FROM
								CONTROL_PROD_PLAN
							WHERE
								LINE_CD = '$line_cd' --Line Code
					-- 			AND PROD_FLG = '4' 
						) CP
						LEFT OUTER JOIN
						( SELECT
							*
						FROM
							SUP_WORK_PLAN_SUPPLY_DEV
						WHERE
							LINE_CD = '$line_cd' --Line Code
							AND ( LVL = '1' AND LVL IS NOT NULL )
							AND PRD_COMP_FLG = '0' ) SW ON CP.ID_PLAN = SW.IND_ROW
							LEFT OUTER JOIN
						( SELECT
								A.WI AS WI_NO
							FROM
								( SELECT
									WI AS WI,
									ROW_NUMBER() OVER (PARTITION BY WI ORDER BY LOT_NO, SEQ_NO DESC) AS SEQ_NO,
									COMP_FLG,
									DEL_FLG 
								FROM
									PRODUCTION_ACTUAL
								WHERE
									LINE_CD = '$line_cd' ) A
							WHERE
								A.SEQ_NO IS NULL OR A.SEQ_NO = 1
								AND A.COMP_FLG = 0
								AND A.DEL_FLG = 0
							) PA ON SW.WI = PA.WI_NO
					WHERE
						SW.PRD_COMP_FLG IS NOT NULL
						AND CP.WI = '$wi_no'
							
					ORDER BY CP.PROD_FLG, CP.ORDER_FLG ASC ";

		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		return $recFa;
	}

	public function chk_max_seq ( $line_cd , $col )  //CHECK MAX SEQUENCE
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT
						MAX( CP.ORDER_FLG ) AS MAX
					FROM
						( SELECT
								*
							FROM
								CONTROL_PROD_PLAN
							WHERE
								LINE_CD = '$line_cd' --Line Code
		 						AND PROD_FLG = '$col' --Column
						) CP
						LEFT OUTER JOIN
						( SELECT
							*
						FROM
							SUP_WORK_PLAN_SUPPLY_DEV
						WHERE
							LINE_CD = '$line_cd' --Line Code
							AND ( LVL = '1' AND LVL IS NOT NULL )
							AND PRD_COMP_FLG = '0' ) SW ON CP.ID_PLAN = SW.IND_ROW
						LEFT OUTER JOIN
						( SELECT
								WI_PLAN,
								SUM(QTY) AS QTY
							FROM
								PRODUCTION_ACTUAL_DETAIL
							WHERE
								LINE_CD = '$line_cd' --Line Code
							GROUP BY WI_PLAN ) DT ON SW.WI = DT.WI_PLAN
							LEFT OUTER JOIN
						( SELECT
								A.WI AS WI_NO
							FROM
								( SELECT
									WI AS WI,
									ROW_NUMBER() OVER (PARTITION BY WI ORDER BY LOT_NO, SEQ_NO DESC) AS SEQ_NO,
									COMP_FLG,
									DEL_FLG 
								FROM
									PRODUCTION_ACTUAL
								WHERE
									LINE_CD = '$line_cd' ) A  --Line Code
							WHERE
								A.SEQ_NO IS NULL OR A.SEQ_NO = 1
								AND A.COMP_FLG = 0
								AND A.DEL_FLG = 0
							) PA ON SW.WI = PA.WI_NO
					WHERE
						SW.PRD_COMP_FLG IS NOT NULL ";

		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		// return $recFa;
		if( !is_null ($recFa[0]['MAX']) )
		{
			$max = $recFa[0]['MAX']+1;
			return $max;
		}
		else
		{
			return 1;
		}
	}

	//================================== CALENDAR MASTER ==================================//

	public function cal_mst ()  //CALL THIS FUNCTION TO GET CALENDAR MASTER
	{
		$this->clear_cal_mst ();

		$chk_exp_cal_mst = $this->chk_exp_cal_mst ();
		
		foreach ( $chk_exp_cal_mst as $key => $value )
		{
			$this->ins_cal_mst_fa( $value['CAL_DATE'] );
		}
	}

	public function clear_cal_mst () //CLEAR CALENDAR MASTER IN FA
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " TRUNCATE TABLE sys_exp_cal ";
		$excFa = $this->new_fa->query( $sqlFa );
	}

	public function chk_exp_cal_mst () //GET CALENDAR MASTER FROM EXPJ
	{
		$this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT CAL_DATE FROM M_CAL WHERE CAL_DATE BETWEEN TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(SYSDATE+14,'YYYY/MM/DD') AND CAL_NO=1 AND HOLIDAY_FLG= 0 ";
		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();

		return $recExp;
	}

	public function ins_cal_mst_fa ( $cal_date )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlIns = " INSERT INTO sys_exp_cal( cal_date , created_by , created_date , updated_by , updated_date ) VALUES ( '$cal_date' , 'SYSTEM' , SYSDATETIME() , 'SYSTEM' , SYSDATETIME() );";

		$excIns = $this->new_fa->query( $sqlIns );
	}

	//================================== CALENDAR MASTER ==================================//

	public function get_plan_date ()
	{
		$this->cal_mst ();
		$date = date( 'Y/m/d' , strtotime(' +1 day') );
		$id = $this->chk_date_show_plan ( $date , '1' );
		if( $id != 0 )
		{
			$id = (int)$id + 1;
			$fu_date = $this->chk_date_show_plan ( $id , '2' );
		}
		else
		{
			$fu_date = $this->chk_date_show_plan ( $date , '3' );
		}
		return $fu_date;
	}

	public function chk_date_show_plan ( $data , $type )  //CHECK FUTURE DATE
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		if( $type == 1 )
		{
			$sql = " SELECT cal_id from sys_exp_cal WHERE cal_date = '$data' ";
			$exc = $this->new_fa->query( $sql );
			$rec = $exc->result_array();

			if( !empty( $rec ) )
			{
				return $rec[0]['cal_id'];
			}
			else
			{
				return '0';
			}
		}
		elseif( $type == 2 )
		{
			$sql = " SELECT cal_date AS cal_date from sys_exp_cal WHERE cal_id = '$data' ";
			$exc = $this->new_fa->query( $sql );
			$rec = $exc->result_array();

			return $rec[0]['cal_date'];
		}
		elseif( $type == 3 )
		{
			$sql = " SELECT TOP 1 cal_date AS cal_date FROM sys_exp_cal WHERE cal_date > '$data' ORDER BY cal_date ASC ";

			$exc = $this->new_fa->query( $sql );
			$rec = $exc->result_array();
			
			return $rec[0]['cal_date'];
		}
	}

}
?>