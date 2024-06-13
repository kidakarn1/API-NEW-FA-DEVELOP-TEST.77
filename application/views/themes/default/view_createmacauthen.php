<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Create Macauthen</div>
            <?php if($strValid==FALSE){ echo validation_errors(); } ?>
            <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?>
             <div id="horizontalTab" style="margin:35px 5px 15px 5px;">
                    <ul>
                        <li><a href="#createMacauthen">Create Macauthen</a></li>
                        <li><a href="#registerMacauthen">Register Macauthen</a></li>
                        <li><a href="#unRegisterMacauthen">UnRegister Macauthen</a></li>
                    </ul>
                    
             	<div id="createMacauthen">       
					<?php echo form_open('manage/createmacauthen', array("name"=>"frm_createmacauthen"));?>
                                                            
                          <div class="element">
                              <label for="name">Mac Address:</label>
                              <input type="text" name="txt_usr" size="40" maxlength="30" class="text" />
                          </div>
                          
                         <div class="element">
                              <label for="name">Serial&nbsp;&nbsp;(&nbsp;&nbsp;<input type="radio" id="firstPrefix" name="rad_serial" value="firstPrefix" checked="checked" />&nbsp;&nbsp;(Prefix)YYmm-USERNAME&nbsp;&nbsp;<input type="radio" id="customPrefix" name="rad_serial" value="customPrefix"  />&nbsp;&nbsp;Custom&nbsp;&nbsp;<input type="radio" id="randomPrefix" name="rad_serial" value="randomPrefix"  />&nbsp;&nbsp;Random&nbsp;&nbsp;):</label>
                              <input type="text" id="txt_custom_s" name="txt_custom_s" maxlength="50" class="text" style="display:none;" placeholder="Custom" />
                          </div>
                          <div class="element">
                              <label for="name">Prefix Serial:</label>
                              <input type="text" id="txt_prefix_s" name="txt_prefix_s" maxlength="16" class="text" placeholder="3 - 16 Characters" />
                          </div>
                          <script type="text/javascript">
        
                          $(function(){
                          
                              var dateExpiry = $('#txt_expirydate');
                                                   
                              dateExpiry.datepicker({ 
                                  dateFormat: 'yy-mm-dd'
                              });
                             
                          });
                          
                          </script>
                          <div class="element">
                              <label for="name">Expiry Date:</label>
                              <input name="txt_expirydate" type="text" id="txt_expirydate" placeholder="Please choose Expiry Date" size="35" maxlength="0"  />
                           
                          </div>
                         
                          <div class="element">
                              <button type="submit" class="add">Create Macauthen</button>
                              <input type="hidden" name="action" value="saveCreateMacauthen"  />                                    
                          </div>
                     
                      
                    <?php echo form_close();?>
            	</div>
            	
                <div id="registerMacauthen">
               	
            		<?php echo form_open('manage/createmacauthen', array("name"=>"frm_createmacauthen"));?>
                                                            
                          <!--<div class="element">
                              <label for="name">Username :</label>
                              <input type="text" name="txt_usr" size="40" maxlength="30" class="text <?php if(form_error('txt_usr')){ echo 'err';}?>" />
                          </div>
                          <div class="element">
                              <label for="name">Mac Address :</label>
                              <input type="text" name="txt_mac" size="40" maxlength="30" class="text <?php if(form_error('txt_mac')){ echo 'err';}?>" />
                          </div>
                         <div class="element">
                              <button type="submit" >Register Macauthen</button>
                              <input type="hidden" name="action" value="saveRegisterMacauthen"  />                                    
                          </div>-->
                     
                    <?php echo form_close();?>
                
                </div>
                
                
                <div id="unRegisterMacauthen">
               		<?php echo form_open('manage/createmacauthen', array("name"=>"frm_createmacauthen"));?>
                                                            
                         <!-- <div class="element">
                              <label for="name">Username :</label>
                              <input type="text" name="txt_usr" size="40" maxlength="30" class="text" />
                          </div>
                          <div class="element">
                              <label for="name">Mac Address :</label>
                              <input type="text" name="txt_mac" size="40" maxlength="30" class="text" />
                          </div>
                         <div class="element">
                              <button type="submit" >UnRegister Macauthen</button>
                              <input type="hidden" name="action" value="saveUnRegisterMacauthen"  />                                    
                          </div>-->
                     
                    <?php echo form_close();?>
            	</div>
                
            </div>
		</div>
	</div>
<!-- End main content -->
<script type="text/javascript">
	
	$(document).ready(function () {
		
		$('#horizontalTab').responsiveTabs({
			rotate: false,
			startCollapsed: 'accordion',
			collapsible: 'accordion',
			setHash: true,
			disabled: 0, /*[3,4]*/
			activate: function(e, tab) {
				$('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
			},
			activateState: function(e, state) {
				//console.log(state);
				$('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');
			}
		});

		$('#start-rotation').on('click', function() {
			$('#horizontalTab').responsiveTabs('startRotation', 1000);
		});
		$('#stop-rotation').on('click', function() {
			$('#horizontalTab').responsiveTabs('stopRotation');
		});
		$('#start-rotation').on('click', function() {
			$('#horizontalTab').responsiveTabs('active');
		});
		$('.select-tab').on('click', function() {
			$('#horizontalTab').responsiveTabs('activate', $(this).val());
		});
			
	
		$('#customPrefix').click(function(e) {
			
			$('#txt_custom_s').show();
			$('#txt_custom_s').prop('disabled',false);
			$('#txt_prefix_s').prop('disabled',true);
			
		});
		
		$('#firstPrefix').click(function(e) {
			
			$('#txt_custom_s').hide();
			$('#txt_custom_s').prop('disabled',false);
			$('#txt_prefix_s').prop('disabled',false);
		});	
		
		$('#randomPrefix').click(function(e) {
			
			$('#txt_custom_s').prop('disabled',true);
			$('#txt_prefix_s').prop('disabled',true);
		});
			
	});
	
</script>