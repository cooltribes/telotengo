<?php

$ima ='';
$producto = Producto::model()->findByPk($data->producto_id);

echo"<tr>";
	
	echo "<td>".$producto->nombre."</td>";

	$imaurl = $producto->mainimage->getUrl(array('type'=>"x90"));
	$ima = CHtml::image($imaurl, $producto->nombre); 

	//$ima = CHtml::image(Yii::app()->baseUrl.'/images/producto/'.$producto->id.'/'.$producto->id.'_thumb.jpg', $producto->nombre); 

	if(isset($ima))
   		echo "<td>".$ima."</td>";
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/user/enviarBolsa',array('producto_id'=>$producto->id,'user_id'=>$data->user_id)).'" ><i class="glyphicon glyphicon-shopping-cart"></i> Enviar producto al carrito</a></li> 
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/user/quitarfav',array('producto_id'=>$producto->id,'user_id'=>$data->user_id)).'" ><i class="glyphicon glyphicon-trash"></i> Quitar de Favorito</a></li> 
		</ul>
        </div></td>
		';
	
echo"</tr>";

?>