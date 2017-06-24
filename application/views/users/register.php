<?php echo form_open('users/action'); ?>

<div><?php echo form_label('Username:','username'); ?></div>
<p><?php echo form_input('username','','class="form-control" maxlength="20" data-required'); ?></p>

<div><?php echo form_label('Password:','password'); ?></div>
<p><?php echo form_password('password','','class="form-control" data-required'); ?></p>

<div><?php echo form_label('Confirm Password:','password_confirm'); ?></div>
<p><?php echo form_password('password_confirm','','class="form-control" data-required data-label="Confirm Password"'); ?></p>

<div><?php echo form_label('First Name:','firstname'); ?></div>
<p><?php echo form_input('firstname','','class="form-control" maxlength="30" data-required data-label="First Name"'); ?></p>

<div><?php echo form_label('Last Name:','lastname'); ?></div>
<p><?php echo form_input('lastname','','class="form-control" maxlength="30"'); ?></p>

<div><?php echo form_label('Email:','email'); ?></div>
<p><?php echo form_input('email','','class="form-control" maxlength="100"'); ?></p>

<div><?php echo form_label('Monthly Income:','income'); ?></div>
<p><?php echo form_input('income','','class="form-control" maxlength="15"'); ?></p>

<br/>

<p><?php echo form_submit('action','Create Account','class="btn btn-lg btn-primary btn-block"'); ?></p>
<p><?php echo anchor('users/login', 'Cancel', 'class="btn btn-lg btn-warning btn-block"'); ?></p>

<?php echo form_close(); ?>
