<article class="col-md-3">
      <div class="caja">
      	
<?php
	$prod = Producto::model()->findByPk($data['id']);
     $inventario_menor_precio = Inventario::model()->getMenor($data['id']);
    	                	
	//if($data->mainimage) // tiene imagen
   // {
    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data['id']));
    							
    if($principal->getUrl())
    	$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"240px", "width" => "100%"));
   	else 
    	echo '<img src="http://placehold.it/300x260" width="100%">';
    							  
    echo "<a href='".$prod->getUrl()."'>".$im."</a>";
    							
    $marca = Marca::model()->findByPk($data['marca_id']);
	
	$link = Yii::app()->baseUrl.'/marca/'.$marca->nombre;
    							
    echo '<h2> '.$data['nombre'].' <h4><small>por <a href="'.$link.'">'.$marca->nombre.'</a></small></h4></h2>';
    
	if($prod->hasFlashsale())
    	echo ' <p class="lead">Aplica oferta.</p>';
	
	/*
	if(strlen($data['descripcion']) > 45)
		echo "<p>".substr($data['descripcion'],0,40).' ... </p>';
	else
		echo '<p>'.$data['descripcion'].'</p>';
	*/
								
    echo '<span class="text-muted">Bs. '.($inventario_menor_precio->precio_tienda).' en tienda</span>';
    							
    echo '<h4 class="text-danger">Bs. '.$inventario_menor_precio->precio.' </h4>
    		<div class="row">
    			<a role="button" href="'.Yii::app()->baseUrl.'/bolsa/agregar/'.$data['id'].'" class="btn btn-xs btn-success btn-default">Comprar ahora »</a>
    		</div> ';
    

    ?>
    </div>
	</article>
