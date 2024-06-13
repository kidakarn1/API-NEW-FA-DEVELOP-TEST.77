<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Add User</div>
                 <?php if($strValid==FALSE){ echo validation_errors(); } ?>
                 <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?> 
           		 <?php echo form_open('manage/addUser', array("name"=>"frm_createusr"));?>
					<div class="element">
						<label for="name">Username <span class="red">(*)</span></label>
						<input name="txt_usr" class="text <?php if(form_error('txt_usr')){ echo 'err';}?>" value="<?php echo set_value('txt_usr'); ?>" />
                    </div>
                    <div class="element">
						<label for="name">Password<span class="red">(*)</span></label>
						<input type="password" name="txt_pwd" class="text <?php if(form_error('txt_pwd')){ echo 'err';}?>" value="<?php echo set_value('txt_pwd'); ?>" />
					</div>
 					
					<div class="element">
						<label for="sel_group">User Groups <span class="red">(*)</span></label>						
						<?php
                                                            
                        $optName = array();
                        $optName['0'] = '-- Please Select Groups --';
                        
                        foreach($excLoadG->result() as $g){
                            
                            $optName[$g->sug_id] = $g->name;
                            
                            
                        }
                    
                        $selected = (set_value('sel_group')) ? set_value('sel_group') : '-- Please Select Groups --';
                        if(form_error('sel_group')){ $setErrSel = "class='err'"; }
                        echo form_dropdown('sel_group', $optName,  $selected, $setErrSel);


                        ?>
                            
					</div>
                   
                    <div class="element">
						<label for="name">Firstname</label>
						<input name="txt_fname" class="text <?php if(form_error('txt_fname')){ echo 'err';}?>" value="<?php echo set_value('txt_fname'); ?>" />
					</div>
                    <div class="element">
						<label for="name">Lastname</label>
						<input name="txt_lname" class="text <?php if(form_error('txt_lname')){ echo 'err';}?>" value="<?php echo set_value('txt_lname'); ?>" />
					</div>
					<div class="element">
						<label for="sex">Sex</label>
						<input type="radio" name="rad_sex" value="1" <?php echo set_radio('rad_sex', '1', TRUE); ?> /> Male <input type="radio" name="rad_sex" value="2" <?php echo set_radio('rad_sex', '2'); ?> /> Female
					</div>
					<div class="element">
						<label for="name">Email</label>
						<input name="txt_email" class="text <?php if(form_error('txt_email')){ echo 'err';}?>" value="<?php echo set_value('txt_email'); ?>" />
					</div>
					
					<div class="entry">
						<button type="submit" class="add">Save user</button>
                        <input type="hidden" name="action" value="saveUser"  />
					</div>
				<?php echo form_close();?>
		</div>
	</div>
<!-- End main content -->