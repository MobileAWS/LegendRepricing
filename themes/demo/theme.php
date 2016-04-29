<!DOCTYPE html><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Mainframe - The complete PHP framework" />
	<meta name="keywords" content="" />
	<meta name="language" content="en" />
	<title>Mainframe - The complete PHP framework</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>themes/demo/css/mainframe-grid.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>themes/demo/css/mainframe-main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>themes/demo/css/styles.css?v=<?php echo $this->config->item('cjsuf');?>" media="screen" />
	<?php if (isset($includes)){echo $includes;} ?>
</head>
<body>
<div class="fixed12">
	<div class="grid_12">
		<?php echo $content; ?>
	</div>
</div>
</body></html>