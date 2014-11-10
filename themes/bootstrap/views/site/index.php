<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/helper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/dropdown.vertical.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/themes/default/default.css');
?>

<div class="container" style="padding: 0 15px;">

       
    <div class="row">

          <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->


        <div class="col-md-10 col-md-push-2 main-content" role="main">
			
			
            <ul class="nav nav-tabs" id="myTab">
            	<li class="active"><a href="#home" data-toggle="tab">Home</a></li>
              	<li><a href="#computadores" data-toggle="tab">Computadores</a></li>
              	<li><a href="#monitores" data-toggle="tab">Monitores</a></li>
              	<li><a href="#cornetas" data-toggle="tab">Cornetas</a></li>
              	<li><a href="#impresoras" data-toggle="tab">Impresoras</a></li>
              	<li class="pull-right"> <span class="glyphicon  glyphicon-phone-alt"></span> Servicio al cliente:  (0800) 33441122 |  servicio@telotengo.com</li>
			</ul>
	
    		<div class="tab-content"> 
    			
    			<div class="tab-pane active" id="home">
                    <div class="container">
                        <img src="http://www.semaudiolabs.com/images/tec/tech_banner01.jpg" />
                    </div>
                </div> 
                
                <div class="tab-pane" id="computadores">
                    <div class="container">
                        <img src="http://www.avg-la.com/wp-content/themes/avg-latinoamerica/img/2013/banner-home-avg-is-2013-updated.png" />
                    </div>
                </div>
                
                <div class="tab-pane" id="monitores">
                    <div class="container">
                        <img src="http://www.lg.com/co/images/main/hero/banner-monitor-lcd.jpg" />
                    </div>
                </div>
                
               	<div class="tab-pane" id="cornetas">
                    <div class="container">
                        <img src="http://www.f-covers.com/cover/jl-audio-gotham-facebook-cover-timeline-banner-for-fb.jpg" />
                    </div>
                </div>
                
                <div class="tab-pane" id="impresoras">
                    <div class="container">
                        <img src="http://www.www8-hp.com/es/es/images/IPG_home_banner_tcm176-954532.jpg" />
                    </div>
                </div>
                
                <div class="tab-pane">
                    <div class="container">
                            <h1>Seccion computadores</h1>
                            <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
                            <p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
                    </div>
                </div> 
            </div>            
            <section class="row">
            	<?php            	
            	$prod = new Producto;
				$productos = $prod->front();
				
				foreach($productos as $produc)
				{
					$producto = Producto::model()->findByPk($produc);
					
                    $inventario_menor_precio = Inventario::model()->getMenor($producto->id);
                    ?>
    					<article class="col-md-3">
                    		<div class="caja"> 
                    		
                    		<?php 
    	                	
    	                	if($producto->mainimage) // tiene imagen
    	                	{
    	                		$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$producto->id));
    							
    							if($principal->getUrl())
    								$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"310","width"=>"310"));
    							else 
    								echo '<img src="http://placehold.it/300x240" width="100%">';
    							 
    							echo "<a href='".Yii::app()->baseUrl.'/producto/detalle/'.$producto->id."'>".$im."</a>";
    							
    							$marca = Marca::model()->findByPk($producto->marca_id);
    							
								if($producto->hasFlashsale()){
									$a = "marcas/".$marca->nombre;
									echo CHtml::link($marca->nombre,array($a)).'<p class="lead">Aplica oferta.</p>';
								}else{
									$a = "marcas/".$marca->nombre;
									echo CHtml::link($marca->nombre,array($a));
								}
								
    							echo '<h2> '.$producto->nombre.' </h2>';
    							
								/*if(strlen($producto->descripcion) > 45)
									echo "<p>".substr($producto->descripcion,0,40).' ... <br/>';
								else
									echo '<p>'.$producto->descripcion.'<br/>';
								*/
								
    		                    echo 'Bs. '.($inventario_menor_precio->precio_tienda).' en tienda</p>';
    							echo '<p>Bs. '.$inventario_menor_precio->precio.' <a role="button" href="'.Yii::app()->baseUrl.'/producto/detalle/'.$producto->id.'" class="btn btn-xs btn-success">Comprar ahora »</a>';
    							
    	                	}
    						?>
    	                	
    	                   	</div>
                      	</article>
    					<?php
    				    }
                	    ?>
  
                        <!--   
                        <article class="col-md-3">
                            <div class="caja"><img src="http://placehold.it/300x240" width="100%">
                                sony
                                <h2>Heading</h2>
                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus. <br/>
                                    Bs. 5.000,00 En tienda</p>
                                    <p>Bs. 4.200 <a role="button" href="#" class="btn btn-xs btn-success btn-default">Comprar ahora »</a>
                                </p>
                            </div>
                        </article>    
                        -->
                                                                             
            </section>

        </div>

        <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        <!-- COLUMNA IZQUIERDA (MENU) ON // -->

        <div class="col-md-2 col-md-pull-10 navegacion-principal" role="navigation">
            <h3>Departamentos</h3>
            <!-- <div id="menu-top">
                
            </div> -->

            <ul id="nav" class="dropdown dropdown-vertical">
                <?php
                $categorias = Categoria::model()->findAllByAttributes(array('id_padre'=>0));
                foreach ($categorias as $categoria) {
                    ?>
                    <li class="dir"><?php echo $categoria->nombre; ?>
                        <?php
                        $hijos = Categoria::model()->findAllByAttributes(array('id_padre'=>$categoria->id));
                        if(sizeof($hijos) > 0){
                            ?>
                            <ul>
                                <?php
                                foreach ($hijos as $hijo) {
                                    ?>
                                    <li><?php echo Chtml::link($hijo->nombre, Yii::app()->baseUrl.'/categorias'.'/'.$hijo->url_amigable, array()); ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>

            <!-- <nav>
                <ul class="nav nav-pills nav-stacked">
                    <li>

                        <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                        'label'=>'Libros',
                        'type'=>'primary',
                        'htmlOptions'=>array('data-title'=>'Libros', 'data-content'=>'<a href="#">Link 1</a><a href="#">Link 2</a>', 'rel'=>'popover'),
                        ));*/ ?>

                        <a href="#" class="link">Libros
                        <small>Impresos y digitales</small></a>
                    </li>
                    <li>
                        <a href="#">Peliculas
                        <small>Estrenos y clásicos</small></a>
                    </li>
                    <li>
                        <a href="#">Computadores
                        <small>Samsung, apple, hp</small></a>
                    </li>
                    <li>
                        <a href="#">Video juegos
                        <small>Cónsolas, controles,</small></a>
                    </li>
                    <li>
                        <a href="#">Juguetes
                        <small>Para 6 meses, 2 años...</small></a>
                    </li>
                    <li>
                        <a href="#">Deportes
                        <small>Bates, botas, pelotas</small></a>
                    </li>

                </ul>
            </nav> -->
            <!-- <a href="#" class="btn btn-info btn-block">Ayuda</a>
            <a href="#" class="btn btn-info btn-block">Preguntas frecuentes</a> -->
        </div>
        <!-- COLUMNA IZQUIERDA (MENU) OFF // -->
    </div>
     <!-- CONTENIDO OFF -->
</div>                                       
<script>
	 
	 $('.link').popover({
        'selector': '',
        'placement': 'right',
        'title': '<a href="home.html">University of Tennessee-Knoxville</a>',
        'content': 'Facilities Services Department 2233 Volunteer Boulevard, Room 203 Knoxville, TN 37996-3010',
        'html': 'true'
      });
	
	
</script>
