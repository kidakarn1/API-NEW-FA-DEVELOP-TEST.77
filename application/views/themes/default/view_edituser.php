<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Edit/Disable User</div>
           	<?php if($strValid==FALSE){ echo validation_errors(); } ?>
             <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?>	
             <?php echo form_open('manage/edituser', array("name"=>"frm_editusr"));?>
				<div style="padding-top:10px;padding-left:10px;"><strong>Search :</strong> 
				<input name="strSearch" size="55" placeholder="... Username , Firstname , Lastname , Email ..." value="<?php echo $strSearch;?>" />&nbsp;<button type="submit">OK</button>
                <input type="hidden" name="action" value="searchUser" /></div>
				
                <?php if($todoSearch==FALSE){## Not Search ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Created</th>
                                <th scope="col" style="width: 65px;">Modify</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                        
                        <?php
                        
                        if($excLoadUser->num_rows() > 0){
                            
                             foreach ($excLoadUser->result() as $r){
                        
                        ?>
                            <tr>
                                <td class="align-center"><?php echo '<font color="#0000FF">'.$r->username.'</font>';?></td>
                                <td class="align-center"><?php echo '<font color="#0000FF">'.base64_decode($r->password).'</font>';?></td>
                                <td><?php echo $r->firstname;?></td>
                                <td><?php echo $r->lastname;?></td>
                                <td class="align-center"><?php if($r->enable=='1'){ echo '<font color="#009900">Enable</font>'; }else{ echo '<font color="#FF0000">Disable</font>'; };?></td>
                                <td class="align-center"><?php echo date('d/m/Y H:i:s', strtotime($r->date_created));?></td>
                                <td align="center">
                                    <a href="<?php echo base_url().'manage/edituser/detail/'.$r->su_id;?>" class="table-icon archive" title="Edit"></a>
                                    <a href="<?php echo base_url().'manage/edituser/rule/'.$r->su_id;?>" class="table-icon rule" title="Rule"></a>
                                    <?php 
									if($this->session->userdata('sessUsrId')!=$r->su_id){
									?>
                                    <a href="<?php echo base_url().'manage/edituser/delete/'.$r->su_id;?>" class="table-icon delete" title="Delete" onclick="return delDataAlert();"></a>
                                	<?php }else{ echo ''; } ?>
								</td>
                            </tr>
                        
                        <?php } }else{ ?>
                            <tr>
                                <td colspan="8" class="align-center">ไม่พบข้อมูลค่ะ</td>
                            </tr>
                        <?php } ?>    
                        </tbody>
                    </table>
                    <?php echo $this->pagination->create_links();?> 
                
               <?php }else{## Search ?> 
               
               		<table>
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Created</th>
                                <th scope="col" style="width: 65px;">Modify</th>
                            </tr>
                        </thead>
                            
                        <tbody>
                        
                        <?php
                        
                        if(count($getResult) > 0){
                            
                             foreach ($getResult as $r){
                        
                        ?>
                            <tr>
                                <td class="align-center"><?php echo '<font color="#0000FF">'.$r['username'].'</font>';?></td>
                                <td class="align-center"><?php echo '<font color="#0000FF">'.base64_decode($r['password']).'</font>';?></td>
                                <td><?php echo $r['firstname'];?></td>
                                <td><?php echo $r['lastname'];?></td>
                                <td class="align-center"><?php if($r['enable']=='1'){ echo '<font color="#009900">ใช้งาน</font>'; }else{ echo '<font color="#FF0000">ถูกระงับ</font>'; };?></td>
                                <td class="align-center"><?php echo date('d/m/Y H:i:s', strtotime($r['date_created']));?></td>
                                <td align="center">
                                    <a href="<?php echo base_url().'manage/edituser/detail/'.$r['su_id'];?>" class="table-icon archive" title="Edit"></a>
                                    <a href="<?php echo base_url().'manage/edituser/rule/'.$r['su_id'];?>" class="table-icon rule" title="Rule"></a>
                                    <?php 
									if($this->session->userdata('sessUsrId')!=$r->su_id){
									?>
                                    <a href="<?php echo base_url().'manage/edituser/delete/'.$r['su_id'];?>" class="table-icon delete" title="Delete" onclick="return delDataAlert();"></a>
                                	<?php }else{ echo ''; } ?>
                                </td>
                            </tr>
                        
                        <?php } }else{ ?>
                            <tr>
                                <td colspan="8" class="align-center">ไม่พบข้อมูลค่ะ</td>
                            </tr>
                        <?php } ?>    
                        </tbody>
                    </table>
                              
               <?php } ?>
                
           <?php echo form_close();?>
           
           <?php if($frmEdit==TRUE){ ?>  
           <?php echo form_open('manage/edituser/detail/'.$recLoadUser['0']['su_id'].'', array("name"=>"frm_editusr"));?>
					<div class="element">
						<label for="name">Username <span class="red">(*)</span></label>
						<input name="txt_usr" class="text <?php if(form_error('txt_usr')){ echo 'err';}?>" value="<?php echo $recLoadUser['0']['username'];?>" disabled="disabled" />
                    </div>
                    <div class="element">
						<label for="name">Password<span class="red">(*)</span></label>
						<input type="password" name="txt_pwd" class="text <?php if(form_error('txt_pwd')){ echo 'err';}?>" value="<?php echo base64_decode($recLoadUser['0']['password']);;?>" />
					</div>
 					
					<div class="element">
						<label for="sel_group">User Groups <span class="red">(*)</span></label>						
						<?php
                                                            
                        $optName = array();
                        $optName['0'] = '-- Please Select Groups --';
                        
                        foreach($excLoadG->result() as $g){
                            
                            $optName[$g->sug_id] = $g->name;
                            
                            
                        }
                    
                        $selected = ($recLoadUser['0']['sug_id']) ? $recLoadUser['0']['sug_id'] : '-- Please Select Groups --';
                        if(form_error('sel_group')){ $setErrSel = "class='err'"; }
                        echo form_dropdown('sel_group', $optName,  $selected, $setErrSel);


                        ?>						

                            
					</div>
                   
                    <div class="element">
                    
						<label for="name">Firstname</label>
						<input name="txt_fname" class="text <?php if(form_error('txt_fname')){ echo 'err';}?>" value="<?php echo $recLoadUser['0']['firstname'];?>" />
					</div>
                    <div class="element">
						<label for="name">Lastname</label>
						<input name="txt_lname" class="text <?php if(form_error('txt_lname')){ echo 'err';}?>" value="<?php echo $recLoadUser['0']['lastname'];?>" />
					</div>
					<div class="element">
						<label for="sex">Sex</label>
						<input type="radio" name="rad_sex" value="1" <?php if($recLoadUser['0']['gender']=='male'){ echo 'checked="checked"';} ?> /> Male <input type="radio" name="rad_sex" value="2" <?php if($recLoadUser['0']['gender']=='female'){ echo 'checked="checked"';} ?>/> Female
					</div>
					<div class="element">
						<label for="name">Email</label>
						<input name="txt_email" class="text <?php if(form_error('txt_email')){ echo 'err';}?>" value="<?php echo $recLoadUser['0']['email'];?>" />
					</div>
					<div class="element">
						<label for="status">Status</label>
						<input type="radio" name="rad_status" value="1" <?php if($recLoadUser['0']['enable']=='1'){ echo 'checked="checked"';} ?> /> Enable 
                        <input type="radio" name="rad_status" value="0" <?php if($recLoadUser['0']['enable']=='0'){ echo 'checked="checked"';} ?>/> Disable
					</div>
					<div class="entry">
						<button type="submit" class="edit">Edit user</button>
                        <input type="hidden" name="action" value="saveEditUser"  />
					</div>
			<?php echo form_close();?>
           <?php }?>
           
           <?php if($frmRule==TRUE){ ?> 
           <?php echo form_open('manage/edituser/rule/'.$recLoadUser['0']['su_id'].'', array("name"=>"frm_ruleusr"));?>
					 <div class="element" style="line-height:25px;">
                     
                        <?php 
                        
						echo '<label for="name">Permissions in User Group</label>';
						
                        foreach($excPerG->result() as $pg){ ?>
                            
                            <input type="checkbox" name="chkRid[]" value="<?php echo $pg->sp_id;?>" <?php if(in_array($pg->sp_id, $excRule)===true){ echo 'checked="checked"';}?> >&nbsp;<?php echo $pg->name;?><br/>
                            
                        <?php } ?>  
                        
                        <?php 
                        
						echo '<label for="name">Other Permissions</label>';
						
                        foreach($excOthRule->result() as $pg){ ?>
                            
                            <input type="checkbox" name="chkRid[]" value="<?php echo $pg->sp_id;?>" <?php if(in_array($pg->sp_id, $excRule)===true){ echo 'checked="checked"';}?> >&nbsp;<?php echo $pg->name;?><br/>
                            
                        <?php } ?>   
                                                    
                    </div>
					<div class="entry">
						<button type="submit" class="edit">Edit permission</button>
                        <input type="hidden" name="action" value="saveEditPermission"  />
					</div>
		   <?php echo form_close();?>
           <?php }?>
		</div>
	</div>
<!-- End main content -->