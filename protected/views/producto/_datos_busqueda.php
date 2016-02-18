<tr>
<?php

    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
	
    							
    if($principal)
	{
		$im = CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array("height"=>"65px"));
	} 
    	
   	else
	{
		$im= '<img src="http://placehold.it/65x65" height="65px">';
	} 
    	
    echo " <td>".$data->tlt_codigo."</td>"; 							  
    echo " <td>".$im."</td>"; 
    
		
	echo "<td><p><strong>".$data->nombre."</strong></p>

			<p>Descripción del producto: ".$data->descripcion."
			</p>
		</td>";								
								
    echo ' <td class="text_align_center">';
    if($data->aprobado&&$data->estado)
    echo'<a href="'.Yii::app()->baseUrl.'/producto/inventario/'.$data->id.'" class="margin_top btn btn-darkgray gray"><span class="glyphicon glyphicon-plus"></span> Agregar Inventario</a>'; 
    else{
        echo !$data->aprobado?"No aprobado<br/>":"";
        echo !$data->aprobado?"Inactivo":"";
    }
    echo'</td>';


?>   
    							
</tr>