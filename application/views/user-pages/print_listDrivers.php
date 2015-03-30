<?php
set_time_limit(0);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=drivers.xls");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
?>
	<table class="table table-hover table-bordered">
	<tbody>
		<tr>
		<th>Name</th>
		<th>Landline Number</th>
		<th>Mobile Number</th>
		<th>Address</th>
		<th>District</th>
		</tr>
		<?php foreach ($values as $val): ?>
		<tr>
		<td><?php echo $val['name']; ?></td>
		<td><?php echo $val['phone']; ?></td>
		<td><?php echo $val['mobile']; ?></td>
		<td><?php echo $val['present_address'];?></td>
		<td><?php echo $val['district'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
	</table>