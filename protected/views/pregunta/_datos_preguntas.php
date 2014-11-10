<?php

echo"<tr>";
	
	$usuario = User::model()->findByPk($data['users_id']);
   	$producto = Producto::model()->findByPk($data['producto_id']);
   	
	echo "<td>".$producto->nombre."</td>";
	echo "<td>".$data['pregunta']."</td>";
	
	$respuestas = Respuesta::model()->findAllByAttributes(array('pregunta_id'=>$data['id']));
	
	echo "<td>";
				
	if(count($respuestas)>0){
		foreach($respuestas as $respuesta){ 
			echo "<p>- ".$respuesta->comentario."</p>";					
		}
	}
	else{
		echo "Aún sin respuestas.";	
	}
	
	echo "</td>";
	
	echo "<td>".$usuario->profile->first_name." ".$usuario->profile->last_name."</td>";
   	echo "<td>".date('d/m/Y H:i:s',strtotime($data['fecha']))."</td>";
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/detalle',array('id'=>$producto->id)).'" ><i class="glyphicon glyphicon-search"></i> Ver Producto </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/respuesta/create',array('id'=>$data['id'])).'" ><i class="glyphicon glyphicon-plus"></i> Aportar Respuesta </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/respuesta/listadotienda',array('id'=>$data['id'])).'" ><i class="glyphicon glyphicon-th-large"></i> Manejar Respuestas </a></li>
		</ul>
        </div>
   	</td>	
			';
	
echo"</tr>";

?>