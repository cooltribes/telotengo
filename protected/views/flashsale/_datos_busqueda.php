<tr>
<?php 

    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
    							
    if($principal->getUrl()) 
    	$im = CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array());
    							  
    echo " <td>".$im."</td>";
    echo " <td>".$data->codigo."</td>";

    $marca = Marca::model()->findByPk($data->marca_id);
	$inventario = Inventario::model()->findByAttributes(array('producto_id'=>$data->id)); // se supone que ahora hay uno solo
	
	$codigo = "<p>Cantidad: ".$inventario->cantidad."</p>
				<a href=".Yii::app()->baseUrl."/flashsale/create?inventario_id=".$inventario->id." class='btn btn-primary btn-sm'>
					Aplicar Venta Flash a este producto
				</a>";

	echo "<td class='row-fluid'><p class='col-md-12'><strong>".$data->nombre."</strong> por ".$marca->nombre."</p>
			".$codigo."		
		</td>";								
						
						# Descripción del producto: ".$data->descripcion."
   // echo ' <td><a href="'.Yii::app()->baseUrl.'/flashsale/create?producto_id='.$data->id.'" class="btn margin_top btn-default btn-sm">Aplicar Venta Flash a este producto</a></td>';

?>   
    							
</tr>