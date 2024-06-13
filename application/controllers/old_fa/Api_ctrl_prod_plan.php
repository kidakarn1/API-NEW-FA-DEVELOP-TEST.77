<?php
class Api_ctrl_prod_plan extends CI_Controller
{
	public function manage_prod_plan ()
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$line_mst = $this->chk_new_fa_line ();

		foreach ( $line_mst as $key => $value ) 
		{
			// var_dump($value)."\n";
			//================================== UPDATE PLAN TOMORROW PLAN TO TODAY PLAN ==================================//

			$chk_plan_tmr = $this->chk_cur_prod_plan ( $value['LINE_CD'] , '3' );
			// var_dump($chk_plan_tmr); 
			// exit;
			if( !empty ($chk_plan_tmr) )
			{
				foreach ( $chk_plan_tmr as $key2 => $value2 ) 
				{
					$max_seq = $this->chk_max_seq ( $value['LINE_CD'] , '2' );	

					// var_dump($value['LINE_CD'])."\n";
					// var_dump($max_seq)."\n";

					// if( !isse ($max_seq) )
					// {
					// 	$max_seq = (int)$max_seq + 1;
					// }
					// else
					// {
					// 	$max_seq = 1;
					// }
					
					// var_dump($max_seq)."\n";
					// exit;

					// $upd_plan_tmr = $this->upd_prod_plan ( $value2['ID'] , '2' , $max_seq );

					// echo "UPD TOMORROW COLUMN";
					// var_dump($upd_plan_tmr); 
					// exit;
					$this->upd_prod_plan ( $value2['ID'] , '2' , $max_seq );
				}
			}

			//================================== UPDATE PLAN FUTURE PLAN TO TOMORROW PLAN ==================================//

			$chk_plan_future = $this->chk_cur_prod_plan ( $value['LINE_CD'] , '4' );

			// var_dump($chk_plan_future); 
			// exit;
			if( !empty ($chk_plan_future) )
			{
				foreach ( $chk_plan_future as $key3 => $value3 ) 
				{
					$chk_date = date('Y-m-d', strtotime("tomorrow"));
					// echo $chk_date;
					// echo date("Y-m-d",strtotime($value3['PLAN_DATE']));
					$plan_date = date("Y-m-d",strtotime($value3['PLAN_DATE']));
					// echo $plan_date;
					if( $chk_date == $plan_date ) //CHECK THAT FUTURE PLAN ( PLAN DATE ) SAME AS TOMORROW DATE OR NOT
					{
						$max_seq2 = $this->chk_max_seq ( $value['LINE_CD'] , '3' );

						// var_dump($value['LINE_CD'])."\n";
						// var_dump($max_seq2)."\n";

						// if( !is_null ($max_seq2) )
						// {
						// 	$max_seq2 = (int)$max_seq2 + 1;
						// }
						// else
						// {
						// 	$max_seq2 = 1;
						// }
						
						// var_dump($max_seq2)."\n";
						// exit;

						// $upd_plan_future = $this->upd_prod_plan ( $value3['ID'] , '3' , $max_seq2 );
						// echo "UPD FUTURE COLUMN";
						// var_dump($upd_plan_future); 
						// exit;
						$this->upd_prod_plan ( $value3['ID'] , '3' , $max_seq2 );
					}
				}
			}
			// else
			// {
			// 	var_dump("AAA"); exit;
			// }
			// exit;
		}
	}

	public function chk_cur_prod_plan ( $line_cd , $col ) //CHECK CURRENT REMAIN PRODUCTION PLAN
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		// $sqlFa = "	SELECT
		// 					CP.ID AS ID,
		// 					CP.ID_PLAN AS ID_PLAN,
		// 					SW.LINE_CD AS LINE_CD,
		// 					SW.WI AS WI_NO,
		// 				  	SW.ITEM_CD AS ITEM_CD,
		// 				  	SW.ITEM_NAME AS ITEM_NAME,
		// 				  	SW.MODEL AS MODEL,
		// 				  	SW.QTY AS PLAN_QTY,
		// 					ISNULL(DT.QTY, 0 ) AS ACT_QTY,
		// 				  	SW.QTY - ISNULL(DT.QTY, 0 ) AS REM_QTY,
		// 				  	CP.PLAN_DATE AS PLAN_DATE,
		// 				  	SW.WORK_ODR_DLV_DATE AS ORG_PLAN,
		// 				  	CP.ORDER_FLG
		// 				FROM
		// 					( SELECT
		// 							*
		// 						FROM
		// 							CONTROL_PROD_PLAN
		// 						WHERE
		// 							LINE_CD = '$line_cd' --Line Code
		// 							AND PROD_FLG = '$col'
		// 					) CP
		// 					LEFT OUTER JOIN
		// 					( SELECT
		// 						*
		// 					FROM
		// 						SUP_WORK_PLAN_SUPPLY_DEV
		// 					WHERE
		// 						LINE_CD = '$line_cd' --Line Code
		// 						AND ( LVL = '1' AND LVL IS NOT NULL )
		// 						AND PRD_COMP_FLG = '0' ) SW ON CP.ID_PLAN = SW.IND_ROW
		// 					LEFT OUTER JOIN
		// 					( SELECT
		// 							WI_PLAN,
		// 							SUM(QTY) AS QTY
		// 						FROM
		// 							PRODUCTION_ACTUAL_DETAIL
		// 						WHERE
		// 							LINE_CD = '$line_cd' --Line Code
		// 						GROUP BY WI_PLAN ) DT ON SW.WI = DT.WI_PLAN
		// 				WHERE
		// 					SW.PRD_COMP_FLG IS NOT NULL
								
		// 				ORDER BY CP.ORDER_FLG ASC ";

			$sqlFa = " SELECT
						CP.ID AS ID,
						CP.ID_PLAN AS ID_PLAN,
						SW.LINE_CD AS LINE_CD,
						SW.WI AS WI_NO,
					  SW.ITEM_CD AS ITEM_CD,
					  SW.ITEM_NAME AS ITEM_NAME,
					  SW.MODEL AS MODEL,
					  SW.QTY AS PLAN_QTY,
						ISNULL(DT.QTY, 0 ) AS ACT_QTY,
					  SW.QTY - ISNULL(DT.QTY, 0 ) AS REM_QTY,
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
								AND PROD_FLG = '$col' 
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
									LINE_CD = '$line_cd' ) A
							WHERE
								A.SEQ_NO IS NULL OR A.SEQ_NO = 1
								AND A.COMP_FLG = 0
								AND A.DEL_FLG = 0
							) PA ON SW.WI = PA.WI_NO
					WHERE
						SW.PRD_COMP_FLG IS NOT NULL
							
						ORDER BY CP.ORDER_FLG ASC ";

			$excFa = $this->new_fa->query( $sqlFa );
			$recFa = $excFa->result_array();

			return $recFa;
	}
 
	public function chk_new_fa_line ()  //CHECK NEW FA LINE
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT DEP_CD, LINE_CD FROM SYS_LINE_MST WHERE CHK_SYS_FLG='1' AND ENABLE = '1' ORDER BY DEP_CD, LINE_CD ASC ";
		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		return $recFa;
	}

	public function chk_max_seq ( $line_cd , $col )  //CHECK MAX SEQUENCE
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		// $sqlFa = " SELECT
		// 				MAX( CP.ORDER_FLG ) AS MAX
		// 			FROM
		// 				( SELECT
		// 						*
		// 					FROM
		// 						CONTROL_PROD_PLAN
		// 					WHERE
		// 						LINE_CD = '$line_cd' --Line Code
		// 						AND PROD_FLG = '$col' --Column
		// 				) CP
		// 				LEFT OUTER JOIN
		// 				( SELECT
		// 					*
		// 				FROM
		// 					SUP_WORK_PLAN_SUPPLY_DEV
		// 				WHERE
		// 					LINE_CD = '$line_cd' --Line Code
		// 					AND ( LVL = '1' AND LVL IS NOT NULL )
		// 					AND PRD_COMP_FLG = '0' ) SW ON CP.ID_PLAN = SW.IND_ROW
		// 				LEFT OUTER JOIN
		// 				( SELECT
		// 						WI_PLAN,
		// 						SUM(QTY) AS QTY
		// 					FROM
		// 						PRODUCTION_ACTUAL_DETAIL
		// 					WHERE
		// 						LINE_CD = '$line_cd' --Line Code
		// 					GROUP BY WI_PLAN ) DT ON SW.WI = DT.WI_PLAN
		// 			WHERE
		// 				SW.PRD_COMP_FLG IS NOT NULL ";

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

		// echo "MAX DB => ".$recFa[0]['MAX'];

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

	public function upd_prod_plan ( $id , $col , $seq )  //UPDATE PRODUCTION PLAN
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " UPDATE CONTROL_PROD_PLAN SET prod_flg = '$col', order_flg = '$seq', update_date = GETDATE(), update_by = 'SYSTEM' WHERE ID = '$id' ";
		$excFa = $this->new_fa->query( $sqlFa );

		// return $sqlFa;
	}

}
?>