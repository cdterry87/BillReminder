<?php
	$active=array(
		'create'=>'',
		'analytics'=>'',
		'account'=>'',
		'password'=>'',
	);
	$active[$this->system_page]='active';
?>
<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
		<li class="<?php echo $active['create']; ?>"><?php echo anchor('bills/create', 'Create Bill'); ?></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
		<li class="<?php echo $active['analytics']; ?>"><?php echo anchor('users/analytics', 'Analytics'); ?></li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" aria-expanded="false" role="button" data-toggle="dropdown"><?php echo $this->session->userdata('firstname')." ".$this->session->userdata('lastname'); ?> <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li class="<?php echo $active['account']; ?>"><?php echo anchor('users/account', 'My Account'); ?></li>
				<li class="<?php echo $active['password']; ?>"><?php echo anchor('users/password', 'Change Password'); ?></li>
				<li class="divider"></li>
				<li><?php echo anchor('users/logout', 'Sign Out'); ?></li>
			</ul>
		</li>
    </ul>
</div>
