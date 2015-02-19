<?php

echo"<tr>";
   	echo "<td>".$data->nombre."</td>";
	echo "<td>".date('d/m/Y', strtotime($data->fecha))."</td>"; 
	
	$has = WishlistHasProducto::model()->findAllByAttributes(array('wishlist_id'=>$data->id));
	
	echo "<td>".count($has)."</td>";
	
	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="glyphicon glyphicon-cog"></i> <b class="caret"></b>
	</a> 
	
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/wishlist/productos',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-search"></i> Ver productos </a></li>
			<li><a tabindex="-1" onclick="activarModal('.$data->id.')" ><i class="glyphicon glyphicon-cog"></i> Cambiar Nombre </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/wishlist/eliminar',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
		</ul>
        </div></td> 
       
			';
echo"</tr>";

// <li><a tabindex="-1" href="'.Yii::app()->createUrl('/wishlist/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Cambiar Nombre </a></li>
?>