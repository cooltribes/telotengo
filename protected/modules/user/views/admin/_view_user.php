<?php
echo "<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->email."</td>";
	echo "<td>".$data->profile->first_name.' '.$data->profile->last_name."</td>";
	echo "<td>";
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
	echo "</td>";
	echo "<td>".$data->create_at."</td>";
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/profile/profile',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Ver Usuario </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/create',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/delete',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/cargarSaldo',array('id'=>$data->id)).'"><i class="glyphicon glyphicon-usd"></i> Cargar Saldo </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
		
echo"</tr>";

?>