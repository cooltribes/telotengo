<?php

echo"<tr>";
	$pregunta = Pregunta::model()->findByPk($data->pregunta_id);
	$usuario = User::model()->findByPk($data->users_id);

	echo "<td>".$usuario->profile->first_name." ".$usuario->profile->last_name."</td>";
	
	echo "<td>".$data->comentario."</td>";
	echo "<td>".date('d/m/Y H:i:s',strtotime($data->fecha))."</td>";
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/respuesta/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar Respuesta </a></li>
		</ul>
        </div>
   	</td>	
			';
	
echo"</tr>";

?>