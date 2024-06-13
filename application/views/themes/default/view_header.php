<!-- header -->
<div id="header">
		<div id="nav"></div>
		<div id="top">
			<div class="left">
				<p>Welcome, <strong><?php echo $this->session->userdata('sessUsr');?></strong> [ <a href="<?php echo base_url().'manage/logout';?>">logout</a> ]</p>
			</div>
			<div class="right">
				<div class="align-right">
					<p>Last login: <strong><?php if($this->session->userdata('sessLastacc')!=''){ echo date('d/m/Y H:i:s', strtotime($this->session->userdata('sessLastacc')));}else{ echo '-';}?></strong></p>
				</div>
			</div>
		</div>
		
</div>
<!-- End header -->