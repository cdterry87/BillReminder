<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
			
		<title>MyBILLS</title>
		
		<!-- Bootstrap -->
		<link href="<?php echo base_url('public/bootstrap/3.3.4/css/bootstrap.min.css'); ?>" rel="stylesheet" />
		
		<!-- Styles -->
		<link href="<?php echo base_url('public/styles/login.css'); ?>" rel="stylesheet" />
		
		<!-- jQuery -->
		<script src="<?php echo base_url('public/jquery/1.11.2/jquery.min.js'); ?>"></script>
		
		<script>
			var base_url='<?php echo base_url(); ?>';
		</script>
	</head>
	<body>
		<div class="container">
			<div id="content">
				<h3><strong><?php echo $header; ?></strong></h3>
				
				<hr/>
				
				<div id="messages"></div>
				
				<?php $this->load->view($page); ?>
				
				<hr/>
				
				<p class="center">&copy; Chase Terry 2015</p>
			</div>
		</div>
		
		<!-- Bootstrap -->
        <script src="<?php echo base_url('public/bootstrap/3.3.4/js/bootstrap.min.js'); ?>"></script>
		
		<!-- Javascript -->
		<script src="<?php echo base_url('public/scripts/main.js'); ?>"></script>
	</body>
</html>