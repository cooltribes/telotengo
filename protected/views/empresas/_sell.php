<?php
$empresa_user = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$data->id));
$representante = User::model()->findByPk($empresa_user->users_id);

echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->rif."</td>";
	echo '<td>'.$data->razon_social.'</td>';
	
	switch ($data->estado)
	{
	case 1:
		echo "<td> Solicitado </td>";
	  	break;
	case 2:
		echo "<td> Aprobado </td>";
	  	break;
	case 3:
		echo "<td> Rechazado </td>";
	  	break;
	case 4:
		echo "<td> Suspendido </td>";
	  	break;
	}
	
	echo "<td>".$representante->profile->first_name.' '.$representante->profile->last_name."</td>";
	?>

	<td>
		<div class="dropdown">
			<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
				<i class="icon-cog"></i> <b class="caret"></b>
			</a> 

			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/detalles',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-book"></i> Detalles </a></li>
				<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/update',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
				<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/delete',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
				<?php
				switch ($data->estado) {
					case 1:
						?>
						<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/aprobar',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-ok"></i> Aprobar </a></li>
						<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/rechazar',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-ban-circle"></i> Rechazar </a></li>
						<?php
						break;
					case 2:
						?>
						<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/suspender',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-ban-circle"></i> Suspender </a></li>
						<li><?php echo CHtml::link('<i class="glyphicon glyphicon-plus"></i> Agregar sucursal', Yii::app()->baseUrl.'/almacen/create/id_empresa/'.$data->id, array()); ?></li>
						<li><?php echo CHtml::link('<i class="glyphicon glyphicon-th-large"></i> Ventas', Yii::app()->baseUrl.'/empresas/ventas/'.$data->id, array()); ?></li>
						<?php
						break;
					case 3:
						?>
						<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/aprobar',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-ok"></i> Aprobar </a></li>
						<?php
						break;
					case 4: 
						?>
						<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/aprobar',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-ok"></i> Activar </a></li>
						<?php
						break;
					default:
						# code...
						break;
				}
				?>
				<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/calificaciones',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-star"></i> Calificaciones </a></li>
				<li><a tabindex="-1" href="<?php echo Yii::app()->createUrl('/empresas/inventarios',array('id'=>$data->id)); ?>" ><i class="glyphicon glyphicon-list-alt"></i> Inventario </a></li>
			</ul>
		</div>
	</td>
	    
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>		
	<?php
	
echo "</tr>";
?>