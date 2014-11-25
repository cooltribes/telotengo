<?php
echo"<tr>";
	echo "<td>".$data->id."</td>";
	echo "<td>".$data->fecha."</td>";
	echo "<td>".$data->total."</td>";

	$user = User::model()->findByPk($data->user_id);
	$pago = DetalleOrden::model()->findByAttributes(array('ordenGC_id'=>$data->id,'estado'=>0)); 

	echo "<td>".$user->email."</td>";
   	echo "<td>".$pago->monto."</td>";
	echo "<td>".$pago->fecha."</td>";
	echo "<td>".$pago->confirmacion."</td>";
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/giftcard/aprobar',array('id'=>$pago->id)).'" ><i class="icon-cog"></i> Aprobar pago </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/giftcard/rechazar',array('id'=>$pago->id)).'" ><i class="icon-trash"></i> Rechazar pago </a></li>
		</ul>
        </div></td>    
    ';	
echo"</tr>";
?> 