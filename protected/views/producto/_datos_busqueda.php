<tr>
<?php

    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
	
    							
    if($principal)
	{
		$im = CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array());
	} 
    	
   	else
	{
		$im= '<img src="http://placehold.it/65x65" width="100%">';
	} 
    	
    							  
    echo " <td>".$im."</td>"; 
    
		
	echo "<td><p><strong>".$data->nombre."</strong></p>

			<p>Descripción del producto: ".$data->descripcion."
			</p>
		</td>";								
								
    echo ' <td><a href="'.Yii::app()->baseUrl.'/producto/inventario/'.$data->id.'" class="margin_top btn btn-success btn-sm">Agregar Inventario</a></td>';


?>   
    							
</tr>