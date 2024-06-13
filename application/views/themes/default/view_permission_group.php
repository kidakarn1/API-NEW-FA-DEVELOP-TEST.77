<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Permission Groups</div>  
           		<div style="width:100%;display:inline;position:relative;">
                <?php if($strValid==FALSE){ echo validation_errors(); } ?>
                <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?>       
                <div style="width:40%;float:left;position:relative;">
                <table id="test">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 65px;">Modify</th>
                        </tr>
                    </thead>
                        
                    <tbody>
                    
                    <?php
                    
                    if($excLoadPerG->num_rows() > 0){
                         $i=1;	
                         foreach ($excLoadPerG->result() as $r){
                    	 
                    ?>
                        <tr>
                        	<td class="align-center"><?php echo $i;?></td>
                            <td class="align-center"><?php echo $r->name;?></td>
                            <td class="align-center"><?php if($r->enable=='1'){ echo '<font color="#009900">Enable</font>'; }else{ echo '<font color="#FF0000">Disable</font>'; }?></td>
                            <td align="center">
                                <a href="<?php echo base_url().'manage/permissiongroup/edit/'.$r->spg_id;?>" class="table-icon edit" title="Edit"></a>
                                <a href="<?php echo base_url().'manage/permissiongroup/delete/'.$r->spg_id;?>" class="table-icon delete" title="Delete" onclick="return delDataAlert();"></a>
                            </td>
                        </tr>
                    
                    <?php $i++;} }else{ ?>
                        <tr>
                            <td colspan="4" class="align-center">ไม่พบข้อมูลค่ะ</td>
                        </tr>
                    <?php } ?>    
                    </tbody>
                </table>
                </div> 
              	<div style="width:60%;float:left;position:relative;margin-top:15px;">
					               
                	<?php if(!empty($perDataEdit)){ ## Form Edit ?>
							
						<?php echo form_open('manage/permissiongroup/edit', array("name"=>"frm_editpermission"));?>
                            <div class="element" style="width:250px;">
                                <label for="name">Permission Name </label>
                                <input name="txt_name" class="text <?php if(form_error('txt_name')){ echo 'err';}?>" value="<?php echo $perDataEdit['name']; ?>" />
                            </div>
                            <div class="element">
                                <label for="status">Status</label>
                                <input type="radio" name="rad_status" value="1" <?php if($perDataEdit['enable']=='1'){ echo 'checked="checked"';}else{ echo set_radio('rad_status', '1', TRUE); }?> /> Enable 
                                <input type="radio" name="rad_status" value="0" <?php if($perDataEdit['enable']=='0'){ echo 'checked="checked"';}else{ echo set_radio('rad_status', '0');}?>/> Disable
                            </div>
                          
                            <div class="entry">
                                <button type="submit" class="edit" >Edit</button>
                                <input type="hidden" name="hdKid" value="<?php echo $perDataEdit['spg_id'];?>" />
                                <input type="hidden" name="hdConfirm" value="edit" />
                            </div>
                        <?php echo form_close();?>
                        	
					<?php }else{ ## Form Add ?>
                
						<?php echo form_open('manage/permissiongroup/add', array("name"=>"frm_addpermission"));?>
                            <div class="element" style="width:250px;">
                                <label for="name">Permission Name </label>
                                <input name="txt_name" class="text <?php if(form_error('txt_name')){ echo 'err';}?>" value="<?php echo set_value('txt_name'); ?>" />
                            </div>
                            <div class="element">
                                <label for="status">Status</label>
                                <input type="radio" name="rad_status" value="1" <?php echo set_radio('rad_status', '1', TRUE); ?> /> Enable 
                                <input type="radio" name="rad_status" value="0" <?php echo set_radio('rad_status', '0'); ?> /> Disable
                            </div>
                          
                            <div class="entry">
                                <button type="submit" class="add" >Add</button><input type="hidden" name="hdConfirm" value="add" />
                            </div>
                        <?php echo form_close();?>
                	
                    
                    <?php } ?>
                </div>
              </div>
              
                 
		</div>
	</div>
<!-- End main content -->