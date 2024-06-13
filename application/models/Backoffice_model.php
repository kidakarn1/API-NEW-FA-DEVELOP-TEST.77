<?php
class Backoffice_model extends CI_Model {

    public function Login($usr='',$pwd='') 
    {
    	$DB2 = $this->load->database('another_db', TRUE);

		$p['usr'] = trim($usr);
		$p['pwd'] = md5(trim($pwd));

		$DB2->select('*');
		$DB2->from('USER_MST');
		$DB2->where('USER_CD', $p['usr'])->where('PASSWORD', $p['pwd']);
		$query = $DB2->get();

		if($query->num_rows()!=0) {
			
			$result = $query->result_array();	
			return $result[0];
			
		}else { 
			
			$error = array('action'=>'err', 'value'=>'i');			
			return $error;
		}

    }

    public function Ins_exc_rate($cur_type='',$cur_value=''){
    	$jeaw_db = $this->load->database('jeaw_db', TRUE);

    	$cur_date = date('Y-m-d H:i:s');
		
		$sqlUpd = "UPDATE EXC_RATE SET CURRENCY_RATE = '{$cur_value}' , UPDATED_DATE = '{$cur_date}' WHERE CURRENCY = '{$cur_type}';";
		$excUpd = $this->jeaw_db->query($sqlUpd);	
		
	}




	public function ShowMenu($key){

		
		$sqlGroupMenu = "SELECT * FROM sys_menu_groups_report;";
		$excGroupMenu = $this->db->query($sqlGroupMenu);

		$result = array();
		foreach($excGroupMenu->result_array() as $gm){

			// var_dump($gm);
			// exit();

			$sqlSubMenu = "SELECT
			sm.*
			FROM
			sys_menus_report AS sm 
			LEFT JOIN sys_menu_groups_report AS smg ON smg.mg_id = sm.mg_id
			WHERE sm.mg_id='{$gm['mg_id']}'
			ORDER BY smg.order_no ASC, sm.order_no ASC
			;";
			
			$excSubMenu = $this->db->query($sqlSubMenu);			
			
			$subMenu = array();	
			foreach($excSubMenu->result_array() as $sm){
				
				array_push($subMenu, array('name'=>$sm['name'], 'method'=>$sm['method'], 'link'=>$sm['link']));
				
			}
		
			array_push($result, array('g_name'=>$gm['name'],'icon_menu'=>$gm['icon_menu'],'sub_menu'=>$subMenu));
			
						
		}

		// exit();
		
		return $result;
		
	}

	public function Logout()
	{	
		$this->session->sess_destroy(); 
		
        redirect('login/account');
		
	}

	public function CheckPermission($para){
		
		$get_url = trim($this->router->fetch_class().'/'.$this->router->fetch_method());

		$sqlChkPerm = "SELECT
			sp.`name`,
			sp.controller
			FROM
			sys_users_permissions AS sup
			INNER JOIN sys_permissions AS sp ON sp.sp_id = sup.sp_id
			LEFT JOIN sys_permission_groups AS spg ON sp.spg_id = spg.spg_id
			WHERE
			sp.enable='1' AND spg.enable='1' AND sup.su_id='{$para}' AND sp.controller='{$get_url}';";
			
		$excChkPerm = $this->db->query($sqlChkPerm);
		$numChkPerm = $excChkPerm->num_rows();
		
		if($numChkPerm == 0) {
			
			echo '<script language="javascript">';
			echo 'alert("Permission not found.");';
			echo 'history.go(-1);';
			echo '</script>';
			exit();
			
		}

	}

    public function CheckSession() 
    {
        if($this->session->userdata('loggedIn')!="OK") {
					
           redirect('login/account');
		   return FALSE;
		   
        }else{	return TRUE; 	}
    }


	public function addUser($p){
		
		## User
		$setUser = array('sug_id' => $p['group'], 
				'username' => $p['usr'], 
				'password' => $p['pwd'],
				'firstname' => $p['fname'],
				'lastname' => $p['lname'],
				'gender' => $p['sex'],
				'email' => $p['email'],
				'enable' => '1',
				'date_created' => date('Y-m-d H:i:s'),
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->set($setUser);
		$excInsUser = $this->db->insert('sys_users');
		
		$lastId = $this->db->insert_id();
						
		## User Permission 
		$sqlSelPerm = "SELECT
			sp.sp_id,
			sp.`name`
			FROM
			sys_users_groups_permissions AS sugp
			LEFT JOIN sys_permission_groups AS spg ON spg.spg_id = sugp.spg_id
			LEFT JOIN sys_permissions AS sp ON sp.spg_id = spg.spg_id
			WHERE spg.`enable`='1' AND sp.`enable`='1' AND sugp.sug_id='{$p['group']}';";
		$excSelPerm = $this->db->query($sqlSelPerm);
		
		foreach($excSelPerm->result() AS $p){
			
			$setPerm = array('su_id' => $lastId,
					'sp_id' => $p->sp_id,
					'date_created' => date('Y-m-d H:i:s')
			);
			$this->db->set($setPerm);
			$excInsPerm = $this->db->insert('sys_users_permissions');
			
		}

			
		if($excInsUser && $excInsPerm){ return $lastId; }else{ return FALSE; }
		
	}

	public function addUserProject($last_id,$pr_id){
		
		## User Project 
		$setUserPrj = array('su_id' => $last_id, 
					'pr_id' => $pr_id,
					'date_created' => date('Y-m-d H:i:s')			
					);
			
		$this->db->set($setUserPrj);
		$excInsUserPrj = $this->db->insert('user_project');
		
		if($excInsUserPrj){ return TRUE; }else{ return FALSE; }
		
	}

	public function delUserProject($key=''){
		
		$sqlDelUserProject = "DELETE FROM user_project WHERE su_id='{$key}';";
		$excDelUserProject = $this->db->query($sqlDelUserProject);
		
		if($excDelUserProject) { return TRUE; }else { return FALSE; }
		
	}

	public function addProject($p){
		
		## User
		$setProject = array('pr_name' => $p['prname'],
				'pr_description' => $p['prdes'],
				'enable' => $p['status'],
				'date_created' => date('Y-m-d H:i:s'),
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->set($setProject);
		$excInsProject = $this->db->insert('project');
		
		if($excInsProject){ return TRUE; }else{ return FALSE; }
		
	}

	public function addIssue($p){
		$sid = $this->session->userdata('sessUsrId');

		if ($p['countFile']!='0') {
			$fileRef = 'Yes';
		}else{
			$fileRef = 'No';
		}

		## Issue
		$setIssue = array('plant' => $p['rad_plant'],
				'pr_id' => $p['sel_project'],
				'current_status' => $p['sel_cur_status'],
				'priority' => $p['sel_priority'],
				'is_description' => $p['txt_issue_des'],
				'assign_name' => $p['list_Su'],
				'expect_resolution_date' => $p['date_expect'],
				'escalation_req' => $p['rad_esca'],
				'impact_summary' => $p['txt_impact'],
				'action_step' => $p['txt_act_step'],
				'is_type' => $p['sel_issue_type'],
				'date_identified' => $p['date_iden'],
				'entered_name' => $p['entered_id'],
				'actual_resolution_date' => $p['date_actual_resolution'],
				'final_resolution' => $p['txt_final_re'],
				'comment' => $p['txt_note'],
				'is_file' => $fileRef,
				'enable' => '1',
				'su_update' => $p['entered_id'],
				'date_created' => date('Y-m-d H:i:s'),
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->set($setIssue);
		$excInsIssue = $this->db->insert('issue');

		$lastId = $this->db->insert_id();

		for ($i=0; $i < $p['countFile']; $i++) { 
			$nameTime = mktime();

			$setFileUpload = array('is_id' => $lastId, 
				'file_name' => $p['fileIns'][$i], 
				'file_temp_name' => $p['fileInsTemp'][$i],
				'su_created' => $this->session->userdata('sessUsrId'),
				'file_created' => date('Y-m-d H:i:s')		
				);
		
			$this->db->set($setFileUpload);
			$excInsFileUpload = $this->db->insert('issue_file');
		}

		$sqlDelFile = "DELETE FROM upload_temp_filename WHERE u_id='{$sid}';";
		$excDelFile = $this->db->query($sqlDelFile);
		
		if($excInsIssue){ return $lastId; }else{ return FALSE; }
		
	}

	public function addFiletempname($name,$tempname){
		$setFiletempname = array('u_id' => $this->session->userdata('sessUsrId'),
				'file_name' => $name,
				'file_temp_name' => $tempname,
				'date_created' => date('Y-m-d H:i:s')				
				);
		
		$this->db->set($setFiletempname);
		$excInsUser = $this->db->insert('upload_temp_filename');
	}

	public function deleteFiletempname($name){
		
		$sid = $this->session->userdata('sessUsrId');

		$sqlDelFile = "DELETE FROM upload_temp_filename WHERE u_id='{$sid}' AND file_name='{$name}';";
		$excDelFile = $this->db->query($sqlDelFile);

	}

	public function deleteFile($id,$is_id){
		
		$sid = $this->session->userdata('sessUsrId');

		$sqlDelFile = "DELETE FROM issue_file WHERE id='{$id}';";
		$excDelFile = $this->db->query($sqlDelFile);

		$sqlSel = "SELECT * FROM issue_file WHERE is_id='{$is_id}';";
		$query = $this->db->query($sqlSel);
				
		if($query->num_rows()!=0) {

		}else{
			$sqlDel = "UPDATE issue SET is_file='No' WHERE is_id='{$is_id}';";
			$excEdt = $this->db->query($sqlDel);
		}

	}


	public function editProject($key,$p){
		
		$setProject = array('pr_name' => $p['prname'],
				'pr_description' => $p['prdes'],
				'enable' => $p['status'],
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->where('pr_id',$key);
		$excUp = $this->db->update('project',$setProject);
		
		if($excUp){ return TRUE; }else{ return FALSE; }
		
	}
	public function editCheckIssue($key,$p){

		$sid = $this->session->userdata('sessUsrId');

		$setIssue = array('current_status' => $p['sel_cur_status'],
				'actual_resolution_date' => $p['date_actual_resolution'],
				'final_resolution' => $p['txt_final_re'],
				'comment' => $p['txt_note'],
				// 'su_update' => $p['entered_id'],
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->where('is_id',$key);
		$excUp = $this->db->update('issue',$setIssue);

		if($excUp){ return TRUE; }else{ return FALSE; }
		
	}

	public function editIssue($key,$p){

		$sid = $this->session->userdata('sessUsrId');

		

		if ($p['countFile']!=0&&$p['countFile']!='') {
			$fileRef = 'Yes';
		}else{
			$sqlLoadMax = "SELECT is_file FROM issue WHERE is_id = '{$key}';";
			$excLoadMax = $this->db->query($sqlLoadMax);
			$recLoadMax = $excLoadMax->result_array();
			$is_file = $recLoadMax[0]['is_file'];

			if ($is_file=='Yes') {
				$fileRef = 'Yes';
			}else{
				$fileRef = 'No';
			}
			
		}

		
		$setIssue = array('plant' => $p['rad_plant'],
				'current_status' => $p['sel_cur_status'],
				'priority' => $p['sel_priority'],
				'is_description' => $p['txt_issue_des'],
				'assign_name' => $p['txt_assign_name'],
				'expect_resolution_date' => $p['date_expect'],
				'escalation_req' => $p['rad_esca'],
				'impact_summary' => $p['txt_impact'],
				'action_step' => $p['txt_act_step'],
				'is_type' => $p['sel_issue_type'],
				'date_identified' => $p['date_iden'],
				'actual_resolution_date' => $p['date_actual_resolution'],
				'final_resolution' => $p['txt_final_re'],
				'comment' => $p['txt_note'],
				'is_file' => $fileRef,
				'su_update' => $p['entered_id'],
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->where('is_id',$key);
		$excUp = $this->db->update('issue',$setIssue);

		$lastId = $this->db->insert_id();

		for ($i=0; $i < $p['countFile']; $i++) { 
			$nameTime = mktime();

			$setFileUpload = array('is_id' => $key, 
				'file_name' => $p['fileIns'][$i], 
				'file_temp_name' => $p['fileInsTemp'][$i],
				'su_created' => $this->session->userdata('sessUsrId'),
				'file_created' => date('Y-m-d H:i:s')		
				);
		
			$this->db->set($setFileUpload);
			$excInsFileUpload = $this->db->insert('issue_file');
		}

		$sqlDelFile = "DELETE FROM upload_temp_filename WHERE u_id='{$sid}';";
		$excDelFile = $this->db->query($sqlDelFile);
		
		if($excUp){ return TRUE; }else{ return FALSE; }
		
	}
	
	public function editUser($key,$p){
		
		if($p['pwd'] != ''){

			$setUser = array('sug_id' => $p['group'], 
				'password' => $p['pwd'],
				'firstname' => $p['fname'],
				'lastname' => $p['lname'],
				'gender' => $p['sex'],
				'email' => $p['email'],
				'date_updated' => date('Y-m-d H:i:s')				
				);
		}else{

			$setUser = array('sug_id' => $p['group'], 
				'firstname' => $p['fname'],
				'lastname' => $p['lname'],
				'gender' => $p['sex'],
				'email' => $p['email'],
				'date_updated' => date('Y-m-d H:i:s')				
				);
		}		
		
		$this->db->where('su_id',$key);
		$excUp = $this->db->update('sys_users',$setUser);
		
		if($excUp){ return TRUE; }else{ return FALSE; }
		
	}
	
	public function enableUser($key=''){
		
		$this->db->set('enable', '1');
		$this->db->set('date_updated', 'NOW()', FALSE);
		$this->db->where('su_id', $key);
		$exc_user = $this->db->update('sys_users');
		
		if ($exc_user){
			
			return TRUE;	
		
		}else{	return FALSE;	}
		 
	}

	public function num_enableUser($para){
		
		for($i=0;$i<count($para);$i++){
			
			$this->enableUser($para[$i]);
																									
		}
		
		return TRUE;
		
	}

	public function disableUser($key=''){
		
		$this->db->set('enable', '0');
		$this->db->set('date_updated', 'NOW()', FALSE);
		$this->db->where('su_id', $key);
		$exc_user = $this->db->update('sys_users');
		
		if ($exc_user){
			
			return TRUE;	
		
		}else{	return FALSE;	}
		 
	}

	public function num_disableUser($para){

		for($i=0;$i<count($para);$i++){
			
			$this->disableUser($para[$i]);
																									
		}
		
		return TRUE;
		
	}

	public function deleteUser($key=''){
		
		$sqlDelUser = "DELETE FROM sys_users WHERE su_id='{$key}';";
		$excDelUser = $this->db->query($sqlDelUser);
		
		$sqlDelPerm = "DELETE FROM sys_users_permissions WHERE su_id='{$key}';";
		$excDelPerm = $this->db->query($sqlDelPerm);
				
		if($excDelUser && $excDelPerm) { return TRUE; }else { return FALSE; }
		
	}

	public function deleteIssue($key=''){
		
		$sqlDelIssue = "DELETE FROM issue WHERE is_id='{$key}';";
		$excDelIssue = $this->db->query($sqlDelIssue);
				
		if($excDelIssue) { return TRUE; }else { return FALSE; }
		
	}
	
	public function num_deleteUser($para){
		
		for($i=0;$i<count($para);$i++){
			
			$this->deleteUser($para[$i]);
																									
		}
		
		return TRUE;
		
	}

	public function enableProject($key=''){
		
		$this->db->set('enable', '1');
		$this->db->set('date_updated', 'NOW()', FALSE);
		$this->db->where('pr_id', $key);
		$exc_project = $this->db->update('project');
		
		if ($exc_project){
			
			return TRUE;	
		
		}else{	return FALSE;	}
		 
	}

	public function num_enableProject($para){
		
		for($i=0;$i<count($para);$i++){
			
			$this->enableProject($para[$i]);
																									
		}
		
		return TRUE;
		
	}

	public function disableProject($key=''){
		
		$this->db->set('enable', '0');
		$this->db->set('date_updated', 'NOW()', FALSE);
		$this->db->where('pr_id', $key);
		$exc_project = $this->db->update('project');
		
		if ($exc_project){
			
			return TRUE;	
		
		}else{	return FALSE;	}
		 
	}

	public function num_disableProject($para){

		for($i=0;$i<count($para);$i++){
			
			$this->disableProject($para[$i]);
																									
		}
		
		return TRUE;
		
	}

	public function deleteProject($key=''){
		
		$sqlDelProject = "DELETE FROM project WHERE pr_id='{$key}';";
		$excDelProject = $this->db->query($sqlDelProject);
		
		if($excDelProject) { return TRUE; }else { return FALSE; }
		
	}
	
	public function num_deleteProject($para){
		
		for($i=0;$i<count($para);$i++){
			
			$this->deleteProject($para[$i]);
																									
		}
		
		return TRUE;
		
	}

	public function ShowUser($key=''){
		
		$sqlSel = "SELECT * FROM sys_users WHERE su_id='{$key}';";
		$query = $this->db->query($sqlSel);
		$result = $query->result_array();
		
		if($query->num_rows()!=0) {
			
            return $result[0];
        }else { 
		
            return FALSE;
        }
		
	}
		
	public function searchUser($searchTerm=''){
		
		
		 $this->db->select('*');
		 $this->db->from('sys_users');
		 $this->db->where('sug_id !=', '1');
		 $this->db->like('username',$searchTerm);
		 $this->db->or_like('firstname',$searchTerm);
		 $this->db->or_like('lastname',$searchTerm);
		 $this->db->or_like('email',$searchTerm);
		 
		 $query = $this->db->get();
		 
		 return $query->result_array();
		
	}
	
	public function getUser($str){
		
        $this->db->where('username', $str);
        $query = $this->db->get('sys_users');
        
		if($query->num_rows() > 0){
			
			return FALSE;
		}else{
			
			return TRUE;	
		}
		
    }	

	public function AddUserGroup($name='',$enable='1'){
		
		$sqlIns = "INSERT INTO sys_user_groups SET name='{$name}', enable='{$enable}', date_created=NOW();";
		$excIns = $this->db->query($sqlIns);
		
		if($excIns){ return TRUE; }else{ return FALSE; }
		
		
	}

	public function EditUserGroup($key='',$name='',$enable='1'){
		
		$sqlEdt = "UPDATE sys_user_groups SET name='{$name}', enable='{$enable}', date_created=NOW() WHERE sug_id='{$key}';";
		$excEdt = $this->db->query($sqlEdt);
		
		if($excEdt){ return TRUE; }else{ return FALSE; }
		
		
	}

	public function DeleteUserGroup($key=''){
		
		$sqlDel = "DELETE FROM sys_user_groups WHERE sug_id='{$key}';";
		$excDel = $this->db->query($sqlDel);
		
		$sqlDel = "DELETE FROM sys_users_groups_permissions WHERE sug_id='{$key}';";
		$excDel = $this->db->query($sqlDel);
		
		if($excDel) { return TRUE; }else { return FALSE; }
		
	}

	public function ShowUserGroup($key=''){
		
		$sqlSel = "SELECT * FROM sys_user_groups WHERE sug_id='{$key}';";
		$query = $this->db->query($sqlSel);
		$result = $query->result_array();
		
		if($query->num_rows()!=0) {
			
            return $result[0];
        }else { 
		
            return FALSE;
        }
		
	}

	public function AddRuleUserGroup($key,$rule=''){
		
		$sqlDel = "DELETE FROM sys_users_groups_permissions WHERE sug_id='{$key}';";
		$excDel = $this->db->query($sqlDel);
		
		if($rule!=''){
		
			foreach($rule as $r){
				
				$sqlIns = "INSERT INTO sys_users_groups_permissions SET sug_id='{$key}', spg_id='{$r}', date_created=NOW();";
				$excIns = $this->db->query($sqlIns);
				
				if($excIns){
					
					$strIns = TRUE;
					
				}else{ $strIns = FALSE;}
			}
		
		}else{ $strIns = TRUE; }
		
		return $strIns;
		
		
	}

	public function AddPrjAdmin($key,$prj=''){

		$sql = "UPDATE user_project SET pr_admin='No' WHERE su_id='{$key}';";
		$exc = $this->db->query($sql);
		
		if($prj!=''){
		
			foreach($prj as $r){

				$sqlEdt = "UPDATE user_project SET pr_admin='Yes' WHERE su_id='{$key}' AND pr_id='{$r}';";
				$excEdt = $this->db->query($sqlEdt);
				
				if($excEdt){
					
					$strIns = TRUE;
					
				}else{ $strIns = FALSE;}
			}
		
		}else{ $strIns = TRUE; }
		
		return $strIns;
		
		
	}

	public function AddRuleUser($key,$rule=''){
		
		$sqlDel = "DELETE FROM sys_users_permissions WHERE su_id='{$key}';";
		$excDel = $this->db->query($sqlDel);
		
		if($rule!=''){
		
			foreach($rule as $r){
				
				$sqlIns = "INSERT INTO sys_users_permissions SET su_id='{$key}', sp_id='{$r}', date_created=NOW();";
				$excIns = $this->db->query($sqlIns);
				
				if($excIns){
					
					$strIns = TRUE;
					
				}else{ $strIns = FALSE;}
			}
		
		}else{ $strIns = TRUE; }
		
		return $strIns;
		
		
	}

	## WHERE ID USER GROUP ##
	public function AddRuleUserDefault($key){
		
		$sqlSelUserG = "SELECT
		DISTINCT sup.su_id AS su_id
		FROM
		sys_users AS su
		LEFT JOIN sys_users_permissions AS sup ON sup.su_id = su.su_id
		WHERE 
		su.sug_id='{$key}';";


		$excSelUserG = $this->db->query($sqlSelUserG);
				
		foreach($excSelUserG->result_array() AS $r){
			
			$uId .= "'".$r['su_id']."',";								
		}
				
		$sqlDel = "DELETE FROM sys_users_permissions WHERE su_id IN ({$uId}FALSE);";
		$excDel = $this->db->query($sqlDel);
		
		if($excDel){
		
			$sqlSelPerDefault = "INSERT INTO sys_users_permissions 
			SELECT
			NULL AS sup_id,
			su.su_id,
			sp.sp_id,
			NOW()
			FROM
			sys_users_groups_permissions AS sugp
			LEFT JOIN sys_user_groups AS sug ON sug.sug_id = sugp.sug_id
			LEFT JOIN sys_users AS su ON su.sug_id = sug.sug_id
			LEFT JOIN sys_permission_groups AS spg ON spg.spg_id = sugp.spg_id
			LEFT JOIN sys_permissions AS sp ON sp.spg_id = spg.spg_id
			WHERE sugp.sug_id='{$key}'
			ORDER BY su.su_id ASC,sp.sp_id ASC";
			$excSelPerDefault = $this->db->query($sqlSelPerDefault);
		
			if($excSelPerDefault){
				
				return TRUE;
					
			}else{ return FALSE; }
		
		}else{
		
			return FALSE;	
		}
	
	}

	public function AddPermission($name='',$enable='1',$group, $cont){
		
		$sqlIns = "INSERT INTO sys_permissions SET name='{$name}', controller='{$cont}',enable='{$enable}', spg_id='{$group}',date_created=NOW(), date_updated=NOW();";
		$excIns = $this->db->query($sqlIns);
		
		if($excIns){ return TRUE; }else{ return FALSE; }
		
		
	}

	public function EditPermission($key='',$name='',$enable='1',$group, $cont){
		
		$sqlEdt = "UPDATE sys_permissions SET name='{$name}', controller='{$cont}', enable='{$enable}', spg_id='{$group}', date_updated=NOW() WHERE sp_id='{$key}';";
		$excEdt = $this->db->query($sqlEdt);
		
		if($excEdt){ return TRUE; }else{ return FALSE; }
		
		
	}
	
	public function DeletePermission($key=''){
		
		$sqlDel = "DELETE FROM sys_permissions WHERE sp_id='{$key}';";
		$excDel = $this->db->query($sqlDel);
		
		if($excDel) { return TRUE; }else { return FALSE; }
		
	}
	
	public function ShowPermission($key=''){
		
		$sqlSel = "SELECT * FROM sys_permissions WHERE sp_id='{$key}';";
		$query = $this->db->query($sqlSel);
		$result = $query->result_array();
		
		if($query->num_rows()!=0) {
			
            return $result[0];
        }else { 
		
            return FALSE;
        }
		
	}


	public function AddPermissionGroup($name='',$enable='1'){
		
		$sqlIns = "INSERT INTO sys_permission_groups SET name='{$name}', enable='{$enable}', date_created=NOW();";
		$excIns = $this->db->query($sqlIns);
		
		if($excIns){ return TRUE; }else{ return FALSE; }
		
		
	}

	public function EditPermissionGroup($key='',$name='',$enable='1'){
		
		$sqlEdt = "UPDATE sys_permission_groups SET name='{$name}', enable='{$enable}', date_created=NOW() WHERE spg_id='{$key}';";
		$excEdt = $this->db->query($sqlEdt);
		
		if($excEdt){ return TRUE; }else{ return FALSE; }
		
		
	}

	public function DeletePermissionGroup($key=''){
		
		$sqlDel = "DELETE FROM sys_permission_groups WHERE spg_id='{$key}';";
		$excDel = $this->db->query($sqlDel);
		
		if($excDel) { return TRUE; }else { return FALSE; }
		
	}

	public function ShowPermissionGroup($key=''){
		
		$sqlSel = "SELECT * FROM sys_permission_groups WHERE spg_id='{$key}';";
		$query = $this->db->query($sqlSel);
		$result = $query->result_array();
		
		if($query->num_rows()!=0) {
			
            return $result[0];
        }else { 
		
            return FALSE;
        }
		
	}
	
	public function editProfile($key,$p){
		
		$setUser = array('firstname' => $p['fname'],
				'lastname' => $p['lname'],
				'gender' => $p['sex'],
				'email' => $p['email'],
				'date_updated' => date('Y-m-d H:i:s')				
				);
		
		$this->db->where('su_id',$key);
		$excUp = $this->db->update('sys_users',$setUser);
		
		if($excUp){ return TRUE; }else{ return FALSE; }


		
	}	
	

    public function changePassword($key,$p){
		
        $this->db->where('su_id', $key);
        $this->db->where('password', base64_encode(trim($p['oldPwd'])));
        $query = $this->db->get('sys_users');
		
        if($query->num_rows()==1){
			
            $data = array('password' => base64_encode(trim($p['newPwd'])),
						'date_updated' => date('Y-m-d H:i:s')
			); 
            $this->db->where('su_id', $key);
            
			$query = $this->db->update('sys_users', $data); 
			
            if($query) {
				
                return TRUE;
            } else {
				
                return FALSE;
            }
        } else {
			
            return FALSE;// data not found
        }   
    }

     public function sendEmail($mailData){
 		


       	$this->load->library('email');

		$config['charset']='utf-8';
		$config['newline']="\r\n";
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from('issue@tbkk.co.th', 'Explanner Issue System');
		$this->email->to($mailData['mail_to']);
		// $this->email->cc('saranee@tbkk.co.th,tongjit@tbkk.co.th,wisitthammametha@gmail.com');
		$this->email->subject('You have new information from Explanner issue system!');
		// $this->email->message($mailData['mail_detail']);
		$this->email->message('Dear : '."\t\t\t".'K.'.$mailData['mail_dear']."<br><br><br>".'Project : '.$mailData['mail_prj']."<br><br>".'Description : '."\t\t\t".$mailData['mail_detail']."<br><br>".'Priority : '.$mailData['mail_priority']."<br><br>".'Issue Type : '.$mailData['mail_type']."<br><br>".'Open issue by : '.$mailData['mail_input_name']."<br><br><br>".'Please Check this issue in the system! --> '.'http://192.168.82.31/issue_management/issue/checkissue/'.$mailData['mail_is_id']); 
		$this->email->send();

		// echo $this->email->print_debugger();
		// exit();

        // ส่งจากอีเมล - ชื่อ
//         $this->email->from($mailData['mail_email'],$mailData['mail_name']); 
//         $this->email->to('wisit_t@tbkk.co.th','wisit_t'); // ส่งถึง
         
//         // หากต้องการส่งแบบให้มี cc หรือ bcc กำหนดตามด้านล่าง
// //        $this->email->cc('another@another-example.com');
// //        $this->email->bcc('them@their-example.com');        
         
//         // หากต้องการแนบไฟล์ กำหนดตามนี้
// //        $this->email->attach('/path/to/photo1.jpg');
// //        $this->email->attach('/path/to/photo2.jpg');
// //        $this->email->attach('/path/to/photo3.jpg');        
//         // หรือ แนบไฟล์แบบให้แสดงในอีเมลเลย เหมาะกับรูป
// //        $this->email->attach('image.jpg', 'inline');
//         // หรือ แนบไฟล์แบบกำหนด url เข้าไปตรงๆ เลย
// //        $this->email->attach('http://www.ninenik.com/filename.pdf');
//         // หรือแบบอัพโหลดไฟล์
// //        $this->email->attach($buffer, 'attachment', 'report.pdf', 'application/pdf');
 		
//         $this->email->subject($mailData['mail_title']); // หัวข้อที่ส่ง
//         $this->email->message($mailData['mail_detail']);  // รายละเอียด
//         return $this->email->send();   // คืนค่าการทำงานว่าเป็น true หรือ false      
         
    }
	
	
	
	/*
	

	public function resetpassword(){
		
		
		$this->db->where('m_usr', $this->session->userdata('sess_usr'));
		$this->db->where('m_email', trim($this->input->post('txt_email')));
        $query = $this->db->get('member');			
					
        if($query->num_rows()==1){
			
			$newPwd = $this->random_text(6);
			$rec = $query->row_array();
			$data = array('m_pwd' => base64_encode($newPwd), 'm_updated_at' => date('Y-m-d H:i:s')); 
            $this->db->where('m_usr', $this->session->userdata('sess_usr'));
            
			$excQuery = $this->db->update('member', $data); 
			
            if($excQuery) {
				
				//-----------Message-------------------
				$mail_msg = "<b>เรียน สมาชิก 3BBWiFi Report Manager</b><br><br>";
				$mail_msg .= "ขอแจ้งรายละเอียด New Reset Password คือ<br><br>";
				$mail_msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username : <font color='#0000FF'>".$this->session->userdata('sess_usr')."</font><br>";
				$mail_msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password : <font color='#0000FF'>".$newPwd."</font><br><br>";
				$mail_msg .= "เพื่อความปลอดภัยของท่าน กรุณาทำการเปลี่ยนรหัสผ่านใหม่อีกครั้ง เมื่อทำการเข้าสู่ระบบ<br><br>";
				$mail_msg .= "กรุณาตรวจสอบข้อมูล เพื่อความถูกต้องค่ะ<br><br>";
				$mail_msg .= "ขอบคุณค่ะ<br>";
	
				//------------------------------------------	
		
				$mail_subject = "Reset password 3BBWiFi Report Manager";

				$this->send_mail($rec['m_email'], $mail_msg, $mail_subject);
                return TRUE;
				
            } else {
				
                return FALSE;
            }
			
		}else{
			return FALSE;// data not found	
		}
	}


	public function send_mail($email_usr,$mail_msg,$mail_subject){ //mail server 3bb vas
	
	//require_once( $path ); // Mail Class
	require_once('phpmailer/class.phpmailer.php');
	//---------------------------------------------------------------------
	$mail = new PHPMailer();
			
	$mail->IsSMTP();			// send via SMTP
	$mail->Host = "110.164.76.67";	// SMTP servers
    $mail->SMTPAuth = true; 		// turn on SMTP authentication
	$mail->Username = "system"; 	// SMTP username
	$mail->Password = "acumenit"; 	// SMTP password
	$mail->Mailer = "smtp";
	$mail->Port = '10025';	
	$mail->Priority = 1;
	$mail->Encoding = "8bit";
	$mail->CharSet = "utf-8";
	$mail->SMTPDebug = 1;	
	$mail->From = "system@3bbwifibackoffice.com"; // ชื่อเมล์ที่ถูกส่งออกไป
	$mail->FromName = "3BBWiFi Backoffice";
	$mail->AddAddress($email_usr); 	// email1 = ชื่อเมล์ที่ต้องการรับ 

			
	$mail->WordWrap = 80; 	// set word wrap
	$mail->IsHTML(true); 	// send as HTML
			
	$mail->Subject  =  $mail_subject;
	$mail->Body = $mail_msg;
			
	//###  ตรวจสอบการส่งเมล์ ของ Mail Server
	if( !$mail->Send() ) {
		$sendFlag = 0;

	} else { 
		$sendFlag = 1;

	}	
	
	//###  Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	$mail->ClearAttachments();
	$mail->ClearCCs();
			
	unset($mail);
	$mail_msg = "";
	unset($mail_msg);
	
	}

	public function random_text($len){
		srand((double)microtime()*10000000);
		$chars = "acdfhjkmnprtuvwxyz123456789";
		$ret_str = "";
		$num = strlen($chars);
		
		for($i = 0; $i < $len; $i++){
			$ret_str.= $chars[rand()%$num];
			$ret_str.="";
		}
		return $ret_str;
	}*/


}
?>
