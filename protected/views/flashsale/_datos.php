<tr>
	<?php
		$inventario = Inventario::model()->findByPk($data->inventario_id);
		$producto = Producto::model()->findByPk($inventario->producto_id);
	?>
	
	<td><?php echo $producto->nombre; ?></td>
	<td><?php echo $inventario->id; ?></td>
	<td><?php echo $data->fecha_inicio; ?></td>
	<td><?php echo $data->fecha_fin; ?></td>
	<td><?php echo $data->cantidad; ?></td>
	
	<?php
		if($data->estado==0)
			echo "<td> Inactivo </td>";
		else
			echo "<td> Activo </td>";
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> 
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/flashsale/create',array('inventario_id'=>$data->inventario_id,'id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/flashsale/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li> 
		</ul>
        </div>
        
    </td>
      ';
	
	
	?>
	
	
	
</tr>