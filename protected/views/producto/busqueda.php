<!-- CONTENIDO ON -->

        <div class="container-fluid" style="padding: 0 15px;">
            <div class="row">
            	
<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Selección'=>array('seleccion'),
	'Resultados',
);
?>
  
	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
    <div class="col-md-10 col-md-push-2 main-content" role="main">
    	
    	<?php echo CHtml::button('Regresar',array('submit' => array('producto/seleccion'), 'class'=>'btn btn-danger')); ?>
    	
    	<div class="page-header">
        	<h1> Resultados de la busqueda - <?php echo Yii::app()->session['busqueda']; ?> </h1>
		</div>
                    
                    <?php 
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Imágen</th>
	            <th scope="col">Referencia</th>
	            <th scope="col">Detalles</th>
	            <th scope="col">Acciones</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-busqueda',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos_busqueda',
		    'template'=>$template,
		    'enableSorting'=>'true',
		    'afterAjaxUpdate'=>" function(id, data) {
							   
								} ",
			'pager'=>array(
				'header'=>'',
				'htmlOptions'=>array(
				'class'=>'pagination pagination-right',
			)
			),					
		));  
		
		?>

                </div><!-- COLUMNA PRINCIPAL DERECHA OFF // -->

            </div><!-- CONTENIDO OFF -->
		</div>