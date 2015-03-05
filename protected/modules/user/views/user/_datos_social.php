<tr>
	<?php
	
	$tipo = TipoRedes::model()->findByPk($data->tipo_id);
	?>

	<td><?php echo $tipo->nombre; ?></td> 
	<td><a href="<?php echo $data->valor; ?>" target="_blank"><?php echo $data->valor; ?></a></td>
	
	<?php
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> 
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/user/deletesocial',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li> 
		</ul>
        </div> 
    </td>
      ';
	
	?>

</tr>