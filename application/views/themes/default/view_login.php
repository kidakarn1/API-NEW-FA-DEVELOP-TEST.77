<!-- content -->
	<div id="content">
		<div id="main">
			<div class="full_w">
				<?php
			   
					if($strLogin==FALSE){ echo validation_errors(); }
					if($this->session->flashdata('msgError') != ''){ echo $this->session->flashdata('msgError'); }

				 ?>
            	<?php echo form_open('login/checklogin');?>
					<label for="login">Username:</label>
					<input id="login" name="txt_usr" class="text" />
					<label for="pass">Password:</label>
					<input id="pass" name="txt_pwd" type="password" class="text" />
					<div class="sep"></div>
                    <input type="hidden" name="action" value="login"  />
					<button type="submit" class="ok">Login</button> <!--<a class="button" href="#">Forgotten password?</a>-->
				<?php echo form_close();?>
			</div>
			<div class="footer">&raquo; <a href="http://www.3bbwifi.com">3BB WiFi</a> | Admin Panel</div>
		</div>
	</div>
<!-- End content -->