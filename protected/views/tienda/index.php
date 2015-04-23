<!-- CONTENIDO ON -->
	
<?php // $this->breadcrumbs=array(	'Tienda',);?>
<div class="container">
<div class="row-fluid margin_top">
    
<?php

$categorias = Categoria::model()->findAll(); 
$marcas = Marca::model()->findAll();

?>
        <section class="col-md-2 no_padding_left" role="main">

            <h3 class="no_margin_bottom">Categorías</h3><hr class="no_margin_top"/> 
            <div>
                
                <ul class="no_list_style">
                     
          <?php        $categorias = Categoria::model()->findAllByAttributes(array('id_padre'=>0));
                        foreach ($categorias as $categoria) {
                            ?>
                            <?php echo '<li class="categorias-listado padre" id="'.$categoria->id.'"><a href="#">'.$categoria->nombre.'</a>'; ?>
                                <?php
                                $hijos = Categoria::model()->findAllByAttributes(array('id_padre'=>$categoria->id));
                                if(sizeof($hijos) > 0){
                                    ?>
                                    <ul class="subcategorias no_list_style" id="cat<?php echo $categoria->id; ?>" style="display:none;">
                                        <?php
                                        foreach ($hijos as $hijo) {
                                            ?>
                                            <?php echo '<li class="categorias-listado hijo" id="'.$hijo->id.'"><a href="#">'.$hijo->nombre.'</a></li>'; ?>
                                            <?php
                                        } 
                                        ?>
                                    </ul> 
                                    <?php
                                }?>
                                 </li>
                         <?php   }
                                ?>
                                   
                  <li class="categorias-listado todas" id="todas"><a href="#">Todas</a></li>         
                            
                </ul>  
            </div>
            <h3 class="no_margin_bottom">Precios</h3><hr class="no_margin_top"/> 
            <div>

                <ul class="col-md-offset-1 no_list_style no_margin_left">
                	<?php
                		 
                	echo'<li class="precio-listado padre" id="0"><a href="#">Hasta '.number_format($rangos[0]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[0]['count'].')</span></a></li>';
					echo'<li class="precio-listado padre" id="1"><a href="#">De '.number_format($rangos[1]["min"],0,",",".").' a '
						.number_format($rangos[1]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[1]['count'].')</span></a></li>';
					echo'<li class="precio-listado padre" id="2"><a href="#">De '.number_format($rangos[2]["min"],0,",",".").' a '
						.number_format($rangos[2]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[2]['count'].')</span></a></li>';
					echo'<li class="precio-listado padre" id="3"><a href="#">Más de '.number_format($rangos[3]["min"],0,",",".").' Bs. <span class="color12">('.$rangos[3]['count'].')</span></a></li>';
					echo'<li class="precio-listado todas" id="5"><a href="#">Todos los precios</a></li>';	
                	
                	?>
                </ul>  
        </div>  
            <h3 class="no_margin_bottom">Marcas</h3><hr class="no_margin_top"/> 
            <div id="marca-listado">

                <ul class="col-md-offset-1 no_margin_left"> 
                    <?php 
                	foreach($marcas as $marca){
                		#var_dump($marca->tieneActivos);
                		#Yii::app()->end();
						if($marca->tieneActivos)
							echo '<li class="marcas-listado padre" id="'.$marca->id.'"><a href="#">'.$marca->nombre.'</a></li>';
					}
					?>               
                </ul>     
            </div>                                             
        </section>

<!-- para filtrar por seleccion de categoria -->
        <?php
	Yii::app()->clientScript->registerScript('categoria',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('.categorias-listado').click(function(){
			id_categoria = $(this).attr('id');
           

			// ajaxRequest = $('#categorias-listado').serialize();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-productos-tienda',
				{
				type: 'POST',	
				url: '" . CController::createUrl('tienda/filtrar') . "',
				data: {'categoria':id_categoria}
				
				}
				
				)
				},
		
		
		300);
			if(!$(this).hasClass('hijo')){
                            $('.subcategorias').hide();
                            $('#cat'+$(this).attr('id')).show();
                        }   
		return false;
		});",CClientScript::POS_READY
	);
	
	?>
	
	<!-- para filtrar por seleccion de marca-->
        <?php
	Yii::app()->clientScript->registerScript('marca',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('.marcas-listado').click(function(){
			id_marca = $(this).attr('id');
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-productos-tienda',
				{
				type: 'POST',	
				url: '" . CController::createUrl('tienda/filtrar') . "',
				data: {'marca':id_marca}
				}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	?>
	
	<!-- para filtrar por seleccion de rangos de precio-->
        <?php
	Yii::app()->clientScript->registerScript('precios',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('.precio-listado').click(function(){
			id_precio = $(this).attr('id');
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-productos-tienda',
				{
				type: 'POST',	
				url: '" . CController::createUrl('tienda/filtrar') . "',
				data: {'precio':id_precio}
				}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);

	?>

        <div class="col-md-10 no_padding">
            <section class="row-fluid">

	        	<?php    
		        // barra de busqueda

		         $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		                                    'id'=>'form-busqueda',
		                                    'action'=>Yii::app()->createUrl('tienda/index'),
		                                    'htmlOptions' => array(
		                                        'enctype' => 'multipart/form-data',
		                                    ),
		                                )); 
		        ?>
		        <div class="row-fluid">
		            <div class="col-md-10" style="padding-left: 0;">
		                <!-- <input class="form-control no_radius_right" id="busqueda" name="busqueda" type="text" placeholder="¿Qué estás buscando?"> -->
		                <?php echo CHtml::textField('busqueda', '', 
		                                    array('id'=>'busqueda','placeholder'=>'¿Qué estás buscando?','class'=>'form-control no_radius_right'));
		                ?>
		                <?php echo CHtml::hiddenField('textobuscado', 'si', 
		                            array('id'=>'textobuscado')); ?>
		            </div>
		            <div class="col-md-2 pull-right" style="padding: 0;">
		                <!-- <a href="#" class="btn form-control btn-sigmablue no_radius_left" id="btn_search_event">Buscar</a> -->
		                <?php $this->widget('bootstrap.widgets.TbButton', array(
		                                'buttonType'=>'submit',
		                                'htmlOptions'=>array('class'=>'btn form-control btn-sigmablue no_radius_left'),
		                                'label'=>'Buscar',
		                            ));

		                $this->endWidget(); 

		                ?>                 
		            </div>
		        </div>


			<!-- PRODUCTOS ON -->
		    <?php

		    $template = '
				{items}
		      {pager}
		    ';

			$this->widget('zii.widgets.CListView', array(
			    'id'=>'list-productos-tienda',
			    'dataProvider'=>$dataProvider,
			    'itemView'=>'_datos',
			    'afterAjaxUpdate'=>" function(id, data) {	    				
								} ",
			    'template'=>$template,
			    'pager'=>array(
						'header'=>'',
						'htmlOptions'=>array(
						'class'=>'pagination pagination-right',
					)
					),
			));    

			
			?>
			<!-- PRODUCTOS OFF --> 
            </section>
        </div>

    </div>
</div>


<!-- CONTENIDO OFF -->