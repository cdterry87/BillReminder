<?php echo form_open('users/action'); ?>

<h3><strong>Change Password</strong></h3>

<p><?php echo form_label('Password:','password'); ?></p>
<p><?php echo form_password('password','','class="form-control" data-required'); ?></p>

<p><?php echo form_label('Confirm Password:','password_confirm'); ?></p>
<p><?php echo form_password('password_confirm','','class="form-control" data-required data-label="Confirm Password"'); ?></p>

<p><?php echo form_submit('action','Change Password','class="btn btn-lg btn-primary btn-block"'); ?></p>

<p><?php echo anchor('bills', 'Cancel', 'class="btn btn-lg btn-warning btn-block"'); ?></p>

<?php echo form_close(); ?>
