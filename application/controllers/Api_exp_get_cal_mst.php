<?php
class Api_exp_get_cal_mst extends CI_Controller
{

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
		// $date = '2022/04/03';
		$date = date( 'Y/m/d' , strtotime(' +1 day') );
		// var_dump($date); exit;

		$id = $this->chk_date_show_plan ( $date , '1' );
		 // var_dump($id); exit;

		if( $id != 0 )
		{
			$id = (int)$id + 1;
			// var_dump($id); exit;
			$fu_date = $this->chk_date_show_plan ( $id , '2' );
		}
		else
		{
			$fu_date = $this->chk_date_show_plan ( $date , '3' );
		}

		// var_dump($fu_date); exit;
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