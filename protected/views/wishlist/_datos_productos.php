<?php

echo"<tr>";

		$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->producto_id));
	    							
	    if($principal->getUrl()) 
	    	$im = CHtml::image(str_replace(".","_x90.",$principal->getUrl()), "Imagen ", array());
	   	else 
	    	echo '<img src="http://placehold.it/100" width="100%">';
	    							  
	    echo " <td>".$im."</td>";

	$producto = Producto::model()->findByPk($data->producto_id);

   	echo "<td>".$producto->nombre."</td>";

	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  
	
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/wishlist/enviarbolsa',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-shopping-cart"></i> Enviar producto al carrito </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/wishlist/eliminarproducto',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar Producto </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
echo"</tr>";

?>
