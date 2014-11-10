<tr>
	<?php
	
	// $empresahas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->users_id));
	$empresa = Empresas::model()->findByPk($data->empresas_id);
	?>

	<td><?php echo $empresa->razon_social; ?></td>
	<td><?php echo $data->rol; ?></td>
	
	<?php
	/*	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php"> 
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/user/editrol',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Editar Rol </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/user/deleteuser',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li> 
		</ul>
        </div>
        
    </td>
      ';
	
	*/
	?>
	
	
	
</tr>