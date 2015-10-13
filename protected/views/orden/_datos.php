<tr>
	<?php
		$hasInventario = OrdenHasInventario::model()->findByAttributes(array('orden_id'=>$data->id)); 
		$usuario = User::model()->findByPk($data->users_id);
	?>
	 
	<td><?php echo $data->id; ?></td>
	<td><?php echo $data->fecha; ?></td>
	<td><?php echo $data->empresa->razon_social; ?></td> 
	<td><?php echo "el que aprobo la orden"; ?></td> 
	<td><?php echo $data->monto; ?></td> 
	<td><?php echo $data->estados($data->estado); ?></td> 
	<td><a href="<?php echo Yii::app()->createUrl('orden');?>">Ver detalles </a></td>
	
	
	
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

<script>
function modal(id){

	$.ajax({ 
		type: "post",
		//'url' :'/site/orden/modalventas/'+id,
		'url' : '<?php echo $this->createUrl('orden/modalorden',array('id'=>$data->id)); ?>',
		data: { 'orden':id}, 
		'success': function(data){
			$('#productosOrden').html(data);
			$('#productosOrden').modal();
		},
		'cache' :false}); 

}
</script>