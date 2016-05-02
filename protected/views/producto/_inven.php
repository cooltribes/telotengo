<?php
#$model=Inventario::model()->findByAttributes(array('producto_id'=>$data->id));
echo"<tr>";
	if(isset($data['fecha_act']))
		echo "<td>".Funciones::invertirFecha($data['fecha_act'])."</td>";
	else
		echo "<td>".$data['fecha_act']."</td>";
	echo "<td>".$data['sku']."</td>";
	echo "<td>".$data['tlt_codigo']."</td>";
	$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$data['id'],'orden'=>'1'));
	
	if($imagen)
	{
		 $peque=Yii::app(true)->baseUrl.'/images/producto/'.$data['id'].'/'.$imagen->id."_thumb.jpg"; //OJO
		 $ruta=Yii::app(true)->baseUrl.$imagen->url;
		 echo "<td><a href='".$ruta."' target='_blank' >".CHtml::image( $peque,"Avatar",array('width'=>'60 px','style'=>'border-radius: 0px;'))."</a></td>";
	}
	else 
	{
		echo '<td><img src="http://placehold.it/60" align="Nombre del producto"/> </td>';
	}
		
	
	echo "<td>".$data['nombre']."</td>";
	
	echo "<td align='center'>".$data['cantidad']."</td>";
	
	echo "<td align='right' class='padding_right_small'>".Funciones::formatPrecio($data['precio'])."</td>";
	
	echo "<td>".Almacen::model()->findByPk($data['almacen_id'])->alias."</td>";
	?>