<tr>
<?php 

    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
    							
    if($principal->getUrl()) 
    	$im = CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array());
   	else 
    	echo '<img src="http://placehold.it/100" width="100%">';
    							  
    echo " <td>".$im."</td>";
    
	echo " <td>".$data->codigo."</td>"; 
	
    $marca = Marca::model()->findByPk($data->marca_id);
	
	$inventarios = Inventario::model()->findAllByAttributes(array('producto_id'=>$data->id));
	
	$codigo="<p class='col-md-12'>Combinaciones: </p>"; 
	
	foreach($inventarios as $inventario){
		
		$caracteristicas = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario->id));	
		
		$codigo = $codigo."<div>";
		
		foreach($caracteristicas as $caracteristica){
			$carac_sql = CaracteristicasSql::model()->findByPk($caracteristica->caracteristica_id);
			
			$nombre = $carac_sql->nombre;
			$valor = $caracteristica->valor;
			
			$codigo = "<p>".$codigo.$nombre.": ".$valor.". ";
		}
		
		$codigo = $codigo."Cantidad: ".$inventario->cantidad."</p>
				<a href=".Yii::app()->baseUrl."/flashsale/create?inventario_id=".$inventario->id."
				class='btn btn-primary btn-sm'>Aplicar Venta Flash a esta combincación</a>
			</div>";
		
	}
		
	echo "<td class='row-fluid'><p class='col-md-12'><strong>".$data->nombre."</strong> por ".$marca->nombre."</p>
			".$codigo."		
		</td>";								
						
						# Descripción del producto: ".$data->descripcion."
   // echo ' <td><a href="'.Yii::app()->baseUrl.'/flashsale/create?producto_id='.$data->id.'" class="btn margin_top btn-default btn-sm">Aplicar Venta Flash a este producto</a></td>';

?>   
    							
</tr>