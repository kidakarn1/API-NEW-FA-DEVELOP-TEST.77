<?php
class Api_exp_get_defect_mst extends CI_Controller
{

	//================================== DEFECT MASTER ==================================//

	public function comp_defect_mst ()  //CALL THIS FUNCTION TO CHECK
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);
		$this->exp = $this->load->database('explanner_db', true);

		$chk_defect_mst_fa = $this->chk_defect_mst_fa ();
		// var_dump($chk_defect_mst_fa); exit;
 
		// if( !empty ($chk_defect_mst_fa) )
		// {
		foreach ( $chk_defect_mst_fa as $key => $value ) //Compare defect master by use main master from FA
		{
			$chk_defect_mst_exp = $this->chk_defect_mst_exp ($value['DEF_CD']);

			// var_dump($chk_defect_mst_exp);

			if( $chk_defect_mst_exp == 1 )
			{
				$this->upd_defect_mst_sts_fa ( $value['DEF_CD'] , '5' );
			}
			else
			{
				if( $chk_defect_mst_exp <> $value['DEF_NAME_EN'] )
				{
					$this->upd_defect_mst_name_fa ( $value['DEF_CD'] , $chk_defect_mst_exp );
				}

				if( $value['STATUS_FLG'] == 5 )
				{
					$this->upd_defect_mst_sts_fa ( $value['DEF_CD'] , '1' );
				}
			}
			// }
		}

		$chk_defect_mst_exp_all = $this->chk_defect_mst_exp_all ();
		// var_dump($chk_defect_mst_exp_all); exit;

		foreach ( $chk_defect_mst_exp_all as $key => $value2 ) //Compare defect master by use main master from EXPJ
		{
			$chk_defect_mst_fa_exp = $this->chk_defect_mst_fa_exp ($value2['CLASS_CD3']);

			if( $chk_defect_mst_fa_exp == 1 )
			{
				$this->ins_defect_mst_fa ( $value2['CLASS_CD3'] , $value2['CLASS_NAME'] );
			}
		}
	}

	public function chk_defect_mst_fa ()
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT DEF_CD, DEF_NAME_EN, STATUS_FLG FROM sys_exp_defect_mst ";
		$excFa = $this->new_fa->query( $sqlFa );
		$recFa = $excFa->result_array();

		return $recFa;
	}

	public function chk_defect_mst_fa_exp ( $def_cd )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " SELECT * FROM sys_exp_defect_mst WHERE DEF_CD = '$def_cd' ";
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
	}

	public function upd_defect_mst_sts_fa ( $def_cd , $status_flg )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " UPDATE sys_exp_defect_mst SET status_flg = '$status_flg', updated_date = SYSDATETIME(), updated_by = 'SYSTEM' WHERE def_cd = '$def_cd' ";
		$excFa = $this->new_fa->query( $sqlFa );
		// $recFa = $excFa->result_array();
	}

	public function upd_defect_mst_name_fa ( $def_cd , $def_name_en )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlFa = " UPDATE sys_exp_defect_mst SET def_name_en = '$def_name_en', updated_date = SYSDATETIME(), updated_by = 'SYSTEM' WHERE def_cd = '$def_cd' ";
		$excFa = $this->new_fa->query( $sqlFa );
		// $recFa = $excFa->result_array();
	}

	public function chk_defect_mst_exp ( $def_cd ) //CHECK MASTER FROM EXPJ
	{
		$this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT * FROM M_CLASS WHERE CLASS_CD1 = '52' AND CLASS_CD2 = '01' AND ( CLASS_CD3 <> '00' AND CLASS_CD3 = '$def_cd' ) ";
		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();

		if( empty($recExp) )
		{
			return 1;
		}
		else
		{
			return $recExp[0]['CLASS_NAME'];
		}
	}

	public function chk_defect_mst_exp_all () //CHECK MASTER FROM EXPJ
	{
		$this->exp = $this->load->database('explanner_db', true);

		$sqlExp = " SELECT CLASS_CD3, CLASS_NAME FROM M_CLASS WHERE CLASS_CD1 = '52' AND CLASS_CD2 = '01' AND CLASS_CD3 <> '00' ";
		$excExp = $this->exp->query( $sqlExp );
		$recExp = $excExp->result_array();

		return $recExp;
	}

	public function ins_defect_mst_fa ( $def_cd , $def_name )
	{
		$this->new_fa = $this->load->database('tbkkfa01_db', true);

		$sqlIns = " INSERT INTO sys_exp_defect_mst( def_cd , def_name_en , status_flg , created_by , created_date , updated_by , updated_date ) VALUES ( '$def_cd' , '$def_name' , '1' , 'SYSTEM' , SYSDATETIME() , 'SYSTEM' , SYSDATETIME() );";

		$excIns = $this->new_fa->query( $sqlIns );
	}

	//================================== DEFECT MASTER ==================================//
}
?>