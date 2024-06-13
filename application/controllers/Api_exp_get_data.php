<?php
class Api_exp_get_data extends CI_Controller
{

	//================================== CUSTOMER MASTER GROUP ==================================//

	public function get_cust_mst_grp () //CALL THIS FUNCTION TO CHECK
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);
		$this->exp = $this->load->database('explanner_db', true);

		$chk_cust_mst_grp_cnt = $this->chk_cust_mst_grp_cnt ();

		if( $chk_cust_mst_grp_cnt == 1 )
		{
			$this->upd_cust_mst_grp ();
		}
	}

	public function chk_cust_mst_grp_cnt ()
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);
		$this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT COUNT(CUST_GRP_CD) AS CNT FROM M_CUST_GRP ";
		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();
		$exp_cnt = (int)$recExp['0']['CNT'];

		$sqlFa = " SELECT COUNT(cust_grp_cd) AS CNT FROM mst_cust_grp ";
		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();
		$fa_cnt = (int)$recFa['0']['CNT'];

		if( $exp_cnt > $fa_cnt )
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function upd_cust_mst_grp ()
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);
		$this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT CUST_GRP_CD, CUST_GRP_NAME FROM M_CUST_GRP ";
		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();

		foreach ( $recExp as $key => $value ) 
		{
			$status = $this->chk_fa_cust_mst_grp ( $value['CUST_GRP_CD'] );

			if( $status == 1 )
			{
				$this->ins_fa_cust_mst_grp( $value['CUST_GRP_CD'] , $value['CUST_GRP_NAME'] );
			}
		}
	}

	public function chk_fa_cust_mst_grp ( $cust_grp_cd )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT * from mst_cust_grp where cust_grp_cd = '$cust_grp_cd' ";
		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		if( empty($recFa) )
		{
			return 1;
		}
		else
		{
			return 0;
		}
		// var_dump($recFa); exit;
	}

	public function ins_fa_cust_mst_grp ( $cust_grp_cd , $cust_grp_name )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlIns = " INSERT INTO mst_cust_grp( cust_grp_cd , cust_grp_name , status_flg , created_by , created_date , updated_by , updated_date , cust_grp_name_orig ) VALUES ( '$cust_grp_cd' , '$cust_grp_name' , '1' , 'SYSTEM' , SYSDATETIME() , 'SYSTEM' , SYSDATETIME() , '$cust_grp_name' );";

		$excIns = $this->new_fa->query( $sqlIns );
	}

	public function check_cust_group ( $cust_grp_cd )
	{
		// var_dump($cust_grp_cd); exit;
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT cust_grp_name from mst_cust_grp where cust_grp_cd = '$cust_grp_cd' ";
		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();
		$cust_grp_name = $recFa[0]['cust_grp_name'];

		// var_dump($recFa[0]['cust_grp_name']); exit;
		return $cust_grp_name;
	}

	//================================== GET CUSTOMER ORDER ==================================//

	public function get_exp_ord ()
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sql = "TRUNCATE TABLE tag_fg_next_proc_ord";
		$exc = $this->new_fa->query($sql);

		//========================================================//

		$this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT
						TR.CUST_CD AS CUST_CD, 
						TR.CUST_ITEM_CD AS CUST_ITEM_CD,
						TR.ITEM_CD AS ITEM_CD

					FROM
						( SELECT 
						CUST_CD, 
						CUST_ITEM_CD,
						ITEM_CD, 
						CASE WHEN CUST_CD = 'T00100' THEN STNDRD_RCV_DESINATED_DLV_DATE ELSE DESINATED_DLV_DATE END AS DESINATED_DLV_DATE
						
						FROM 
						T_ODR 
						
						WHERE
						DEL_FLG = 0 ) TR
						
					WHERE
						TO_CHAR( TR.DESINATED_DLV_DATE,'YYYY/MM/DD') BETWEEN (TO_CHAR(SYSDATE+1,'YYYY/MM/DD')) AND (TO_CHAR(SYSDATE+2,'YYYY/MM/DD') )
						
					GROUP BY TR.CUST_CD, TR.CUST_ITEM_CD, TR.ITEM_CD ";

		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();

		foreach ( $recExp as $key => $value )
		{
			$this->insert_exp_ord( $value['CUST_CD'] , $value['CUST_ITEM_CD'] , $value['ITEM_CD'] );
		}
	}

	public function insert_exp_ord ( $cust_cd , $cust_item_cd , $item_cd )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlIns = " INSERT INTO tag_fg_next_proc_ord( cust_cd , cust_item_cd , item_cd , last_updated_date ) VALUES ( '$cust_cd' , '$cust_item_cd' , '$item_cd' , SYSDATETIME() );";

		$excIns = $this->new_fa->query( $sqlIns );
	}

	//================================== GET FG NEXT PROC ==================================//

	public function fg_next_proc ()
	{
		$this-> get_exp_ord(); //exit;
		$this-> get_cust_mst_grp();

		$this->new_fa = $this->load->database('tbkkfa01_db', true);
		$sqlClear = "TRUNCATE TABLE tag_fg_next_proc";
        $excClear = $this->new_fa->query($sqlClear);

        $this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT
						CI.CUST_CD AS CUST_CD,
						CG.CUST_GRP_CD AS CUST_GRP_CD,
						NULL AS CUST_GRP_NAME,
						CI.CUST_ITEM_CD AS CUST_ITEM_CD,
						CI.ITEM_CD AS ITEM_CD,
						NULL AS STATUS_FLG,
						IT.PRODUCT_TYP AS PRODUCT_TYP
					FROM
						M_CUST_ITEM CI,
						M_CUST CS,
						M_CUST_GRP CG,
						M_PLANT_ITEM IT
					WHERE
						CI.CUST_CD = CS.CUST_CD ( + ) 
						AND CS.CUST_GRP_CD = CG.CUST_GRP_CD ( + ) 
						AND CI.ITEM_CD = IT.ITEM_CD ( + ) 
						AND TO_CHAR( CI.EFF_PHASE_OUT_DATE, 'YYYY/MM/DD' ) >= TO_CHAR( SYSDATE, 'YYYY/MM/DD' ) 
					ORDER BY
						CI.CUST_CD,
						CI.ITEM_CD ASC ";

		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();

		// var_dump($recExp); exit;

		foreach ( $recExp as $key => $value )
		{
			$recExp[$key]['CUST_GRP_NAME'] = $this->check_cust_group( $value['CUST_GRP_CD'] );
			// var_dump($recExp[$key]['CUST_GRP_NAME']); exit;

			//Updated date on SHOWA 18/07/2022 / ITT 05/10/2022 by AMM because customer request.
			//Updated date on 22/12/2022 SHOWA TO RMT
			if( $recExp[$key]['CUST_GRP_NAME'] == 'RMT' )
			{
				$recExp[$key]['CUST_GRP_NAME'] = $recExp[$key]['CUST_GRP_NAME']."/".$value['CUST_ITEM_CD'];
			}
			elseif( $recExp[$key]['CUST_GRP_NAME'] == 'ITT' )
			{
				$recExp[$key]['CUST_GRP_NAME'] = $recExp[$key]['CUST_GRP_NAME']."/".$value['CUST_ITEM_CD'];
			}
			//===========================================================

			$recExp[$key]['STATUS_FLG'] = $this->check_order( $value['CUST_CD'] , $value['CUST_ITEM_CD'] , $value['ITEM_CD'] );

			$this->insert_tag_fg_next_proc( $value['CUST_CD'] , $recExp[$key]['CUST_GRP_NAME'] , $value['CUST_ITEM_CD'] , $value['ITEM_CD'] , $recExp[$key]['STATUS_FLG'] , $value['PRODUCT_TYP'] );
		}

		// var_dump($recExp); exit;
	}

	public function check_order ( $cust_cd , $cust_item_cd , $item_cd )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);
		// $this->exp = $this->load->database('explanner_db', true);

		// $sqlExp = " SELECT
		// 				TR.CUST_CD, 
		// 				TR.CUST_ITEM_CD,
		// 				TR.ITEM_CD

		// 			FROM
		// 				( SELECT 
		// 				CUST_CD, 
		// 				CUST_ITEM_CD,
		// 				ITEM_CD, 
		// 				CASE WHEN CUST_CD = 'T00100' THEN STNDRD_RCV_DESINATED_DLV_DATE ELSE DESINATED_DLV_DATE END AS DESINATED_DLV_DATE
						
		// 				FROM 
		// 				T_ODR 
						
		// 				WHERE
		// 				DEL_FLG = 0 ) TR
						
		// 			WHERE
		// 				TO_CHAR( TR.DESINATED_DLV_DATE,'YYYY/MM/DD') BETWEEN (TO_CHAR(SYSDATE+1,'YYYY/MM/DD')) AND (TO_CHAR(SYSDATE+2,'YYYY/MM/DD') )
		// 				AND TR.CUST_CD = '$cust_cd'
		// 				AND TR.CUST_ITEM_CD = '$cust_item_cd'
		// 				AND TR.ITEM_CD = '$item_cd'
						
		// 			GROUP BY TR.CUST_CD, TR.CUST_ITEM_CD, TR.ITEM_CD
		// 			-- ORDER BY TR.CUST_CD, TR.CUST_ITEM_CD ASC 
		// 			";

		// $excExp = $this->exp->query( $sqlExp );
		// $recExp = $excExp->result_array();
		$sql = " SELECT * FROM TAG_FG_NEXT_PROC_ORD WHERE CUST_CD = '$cust_cd' AND CUST_ITEM_CD = '$cust_item_cd' AND ITEM_CD = '$item_cd' ";
		$exc = $this->new_fa->query( $sql );
		$rec = $exc->result_array();
		// var_dump($rec); exit;

		if( !empty($rec) )
        {
            return 1;
        }
        else
        {
            return 0;
        }

	}

	public function insert_tag_fg_next_proc ( $cust_cd , $cust_grp_name , $cust_item_cd , $item_cd , $status_flg , $product_typ )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlIns = " INSERT INTO tag_fg_next_proc( cust_cd , cust_grp_name , cust_item_cd , item_cd , status_flg , product_typ , last_updated_date ) VALUES ( '$cust_cd' , '$cust_grp_name' , '$cust_item_cd' , '$item_cd' , '$status_flg' , '$product_typ' , SYSDATETIME() );";

		$excIns = $this->new_fa->query( $sqlIns );

		// exit;
	}
}
?>