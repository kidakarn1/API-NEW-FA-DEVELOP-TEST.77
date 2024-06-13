<!-- main content -->
	<div id="main">
		<div class="full_w">
			<div class="h_title">Create Account</div>
            	<?php if($strValid==FALSE){ echo validation_errors(); } ?>
                <?php if($this->session->flashdata('msgResponse') != ''){ echo $this->session->flashdata('msgResponse'); }?>
            	<!--Horizontal Tab-->
                <div id="horizontalTab" style="margin:35px 5px 15px 5px;">
                    <ul>
                        <li><a href="#tabOneAccount">Create One Account</a></li>
                        <li><a href="#tabNumberAccount">Create Number Account</a></li>
                        
                    </ul>
            
                    <div id="tabOneAccount">

						<?php echo form_open('manage/createaccount', array("name"=>"frm_createaccount"));?>
                                                    
                                	<div class="element">
                                   		<label for="name">Username&nbsp;&nbsp;(&nbsp;&nbsp;<input type="radio" id="customUsr" name="ran_usr" value="customUsr" checked="checked" />&nbsp;&nbsp;Custom&nbsp;&nbsp;<input type="radio" id="randomUsr" name="ran_usr" value="randomUsr" />&nbsp;Random&nbsp;&nbsp;):</label>
                                   		<input type="text" id="txt_usr" name="txt_usr" size="40" maxlength="16" class="text" placeholder="6 - 16 Characters" />
                                    </div>
                                    
                                    <div class="element">
                                    	<label for="name">Password&nbsp;&nbsp;(&nbsp;&nbsp;<input type="radio" id="customPwd" name="ran_pwd" value="customPwd" checked="checked" />&nbsp;&nbsp;Custom&nbsp;&nbsp;<input type="radio" id="randomPwd" name="ran_pwd" value="randomPwd" />&nbsp;Random&nbsp;&nbsp;):</label>
                                    	<input type="password" id="txt_pwd" name="txt_pwd" size="40" maxlength="16" class="text" placeholder="6 - 16 Characters" />
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
										var dateCreditExpiry = $('#txt_credit_expire');
										
										dateExpiry.datepicker({ 
											dateFormat: 'yy-mm-dd'
										});
										dateCreditExpiry.datepicker({ 
											dateFormat: 'yy-mm-dd'
										});
									});
									
									</script>
                                    <div class="element">
                                        <label for="name">Account Type:</label>&nbsp;&nbsp;(&nbsp;&nbsp;<input type="radio" name="rad_expire" id="rad_credit" value="credit" checked="checked"/>&nbsp;&nbsp;Credit&nbsp;&nbsp;<input type="radio" name="rad_expire" id="rad_date" value="date" />&nbsp;&nbsp;date&nbsp;&nbsp;):
                                        <input type="text" id="txt_credit" name="txt_credit" maxlength="4" placeholder="Credit Charge" />
                                        <input name="txt_expirydate" type="text" id="txt_expirydate" placeholder="Please choose Expiry Date" size="35" maxlength="0" style="display:none;" />
                                   	   
                                      
                                        <span id="word_expire">Expiry date:</span>
                                        <input type="text" id="txt_credit_expire" name="txt_credit_expire" maxlength="0" size="35" placeholder="Please choose Expiry Credit Date" />
                                        
                                    </div>
                                   
                                    <div class="element">
                                    	<button type="submit" class="add">Create Account</button>
                                        <input type="hidden" name="action" value="saveCreateAccount"  />                                    
                                    </div>
                               
                                
                        <?php echo form_close();?>

                    </div>
                    
                    <div id="tabNumberAccount">
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
		
		
		/* Form Create One Account */
		
			
		$('#customUsr').click(function(e) {
			
			$('#txt_usr').prop('disabled',false);
			
		});
		
		$('#randomUsr').click(function(e) {
			
			$('#txt_usr').prop('disabled',true);
			
		});
	
		$('#customPwd').click(function(e) {
			
			$('#txt_pwd').prop('disabled',false);
			
		});
		
		$('#randomPwd').click(function(e) {
			
			$('#txt_pwd').prop('disabled',true);
			
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
		
		
		$('#rad_credit').click(function(e) {
			$('#txt_credit').show();
			$('#txt_credit_expire').show();
			$('#img_calendar2').show();
			$('#word_expire').show();
			$('#txt_expirydate').hide();
			$('#img_calendar1').hide();
		});
		
		$('#rad_date').click(function(e) {
			$('#img_calendar1').show();
			$('#txt_expirydate').show();
			$('#txt_credit').hide();
			$('#txt_credit_expire').hide();
			$('#img_calendar2').hide();
			$('#word_expire').hide();
		});

	});
</script>