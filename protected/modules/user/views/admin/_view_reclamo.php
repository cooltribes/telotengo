<?php

echo"<tr>";
   	$comentarios = ReclamoComentarios::model()->findAllByAttributes(array('reclamo_id'=>$data->id));
   	
	echo "<td>".CHtml::link($data->orden_id, Yii::app()->baseUrl.'/orden/detalle/'.$data->orden_id, array('target'=>'_blank'))."</td>";
	echo "<td>".$data->orden_inventario->inventario->almacen->empresas->razon_social."</td>";
	echo "<td>".$data->comentario;
	if(count($comentarios)>0){
		foreach($comentarios as $comentario){
			echo "<p>- ".$comentario->comentario." | ".CHtml::link('(-)', Yii::app()->createUrl('/user/admin/eliminarComentario',array('id'=>$data->id)))."</p>";					
		}
	}
	echo "</td>";

	echo "<td>".$data->fecha."</td>";
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/orden/responderReclamo',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-plus"></i> Agregar comentario </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/eliminarReclamo',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar Reclamo </a></li>
		</ul>
        </div>
   	</td>	
			';
	
echo"</tr>";

?>