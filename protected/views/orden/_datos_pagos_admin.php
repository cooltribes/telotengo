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
		
	<?php
	
	if($data->estado==0)
	{
		
		echo '<td>
	
		<div class="dropdown">
		<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> 
		<i class="icon-cog"></i> <b class="caret"></b>
		</a> 
	 
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/aceptarpago',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-ok"></i> Aceptar Pago </a></li>
				<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/rechazarpago',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-ban-circle"></i> Rechazar Pago </a></li>
			</ul>
	        </div>
	        
	    </td>
	      ';
	}
	else
		echo '<td> -- </td>'
	
	?>
	
	
	
</tr>