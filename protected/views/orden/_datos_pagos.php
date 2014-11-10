<tr>

	<td><?php echo $data->id; ?></td>
	<td><?php echo $data->nombre; ?></td>
	<td><?php echo $data->cedula; ?></td>
	<td><?php echo $data->monto; ?></td>
	<td><?php echo $data->fecha; ?></td>
	
	<?php
	
		if($data->estado==0){
			echo '<td> En espera </td>';
		}
		
		if($data->estado==1){
			echo '<td> Pago aceptado </td>';
		}
		
		if($data->estado==2){
			echo '<td> Pago rechazado </td>';
		}
	
	?>
	
	
	
</tr>