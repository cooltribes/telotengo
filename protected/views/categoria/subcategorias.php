<!-- CONTENIDO ON -->
<div class="container margin_top">

	<!--<h1><?php echo $categoria->nombre; ?></h1><hr class="no_margin_top"/>-->
	<div class="row-fluid">
	    <div class="col-md-2 no_padding">
	        <h3 class="no_margin_bottom">Marcas</h3><hr class="no_margin_top"/> 
            <div id="marca-listado">

                <ul class="col-md-offset-1 no_margin_left"> 
                    <?php 
                    $marcas=Marca::model()->findAll();
                    foreach($marcas as $marca){

                        if($marca->tieneActivos)
                            echo '<li class="marcas-listado padre pointer" onclick="xmarca('.$marca->id.')" id="'.$marca->id.'">'.$marca->nombre.'</li>';
                    }
                    ?>               
                </ul>     
            </div>
             
            <h3 class="no_margin_bottom">Precios</h3><hr class="no_margin_top"/> 
            <div>

                <ul class="col-md-offset-1 no_list_style no_margin_left">
                    <?php
                         
                    echo $rangos[0]['count']>0?'<li class="precio-listado padre" onclick="xprecio(0,'.$rangos[0]["max"].')" id="0"><a href="#">Hasta '.number_format($rangos[0]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[0]['count'].')</span></a></li>':'';
                    echo $rangos[1]['count']>0?'<li class="precio-listado padre" onclick="xprecio('.$rangos[1]["min"].','.$rangos[1]["max"].')" id="1"><a href="#">De '.number_format($rangos[1]["min"],0,",",".").' a '
                        .number_format($rangos[1]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[1]['count'].')</span></a></li>':'';
                    echo $rangos[2]['count']>0?'<li class="precio-listado padre" onclick="xprecio('.$rangos[2]["min"].','.$rangos[2]["max"].')"  id="2"><a href="#">De '.number_format($rangos[2]["min"],0,",",".").' a '
                        .number_format($rangos[2]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[2]['count'].')</span></a></li>':'';
                    echo $rangos[3]['count']>0?'<li class="precio-listado padre" onclick="xprecio('.$rangos[3]["min"].','.$rangos[3]["max"].')"  id="3"><a href="#">Más de '.number_format($rangos[3]["min"],0,",",".").' Bs. <span class="color12">('.$rangos[3]['count'].')</span></a></li>':'';
                    echo'<li class="precio-listado todas" id="5"><a href="#">Todos los precios</a></li>';   
                    
                    ?>
                </ul>  
            </div> 
            
	    </div>
	    <div class="col-md-10 no_padding_right">
	        <div class="row-fluid">
	            <div class="col-md-12 no_padding no_margin">
	               <?php	echo '<img width="100%" src="'.Yii::app()->baseUrl.'/images/categoria/'.$categoria->imagen_url.'"/>';?>
	                
	            </div>
	            
	            <?php 
	            $hijos = Categoria::model()->findAllByAttributes(array('id_padre'=>$categoria->id));
	            
	            foreach($hijos as $hijo): ?>
                  <div class="col-md-4 no_padding no_margin">  
                      <a title="Ir a <?php echo $categoria->nombre; ?>" href="<?php echo Yii::app()->baseUrl."/categorias/".$hijo->url_amigable; ?>" target="_self">
                            <img width="100%" title="<?php echo $categoria->nombre; ?>" src="<?php echo Yii::app()->baseUrl."/images/categoria/".$hijo->imagen_url; ?>" alt="<?php echo $categoria->nombre; ?>" />
                      </a>
                  </div>    
                <?php endforeach;?>
	                
	        </div>
            
        </div>
	    
	    
	</div>
	

</div>
<script>
    function xmarca(id){
        alert(id);
        
    }
    function xprecio(min,max){
        console.log(min+" "+max);
    }
    
</script>

