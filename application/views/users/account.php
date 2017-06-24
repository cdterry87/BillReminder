<?php echo form_open('users/action'); ?>

<h3><strong>Account Information</strong></h3>

<p><?php echo form_label('First Name:','firstname'); ?></p>
<p><?php echo form_input('firstname','','class="form-control" maxlength="30" data-required'); ?></p>

<p><?php echo form_label('Last Name:','lastname'); ?></p>
<p><?php echo form_input('lastname','','class="form-control" maxlength="30"'); ?></p>

<p><?php echo form_label('Email:','email'); ?></p>
<p><?php echo form_input('email','','class="form-control" maxlength="100"'); ?></p>

<p><?php echo form_label('Monthly Income:','income'); ?></p>
<p><?php echo form_input('income','','class="form-control" maxlength="15"'); ?></p>

<p><?php echo form_submit('action','Update Information','class="btn btn-lg btn-primary btn-block"'); ?></p>

<p><?php echo anchor('bills', 'Cancel', 'class="btn btn-lg btn-warning btn-block"'); ?></p>

<?php echo form_close(); ?>
