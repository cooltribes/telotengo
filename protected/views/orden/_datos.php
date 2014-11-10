<tr>
	<?php
		$hasInventario = OrdenHasInventario::model()->findByAttributes(array('orden_id'=>$data->id));
		$usuario = User::model()->findByPk($data->users_id);
		$inventario = Inventario::model()->findByPk($hasInventario->inventario_id);
		$almacen = Almacen::model()->findByPk($inventario->almacen_id);
		$empresa = Empresas::model()->findByPk($almacen->empresas_id);

	?>
	
	<td><?php echo $data->id; ?></td>
	<td><?php echo $data->fecha; ?></td>
	<td><?php echo $data->total; ?></td>
	<td><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></td>
	<td><?php echo $empresa->razon_social; ?>
	</td>
	<?php
		
		switch ($data->estado) {
	    case 1:
	        echo "<td>En espera de pago</td>"; 
	        break;
	    case 2:
	        echo "<td>En espera de confirmación</td>"; 
	        break;
	    case 3:
	        echo "<td>Pago Confirmado</td>";
	        break;
		case 4:
			echo "<td>Orden Enviada</td>";
			break;
		case 5:	
			echo "<td>Orden Cancelada</td>";
			break;
		case 6:
			echo "<td>Pago Rechazado</td>";
			break;
		case 7:
			echo "<td>Pago Insuficiente</td>";
			break;
		case 8:
			echo "<td>Entregado</td>";
			break;
		case 9:
			echo "<td>Orden Devuelta</td>";
			break;
		case 10:
			echo "<td>Parcialmente Devuelto</td>";
			break;	
		}

	?>
	
	<?php
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> 
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/detalle',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Ver en Detalle </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/verproductos',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-th-list"></i> Ver Artículos </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/cancelar',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-remove"></i> Cancelar Orden </a></li>  
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li> 
		</ul>
        </div>
        
    </td>
      ';
	
	
	?>
	
	
	
</tr>