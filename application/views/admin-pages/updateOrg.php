<html>
<head>
</head>
<body>
<table>
<tr>
<td><?php echo form_label('Organization Name');?></td>
<td><?php echo form_input(array(
              'name'        => 'name',
              'id'          => 'name',
              'maxlength'   => '50',
              'size'        => '35',
              'value'=>$name
            ));?></td>
</tr>
<tr>
<td><?php echo form_label('Address');?></td>
<td><?php echo form_textarea(array(
              'name'        => 'addr',
              'id'          => 'addr',
	      'size'        => '35',
              'maxlength'   => '50',
               'value' => $address
            ));?></td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
</table>
</body>
</html>