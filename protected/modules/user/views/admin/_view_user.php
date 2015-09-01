<?php
echo "<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->email."</td>";
	echo "<td>".$data->profile->first_name.' '.$data->profile->last_name."</td>";
	if($data->superuser==1)
	{
		echo "<td>Admin</td>";
	}
	else 
	{
		$modelado=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$data->id));
		echo "<td>".$modelado->empresas->rol."</td>";
	}

	
	echo "<td>";
		switch ($data->type) {
			case User::TYPE_INVITADO_EMPRESA:
				echo 'Invitado como empresa';
				break;
			case User::TYPE_INVITADO_CLIENTE:
				echo 'Invitado como cliente';
				break;
			case User::TYPE_USUARIO_SOLICITA:
				echo 'Usuario realizó solicitud';
				break;
		}
	echo "</td>";
	$user = User::model()->findByPk($data->quien_invita);
	echo "<td>".$user->email."</td>";
	/*echo "<td>";
		switch ($data->status) {
			case User::STATUS_NOACTIVE:
				echo 'Inactivo';
				break;
			case User::STATUS_ACTIVE:
				echo 'Activo';
				break;
			case User::STATUS_BANNED:
				echo 'Suspendido';
				break;
			default:
				echo 'Desconocido';
				break;
		}
	echo "</td>";*/
	
	if($data->status==1)
	{
		echo "<td> <div id='".$data->id."s"."'> Activo </div></td>";
	}
	else 
	{
		echo "<td> <div id='".$data->id."s"."'> Desactivo </div></td>";
	}
	$fecha= date("d-m-Y", strtotime($data->create_at));
	echo "<td>".$fecha."</td>";
	if($data->superuser!=1)
	{	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/profile/profile',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Ver Usuario </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/create',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Editar </a></li>';
			/*if($data->status==1){?>
				<li><a class="pointer" id=<?php echo $data->id;?> tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-remove"></i> Desactivar </a></li><?php }
			else{?><li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Activar </a></li><?php } 
			*/echo '
		</ul>
	    </div></td>
	    
	    		
			';
	 }
echo"</tr>";
	

?>


<script>

	function desactivarActivar(id)
	{
			
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('user/user/activarDesactivar') ?>",
             type: 'POST',
	         data:{
                    id:id,
                   },
	        success: function (data) {
				if(data==0)//lo contrario
				{
					$('#'+id).html('<i class="glyphicon glyphicon-ok"></i> Activar');
					$('#'+id+'s').html('Desactivo')
				}
				else
				{
					$('#'+id).html('<i class="glyphicon glyphicon-remove"></i> Desactivar');
					$('#'+id+'s').html('Activo')
				}
	       	}
	       })
		
	}

</script>