<?php
#$model=Inventario::model()->findByAttributes(array('producto_id'=>$data->id));
echo"<tr>";
	echo "<td>".$data['sku']."</td>";
	echo "<td>".$data['tlt_codigo']."</td>";
	$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$data['id'],'orden'=>'1'));
	
	if($imagen)
	{
		 $peque=Yii::app(true)->baseUrl.'/images/producto/'.$data['id'].'/'.$imagen->id."_thumb.jpg"; //OJO
		 $ruta=Yii::app(true)->baseUrl.$imagen->url;
		 echo "<td><a href='".$ruta."' target='_blank' > <img height='142' width='142' src='".$peque."' title='Haz Click encima para ver Imagen con detalle'/></a></td>";
	}
	else 
	{
		echo '<td><img src="http://placehold.it/100" align="Nombre del producto"/> </td>';
	}
		
	
	echo "<td>".$data['nombre']."</td>";
	
	echo "<td>".$data['cantidad']."</td>";
	
	echo "<td>".$data['precio']."</td>";
	
	echo "<td>".Almacen::model()->findByPk($data['almacen_id'])->alias."</td>";
	?>