<?php echo form_open('bills/action'); ?>
<?php echo form_hidden('bill_id'); ?>

<h3><strong><?php echo $form_header; ?></strong></h3>

<div><?php echo form_label('Bill Name:','name'); ?></div>
<p><?php echo form_input('name','','class="form-control" maxlength="50" data-required data-label="Bill Name"'); ?></p>

<div><?php echo form_label('Bill Description:','description'); ?></div>
<div><i>Ex. Utilities - Electricity, Gas, Water</i></div>
<p><?php echo form_input('description','','class="form-control" maxlength="100"'); ?></p>

<div><?php echo form_label('Bill Amount:','amount'); ?></div>
<p><?php echo form_input('amount','','class="form-control" maxlength="15" data-required data-label="Bill Amount"'); ?></p>

<div><?php echo form_label('Day Due:','day'); ?></div>
<div><i>The day this bill will be due each month.</i></div>
<p><?php echo form_input('day','','class="form-control" maxlength="2" data-day data-label="Day Due"'); ?></p>

<div><?php echo form_label('Month(s) Due (Optional):'); ?></div>
<div><i>By default, bills automatically occur EVERY month.  Only use these options if your bill <strong>DOES NOT</strong> occur EVERY month.</i></div>
<div><i>If one or more of these options are selected, the bill will ONLY be displayed during the month(s) specified.</i></div>
<p>
<?php
	echo form_hidden('month');
	
	//Generate a checkbox for each month.
	for($i=1;$i<=12;$i++) echo form_checkbox('month'.$i,'','','data-month')." ".form_label(date('F', mktime(0,0,0,$i)), 'month'.$i)."&nbsp;&nbsp;";
?>
</p>

<p><?php echo form_submit('action',$form_button,'class="btn btn-lg btn-primary btn-block"'); ?></p>
<?php
	if($form_button=='Update Bill'){
?>
<p><?php echo form_submit('action','Delete Bill','class="btn btn-lg btn-danger btn-block" data-confirm="Are you sure you want to delete this record?"'); ?></p>
<?php
	}
?>

<p><?php echo anchor('bills', 'Cancel', 'class="btn btn-lg btn-warning btn-block"'); ?></p>

<?php echo form_close(); ?>
