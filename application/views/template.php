<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		
		<title>MyBILLS</title>
		
		<!-- Bootstrap -->
		<link href="<?php echo base_url('public/bootstrap/3.3.4/css/bootstrap.min.css'); ?>" rel="stylesheet" />
		
		<!-- Styles -->
		<link href="<?php echo base_url('public/styles/main.css'); ?>" rel="stylesheet" />
		
		<!-- jQuery -->
		<script src="<?php echo base_url('public/jquery/1.11.2/jquery.min.js'); ?>"></script>
		
		<script>
			var base_url='<?php echo base_url(); ?>';
		</script>
	</head>
	<body>
		<!-- Header -->
        <div id="header" class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                        <span class="sr-only">Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo anchor('/','MyBILLS','class="navbar-brand" alt="MyBILLS" title="MyBILLS"'); ?>
                </div>
                <?php $this->load->view('navigation'); ?>
            </div>
        </div>
		
		<!-- Content -->
		<div id="content">
			<div class="container">
				<div id="messages"></div>
				
				<?php $this->load->view($page); ?>
			</div>
		</div>
		
		<!-- Footer -->
		<div id="footer">
			<div class="container">
                <hr/>
                &copy; Chase Terry <?php echo date('Y'); ?>
            </div>
		</div>
		
		<!-- Bootstrap -->
        <script src="<?php echo base_url('public/bootstrap/3.3.4/js/bootstrap.min.js'); ?>"></script>
		
		<!-- Format Currency -->
		<script src="<?php echo base_url('public/formatcurrency/1.4.0/formatcurrency.min.js'); ?>"></script>
		
		<!-- Javascript -->
		<script src="<?php echo base_url('public/scripts/main.js'); ?>"></script>
	</body>
</html>