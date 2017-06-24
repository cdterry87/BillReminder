<?php echo form_open('users/authenticate'); ?>

<p class="alert alert-info">
	<b>Example:</b><br/>
	Username: <b>test</b><br/>
	Password: <b>test</b>
</p>

<div><?php echo form_label('Username:','username'); ?></div>
<p><?php echo form_input('username','','class="form-control"'); ?></p>

<div><?php echo form_label('Password:','password'); ?></div>
<p><?php echo form_password('password','','class="form-control"'); ?></p>

<p><?php echo form_checkbox('remember')." ".form_label('Remember Me', 'remember'); ?></p>

<p><?php echo form_submit('action','Sign In','class="btn btn-lg btn-primary btn-block"'); ?></p>
<p><?php echo anchor('users/register', 'Register', 'class="btn btn-lg btn-success btn-block"'); ?></p>

<?php echo form_close(); ?>
