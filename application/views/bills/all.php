<p><?php echo anchor('bills/create', 'Create Bill', 'class="btn btn-lg btn-primary btn-block"'); ?></p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Due</th>
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
					$bills_total=$bills_total+$bill['amount'];
                    
                    $due=$bill['day'];
                    if($bill['month']=="Y"){
                        $due.=" (";
                        for($i=1;$i<=12;$i++){
                            if($bill['month'.$i]=="CHECKED"){
                                $due.=date('F', mktime(0, 0, 0, $i)).", ";
                            }
                        }
                        $due=rtrim($due, ', ').")";
                    }
		?>
			<tr>
				<td><?php echo anchor('bills/view/'.$bill['bill_id'], $bill['name']); ?></td>
				<td><?php echo anchor('bills/view/'.$bill['bill_id'], $due); ?></td>
				<td class="align-right"><?php echo anchor('bills/view/'.$bill['bill_id'], $bill['amount'], 'class="currency"'); ?></td>
			</tr>
		<?php
				}
			}
		?>
	</tbody>
</table>

<p class="center"><?php echo anchor('bills', 'View Less', 'class="btn btn-block btn-lg btn-warning"'); ?></p>

<hr/>

<table class="table table-striped">
	<thead>
		<tr>
			<th colspan="3">Bill Totals</th>
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