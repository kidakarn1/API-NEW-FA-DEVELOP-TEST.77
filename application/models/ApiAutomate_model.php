<?php
class ApiAutomate_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->fa = $this->load->database('fa_db', true);
        $this->exp = $this->load->database('explanner_db', true);
    }

    public function getExplannerLineMaster() {
    	$expLineMst = $this->getLineMasterFromExp();
    	$faLineMst = $this->getLineMasterFromFA();
    	if (!empty($expLineMst)) {
    		$faLineCombine = array_combine(
			    array_column($faLineMst, "line_cd"),
			    $faLineMst
			);
    		$result = [];
			foreach ($expLineMst as $key => $value) {
				if (!empty($faLineCombine[$value->LINE_CD])) {
					$data = $faLineCombine[$value->LINE_CD];
					if ($value->DEP_CD != $data->dep_cd) {
						$this->insertLineMaster($value->DEP_CD, $value->LINE_CD, $value->LINE_NAME);
						$this->updateLineMaster($data->line_id, $data->line_name, 0, 0);
					} else {
						if ($value->LINE_NAME != $data->line_name) {
							$this->updateLineMaster($data->line_id, $value->LINE_NAME, 1, 1);
						}
					}
				} else {
					$this->insertLineMaster($value->DEP_CD, $value->LINE_CD, $value->LINE_NAME);
				}
			}
    		return true;
    	}
    	return false;
    }

    public function updateLineMaster($id, $name, $enable, $sys_flg) {
    	$currentDate = date('Y-m-d H:i:s');
    	$sql = "UPDATE sys_line_mst SET line_name = '{$name}', enable = $enable, chk_sys_flg = '{$sys_flg}', updated_date = '{$currentDate}', updated_by = 'SYSTEM' WHERE line_id = $id";
    	$this->fa->query($sql);
    }

    public function insertLineMaster($dep_cd, $line_cd, $line_name) {
    	$currentDate = date('Y-m-d H:i:s');
    	$sql = "INSERT INTO sys_line_mst (dep_cd, line_cd, line_name, enable, created_date, created_by, updated_date, updated_by, chk_sys_flg, man_limit)
    			VALUES ('{$dep_cd}','{$line_cd}','{$line_name}',1,'{$currentDate}','SYSTEM','{$currentDate}','SYSTEM','1',6)";
    	$this->fa->query($sql);
    }

    public function getLineMasterFromFA() {
    	$sql = "SELECT line_id, dep_cd, line_cd, line_name FROM sys_line_mst";
    	$query = $this->fa->query($sql);
    	return $query->num_rows() > 0 ? $query->result() : [];
    }

    public function getLineMasterFromExp() {
    	$sql = "SELECT
					VM.PARENT_SEC_CD AS DEP_CD,
					VD.SEC_CD AS LINE_CD,
					VD.SEC_NM AS LINE_NAME 
				FROM
					( SELECT PARENT_SEC_CD, COMP_SEC_CD, SUBSTR( COMP_SEC_CD, 5, 2 ) AS CHK_COMP_SEC_CD, EFF_PHASE_OUT_YM FROM VM_DEPARTMENT_CLASS ) VM,
					VM_DEPARTMENT VD 
				WHERE
					VM.COMP_SEC_CD = VD.SEC_CD ( + ) 
					AND VM.PARENT_SEC_CD IS NOT NULL 
					AND VD.LEVEL_VALUE = '70' 
					AND (
						( TO_CHAR( TO_DATE( VM.EFF_PHASE_OUT_YM, 'YYYYMM' ), 'YYYY/MM/DD' ) IS NULL ) 
						OR ( TO_CHAR( TO_DATE( VM.EFF_PHASE_OUT_YM, 'YYYYMM' ), 'YYYY/MM/DD' ) >= TO_CHAR( SYSDATE - 1, 'YYYY/MM/DD' ) ) 
					) 
					AND VM.CHK_COMP_SEC_CD <> '00' 
				ORDER BY
					VM.PARENT_SEC_CD,
					VD.SEC_CD ASC";
		$query = $this->exp->query($sql);
		return $query->num_rows() > 0 ? $query->result() : [];
    }
}