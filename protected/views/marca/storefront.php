<!-- CONTENIDO ON -->
<div class="container-fluid margin_top" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	$model->nombre,
);
?>

<?php

$categorias = Categoria::model()->findAll(); 
$marcas = Marca::model()->findAll();

?>

	<div class="row"> 
  	<!-- SIDE BAR DE FILTROS ON -->
	    <section class="col-md-2"  role="main">
        	<div>
                Categorias 
                <hr>
                <ul class="col-md-offset-1">
                	<li class="categorias-listado" id="todas"><a href="#">Todas</a></li>
                	<?php 
                	foreach($categorias as $categoria){
						echo '<li class="categorias-listado" id="'.$categoria->id.'"><a href="#">'.$categoria->nombre.'</a></li>';
					}
					?>
                </ul>  
            </div>
            <div>
                Precios
                <hr>
                <ul class="col-md-offset-1">
                	<?php
                		
                	echo'<li class="precio-listado" id="0"><a href="#">Hasta '.number_format($rangos[0]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[0]['count'].')</span></a></li>';
					echo'<li class="precio-listado" id="1"><a href="#">De '.number_format($rangos[1]["min"],0,",",".").' a '
						.number_format($rangos[1]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[1]['count'].')</span></a></li>';
					echo'<li class="precio-listado" id="2"><a href="#">De '.number_format($rangos[2]["min"],0,",",".").' a '
						.number_format($rangos[2]["max"],0,",",".").' Bs. <span class="color12">('.$rangos[2]['count'].')</span></a></li>';
					echo'<li class="precio-listado" id="3"><a href="#">Más de '.number_format($rangos[3]["min"],0,",",".").' Bs. <span class="color12">('.$rangos[3]['count'].')</span></a></li>';
					echo'<li class="precio-listado" id="5"><a href="#">Todos los precios</a></li>';	
                	
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
				'list-productos-store-marca',
				{
				type: 'POST',	
				url: '" . CController::createUrl('marca/filtrar') . "',
				data: {'categoria':id_categoria}
				} 
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	
	//  para filtrar por seleccion de rangos de precio

	Yii::app()->clientScript->registerScript('precios',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('.precio-listado').click(function(){
			id_precio = $(this).attr('id');
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-productos-store-marca',
				{
				type: 'POST',	
				url: '" . CController::createUrl('marca/filtrar') . "',
				data: {'precio':id_precio}
				}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	?>
        

  <!-- SIDE BAR DE FILTROS OFF -->

        <!-- PRODUCTOS ON -->
        <div class="col-md-10">
            <section class="row">

			<?php
				$template = '
					{items}
      				{pager}
    			';

				$this->widget('zii.widgets.CListView', array(
				    'id'=>'list-productos-store-marca',
				    'dataProvider'=>$dataProvider,
				    'itemView'=>'_store',
				    'afterAjaxUpdate'=>" function(id, data) {	    				
									} ",
				    'template'=>$template,
				));    
			?>

            </section>
        </div>
  <!-- PRODUCTOS OFF -->
    </div>
</div>
<!-- CONTENIDO OFF -->