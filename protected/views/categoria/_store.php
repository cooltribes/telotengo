<article class="col-md-3">
      <div class="caja">
      	
<?php

    $inventario_menor_precio = Inventario::model()->getMenor($data['id']);
    	                	
    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data['id']));
    							
    if($principal->getUrl())
    	$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"240px", "width" => "100%"));
    
	
	echo CHtml::link($im,array('/producto/detalle/'.$data['id']));							  
  //  echo "<a href='".Yii::app()->baseUrl."/producto/detalle/".$data['id']."''>".$im."</a>";
    							
    $marca = Marca::model()->findByPk($data['marca_id']);
	
	$link = Yii::app()->baseUrl.'/marca/'.$marca->nombre;
    							
    echo '<h2> '.$data['nombre'].' <h4><small>por <a href="'.$link.'">'.$marca->nombre.'</a></small></h4></h2>';
		 						
    echo '<span class="text-muted">Bs. '.($inventario_menor_precio->precio_tienda).' en tienda</span>';
    							
    echo '<h4 class="text-danger">Bs. '.$inventario_menor_precio->precio.' </h4>
    		<div class="row">
    			<a role="button" href="'.Yii::app()->baseUrl.'/bolsa/agregar/'.$data['id'].'" class="btn btn-xs btn-success btn-default">Comprar ahora »</a>
    		</div> ';
    							
 
	/*
    <img src="http://placehold.it/300x240" width="100%">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus.</p>             
		<span class="text-muted">Bs. 5.000,00 En tienda</span>
		<h4 class="text-danger">Bs. 4.000,00</h4>
		<div class="row">
		<a role="button" href="#" class="btn btn-sm col-sm-offset-7 btn-success btn-default">Comprar ahora »</a> 
		</div>   
    */							
    
	

    ?>
    </div>
	</article>
