<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Edit Profile</div>
             <?php if($strValid==FALSE){ echo validation_errors(); } ?>
             <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?>
             <?php echo form_open('manage/editprofile', array("name"=>"frm_editprofile"));?>
					<div class="element">
						<label for="name">Username <span class="red">(*)</span></label>
						<input name="txt_usr" class="text <?php if(form_error('txt_usr')){ echo 'err';}?>" value="<?php echo $recLoadUser['username'];?>" disabled="disabled" />
                    </div>
                    <div class="element">
                    
						<label for="name">Firstname</label>
						<input name="txt_fname" class="text <?php if(form_error('txt_fname')){ echo 'err';}?>" value="<?php echo $recLoadUser['firstname'];?>" />
					</div>
                    <div class="element">
						<label for="name">Lastname</label>
						<input name="txt_lname" class="text <?php if(form_error('txt_lname')){ echo 'err';}?>" value="<?php echo $recLoadUser['lastname'];?>" />
					</div>
					<div class="element">
						<label for="sex">Sex</label>
						<input type="radio" name="rad_sex" value="1" <?php if($recLoadUser['gender']=='male'){ echo 'checked="checked"';} ?> /> Male <input type="radio" name="rad_sex" value="2" <?php if($recLoadUser['gender']=='female'){ echo 'checked="checked"';} ?>/> Female
					</div>
					<div class="element">
						<label for="name">Email</label>
						<input name="txt_email" class="text <?php if(form_error('txt_email')){ echo 'err';}?>" value="<?php echo $recLoadUser['email'];?>" />
					</div>
					<div class="entry">
						<button type="submit" class="edit">Edit profile</button>
                        <input type="hidden" name="action" value="saveEditProfile"  />
					</div>
			<?php echo form_close();?>
		</div>
	</div>
<!-- End main content -->