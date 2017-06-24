<p><?php echo anchor('bills/create', 'Create Bill', 'class="btn btn-lg btn-primary btn-block"'); ?></p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th class="align-right">Due</th>
			<th class="align-right">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$bills_total=0;
			$income_total=$this->session->userdata('income');
			
			if(empty($bills)){
		?>
			<tr>
				<td colspan="3">No bills found.  <?php echo anchor('bills/create', 'Click here to create one.'); ?></td>
			</tr>
		<?php
			}else{
				foreach($bills as $bill){
					$month='month'.date('n');
					if($bill['month']!="Y" or ($bill['month']=="Y" and $bill[$month]=="CHECKED")){
						$bills_total=$bills_total+$bill['amount'];
		?>
			<tr>
				<td><?php echo anchor('bills/view/'.$bill['bill_id'], $bill['name']); ?></td>
				<td class="align-right"><?php echo anchor('bills/view/'.$bill['bill_id'], $bill['day']); ?></td>
				<td class="align-right"><?php echo anchor('bills/view/'.$bill['bill_id'], $bill['amount'], 'class="currency"'); ?></td>
			</tr>
		<?php
					}
				}
			}
		?>
	</tbody>
</table>

<p class="center"><?php echo anchor('bills/all', 'View All Bills', 'class="btn btn-block btn-lg btn-warning"'); ?></p>

<hr/>

<table class="table table-striped">
	<thead>
		<tr>
			<th colspan="3">Monthly Summary ( <?php echo date('m/Y'); ?> )</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Total Income:</td>
			<td class="align-right currency"><?php echo $income_total; ?></td>
		</tr>
		<tr>
			<td>Total Payments:</td>
			<td class="align-right currency"><?php echo $bills_total; ?></td>
		</tr>
		<tr>
			<td>Total Remainder:</td>
			<?php
				$remainder=$income_total-$bills_total;
				$remainder_class="green";
				if($remainder<0){
					$remainder_class="red";
				}
			?>
			<td class="align-right currency text-<?php echo $remainder_class; ?>"><?php echo $remainder; ?></td>
		</tr>
	</tbody>
</table>

<hr/>

<table class="table table-striped">
	<thead>
		<tr>
			<th colspan="3">YTD Summary ( 01/01/<?php echo date('Y'); ?> - <?php echo date('m/d/Y'); ?> )</th>
		</tr>
	</thead>
	<tbody>
		<?php $month=date('m'); ?>
		<tr>
			<td>Total Income:</td>
			<td class="align-right currency"><?php echo $income_total_ytd=$income_total*$month; ?></td>
		</tr>
		<tr>
			<td>Total Payments:</td>
			<td class="align-right currency"><?php echo $bills_total_ytd=$bills_total*$month; ?></td>
		</tr>
		<tr>
			<td>Total Remainder:</td>
			<?php
				$remainder=$income_total_ytd-$bills_total_ytd;
				$remainder_class="green";
				if($remainder<0){
					$remainder_class="red";
				}
			?>
			<td class="align-right currency text-<?php echo $remainder_class; ?>"><?php echo $remainder; ?></td>
		</tr>
	</tbody>
</table>