<tr>
	<?php
	$profile = $data->profile;
	
	$empresahas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->id));
	$empresa = Empresas::model()->findByPk($empresahas->empresas_id);
	?>
	
	<td><?php echo $data->username; ?></td>
	<td><?php echo $profile->first_name." ".$profile->last_name; ?></td>
	<td><?php echo $profile->cedula; ?></td>
	<td><?php echo $profile->telefono; ?></td>
	<td><?php echo $empresa->razon_social; ?></td>
	<td><?php echo $empresahas->rol; ?></td>
	
	<?php
		
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
	
	
	?>
	
	
	
</tr>