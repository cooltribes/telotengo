<tr>
<?php

    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
    							
    if($principal->getUrl()) 
    	$im = CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array());
   	else 
    	$im= '<img src="http://placehold.it/100" width="100%">';
    							  
    echo " <td>".$im."</td>";
    
	 echo " <td>".$data->codigo."</td>";
	
    $marca = Marca::model()->findByPk($data->marca_id);
		
	echo "<td><p><strong>".$data->nombre." por <small>".$marca->nombre."</small></strong></p>

			<p>Descripción del producto: ".(strlen($data->descripcion)<180?$data->descripcion:substr($data->descripcion,-180,180).'...')." ...
			</p>
		</td>";								
								
    echo ' <td><a href="'.Yii::app()->baseUrl.'/producto/inventario/'.$data->id.'" class="margin_top btn btn-info btn-sm">Vender este producto</a></td>';


?>   
    							
</tr>