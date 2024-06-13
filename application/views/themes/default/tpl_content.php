<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="Content-Type" Content-Type="text/html; charset=utf-8" />
<title><?= $page_title;?></title>
<link rel="stylesheet" type="text/css" href="<?= base_url() . $css_url . '/'; ?>css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= base_url() . $css_url . '/'; ?>css/navi.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= base_url() . $css_url . '/'; ?>css/alerts.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= base_url() . $css_url . '/'; ?>css/menutab_style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?= base_url() . $css_url . '/'; ?>css/responsive-tabs.css" media="screen" />
<link rel="stylesheet" media="all" type="text/css" href="<?= base_url() . $asset_url . '/'; ?>js/jquerydatepicker/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?= base_url() . $asset_url . '/'; ?>js/jquerydatepicker/jquery-ui-timepicker-addon.css" />

<script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquery.responsiveTabs.js"></script>
<script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquerydatepicker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquerydatepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquerydatepicker/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript">
$(function(){
	$(".box .h_title").not(this).next("ul").hide("normal");
	$(".box .h_title").not(this).next("#home").show("normal");
	$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
});

function delDataAlert() {

	if(confirm("Do you want delete data ?")){
		
		return true;	
			 
	}else{
  	
		return false;
	}
}

</script>
<script type="text/javascript">

/*
	$(document).ready(function() {
				
		$("#alert1").click(function() {
			jAlert('error', 'This is the error dialog box with some extra text.', 'Error Dialog');
		});

		$("#alert2").click(function() {
			jAlert('warning', 'This is the warning dialog along with some <u>html</u>.', 'Warning Dialog');
		});

		$("#alert3").click(function() {
			jAlert('success', 'This is the success dialog.', 'Success Dialog');
		});

		$("#alert4").click(function() {
			jAlert('info', 'This is the info dialog.', 'Info Dialog');
		});

		$("#confirm").click(function() {
			jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
				jAlert('success', 'Confirmed: ' + r, 'Confirmation Results');
			});
		});

		$("#prompt").click(function() {
			jPrompt('Type something:', 'Prefilled value', 'Prompt Dialog', function(r) {
				if (r) alert('You entered ' + r);
			});
		});
	});
	*/	
</script> 
</head>
<body>
<div class="wrap">
<?= $page_header;?>

<div id="content">
	<?= $page_menu;?><script type="text/javascript" src="<?= base_url() . $asset_url . '/'; ?>js/jquery-2.1.4.min.js"></script>
    <?= $page_content;?>
    <div class="clear"></div>
</div>

<?= $page_footer;?>
</div>
</body>
</html>