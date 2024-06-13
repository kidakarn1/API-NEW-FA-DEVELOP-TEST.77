<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Change Password</div>
             <?php if($strValid==FALSE){ echo validation_errors(); } ?>
             <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?>
             <?php echo form_open('manage/changepassword', array("name"=>"frm_changepassword"));?>
					<div class="element">
						<label for="name">Old Password<span class="red">(*)</span></label>
						<input name="txt_oldpwd" type="password" class="text <?php if(form_error('txt_oldpwd')){ echo 'err';}?>" value="<?php echo set_value('txt_oldpwd');?>" />
                    </div>
                    <div class="element">
                    
						<label for="name">New Password</label>
						<input name="txt_newpwd" type="password" class="text <?php if(form_error('txt_newpwd')){ echo 'err';}?>" value="<?php echo set_value('txt_newpwd');?>" />
					</div>
                    <div class="element">
						<label for="name">Confirm Password</label>
						<input name="txt_cfpwd" type="password" class="text <?php if(form_error('txt_cfpwd')){ echo 'err';}?>" value="<?php echo set_value('txt_cfpwd');?>" />
					</div>
					<div class="entry">
						<button type="submit" class="edit">Change Password</button>
                        <input type="hidden" name="action" value="changePassword"  />
					</div>
			<?php echo form_close();?>
		</div>
	</div>
<!-- End main content -->