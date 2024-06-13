<!-- menu side bar-->
<div id="sidebar">
	<?php 
	
	$resMenu = $this->backoffice_model->ShowMenu($this->session->userdata('sessUsrId'));

	foreach($resMenu as $m){
							
		echo '<div class="box">';
		echo '<div class="h_title">'.$m['g_name'].'</div>';
		echo '<ul id="home">';
			
			foreach($m['sub_menu'] as $sm){
				
				echo '<li class="b2"><a class="icon " href="'.base_url().$sm['link'].'">&#8250;&nbsp;'.$sm['name'].'</a></li>';
			}
			
		echo '</ul>';
		echo '</div>';		
		
	}
	
	
	?>

			<!--<div class="box">
				<div class="h_title">&#8250; Main control</div>
				<ul id="home">
					<li class="b1"><a class="icon view_page" href="<?php echo base_url().'manage';?>">Home</a></li>
                </ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Manage User Groups</div>
				<ul id="home">
					<li class="b2"><a class="icon report" href="<?php echo base_url().'manage/usergroup';?>">User Group</a></li>
				</ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Manage Users</div>
				<ul id="home">
					<li class="b2"><a class="icon add_user" href="<?php echo base_url().'manage/adduser';?>">Add User</a></li>
                    <li class="b2"><a class="icon config" href="<?php echo base_url().'manage/edituser';?>">Edit/Disable User</a></li>
				</ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Manage Permission</div>
				<ul id="home">
					<li class="b2"><a class="icon report" href="<?php echo base_url().'manage/permission';?>">Permissions</a></li>
					<li class="b2"><a class="icon report" href="<?php echo base_url().'manage/permissiongroup';?>">Permissions Group</a></li>
				</ul>
			</div>
			<div class="box">
				<div class="h_title">&#8250; Settings</div>
				<ul id="home">
					<li class="b1"><a class="icon config" href="<?php echo base_url().'manage/editprofile';?>">Edit Profile</a></li>
					<li class="b1"><a class="icon config" href="<?php echo base_url().'manage/changepassword';?>">Change Password</a></li>
                    
				</ul>
			</div>-->
</div>
<!-- End menu side bar -->