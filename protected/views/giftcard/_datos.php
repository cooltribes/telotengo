<tr>	 
	<td><?php echo $data->id; ?></td>
	<td><?php echo $data->inicio_vigencia; ?></td>
	<td><?php echo $data->fin_vigencia; ?></td>
	<td><?php echo $data->monto; ?></td>
	<td><?php $user = User::model()->findByPk($data->comprador); echo $user->email; ?></td>
	<td><?php echo $data->beneficiario; ?></td>
	<td><?php echo $data->getEstado(); ?></td>
	
	<?php echo '<td>
		<div class="dropdown">
			<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
				<i class="icon-cog"></i><b class="caret"></b>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a tabindex="-1" href="'.Yii::app()->createUrl('/Giftcard/reenviar',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-envelope"></i> Reenviar Mail </a></li>
				<li><a tabindex="-1" href="'.Yii::app()->createUrl('/Giftcard/inactivar',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Inactivar </a></li>
				<li><a tabindex="-1" href="'.Yii::app()->createUrl('/Giftcard/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
			</ul>
        </div>
	</td>'
  	?>
</tr>