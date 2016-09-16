<tr>
	<?php
		$hasInventario = OrdenHasInventario::model()->findByAttributes(array('orden_id'=>$data->id)); 
		$usuario = User::model()->findByPk($data->users_id);
		$empresa=Empresas::model()->findByPk($data->almacen->empresas_id);
	?>
	 
	<td><?php echo $data->id; ?></td>
	<td><?php echo date('d/m/Y',strtotime($data->fecha)); ?></td>
	<td><a href="<?php echo Yii::app()->createUrl('empresas/perfilVendedor/'.$empresa->id);?>"><?php echo $empresa->razon_social;?></a></td>
    
		<td> 

	<?php 
		 if(OrdenEstado::model()->findByAttributes(array('estado'=>1, 'orden_id'=>$data->id))) // si aprobo
		  {
		  	$usuario_id=OrdenEstado::model()->findByAttributes(array('estado'=>1, 'orden_id'=>$data->id))->user_id;
			echo User::model()->FindByPk($usuario_id)->profile->first_name." ".User::model()->FindByPk($usuario_id)->profile->last_name;
		  }
		 else 
		 {
			if(OrdenEstado::model()->findByAttributes(array('estado'=>2, 'orden_id'=>$data->id))) // si rechazo
		  	{
		  		$usuario_id=OrdenEstado::model()->findByAttributes(array('estado'=>2, 'orden_id'=>$data->id))->user_id;
				echo User::model()->FindByPk($usuario_id)->profile->first_name." ".User::model()->FindByPk($usuario_id)->profile->last_name;
		  	}
			else 
			{
				echo "-";
			} 
		 } 

		?>
	</td> 
	
	
	<td class="text-right padding_right"><?php echo Funciones::formatPrecio($data->monto); ?></td> 	
	<td class="text-right padding_right"><?php echo Funciones::formatPrecio(($data->monto*Yii::app()->params['IVA']['value'])+$data->monto); ?></td> 

	<td><?php echo $data->ultima_fecha('d/m/Y'); ?></td>
	<td class="<?php echo $data->estados($data->estado,'class'); ?>"><?php echo $data->estados($data->estado); ?></td> 
	<td><a href="<?php echo Yii::app()->createUrl('orden/detalle', array('id'=>$data->id));?>">Ver detalles </a></td>
	
	
	
	<?php		

	// <li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/verproductos',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-th-list"></i> Ver Artículos </a></li>

	/*echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> 
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  
 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/detalle',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Ver en Detalle </a></li>
			<li><a tabindex="-1" onclick="modal('.$data->id.')" href="#"><i class="glyphicon glyphicon-th-list"></i> Ver Artículos </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/cancelar',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-remove"></i> Cancelar Orden </a></li>  
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li> 
		</ul>
        </div>
        
    </td>
    ';*/
	?>

</tr>

