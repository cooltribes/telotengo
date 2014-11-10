<!-- CONTENIDO ON -->
     <div class="container">

<?php
$this->breadcrumbs=array(
	'Productos',
);

?>

<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-12" role="main">
			<h1>Calificaciones</h1>

<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>
	
	<hr />
	
	<div class="row margin_top margin_bottom ">
		Empresa: <?php echo $model->razon_social; ?></br>

		Calificación promedio: <?php echo $calificacion_promedio; ?></br>
	</div>
	    <hr/>
	    
	    
	    	    <?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	        	<th scope="col">Usuario</th>
	        	<th scope="col">Email</th>
	        	<th scope="col">Orden #</th>
	            <th scope="col">Puntuación</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-categorias',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_calificacion_empresa',
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
</div>
</div>
</div>    
