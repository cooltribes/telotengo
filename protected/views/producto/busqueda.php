        	
	<?php
	$this->breadcrumbs=array(
		'Productos'=>array('admin'),
		'Selección'=>array('seleccion'),
		'Resultados',
	);
	?>
	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

		<?php //echo CHtml::button('Regresar',array('submit' => array('producto/seleccion'), 'class'=>'btn btn-danger')); ?>
    	
    	<div class="page-header">
        	<h1> Resultados de la busqueda - <?php echo Yii::app()->session['busquedaPalabra']; ?> </h1>
		</div>
                    
		<?php 
			$template = '{summary}
	    		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
			      
			        <col width="10%">
			         <col width="8%">
			         <col width="12%">
			          <col width="15%">
			           <col width="55%">
			           <thead>
			        <tr>
			            <th scope="col">Imágen</th>
			            <th scope="col">Codigo TLT</th>
			            <th scope="col">UPC</th>
			            <th scope="col">Numero de parte</th>
			            <th scope="col">Nombre</th>
			            <th scope="col">Referencia</th>
			            <th scope="col">Acciones</th>
			        </tr>
			        </thead>
	    		{items}
	    		</table>
			    {pager}
                <p class="margin_top_minus">
                    Si no ves el producto que necesitas, <a class="blueLink" href="nuevoProducto"> crea un producto nuevo </a>
                </p> 
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
