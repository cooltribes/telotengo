<?php
/* @var $this UnidadController */
/* @var $model Unidad */


$this->breadcrumbs=array(
	'Almacenes',
);

?>

		
    	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<h1 class="col-md-10">Administrar Almacenes de la Empresa <?php echo $empresa->razon_social?></h1>
        <div class="col-md-2 margin_top_medium">
                <?php
       //  echo CHtml::link('Nueva Unidad', $this->createUrl('create'), array('class'=>'btn form-control btn-success', 'role'=>'button'));
                ?>
        </div>

		<hr/>

				<?php if(Yii::app()->user->hasFlash('success')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
		    <div class="alert in alert-block fade alert-danger text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } 

		 echo CHtml::link('Crear almacen', Yii::app()->baseUrl."/almacen/create", array('class'=>'btn btn-warning margin_top', 'role'=>'button'));
		   ?>
		    <div class="row margin_top margin_bottom ">
	         <form class="no_margin_bottom form-search row-fluid">
                 <div class="col-md-3 col-md-offset-8 no_padding_right">
                     <input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Escribe tu criterio de búsqueda">                   
                 </div>
                 <div class="col-md-1 no_padding_left">
                     <a href="#" class="btn form-control btn-sigmablue no_radius_left" id="btn_search_event">Buscar</a>
                 </div>   
             </form>
			
	    </div>
	    
	    		<?php
		Yii::app()->clientScript->registerScript('query1',
			"var ajaxUpdateTimeout;
			var ajaxRequest;
			$('#btn_search_event').click(function(){
				ajaxRequest = $('#query').serialize();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-marcas',
					{
					type: 'POST',	
					url: '" . CController::createUrl('almacen/administrador') . "',
					data: ajaxRequest}
					)
					},
			300);
			return false;
			});",CClientScript::POS_READY
		);
		
		// Codigo para actualizar el list view cuando presionen ENTER
		
		Yii::app()->clientScript->registerScript('query',
			"var ajaxUpdateTimeout;
			var ajaxRequest; 
			
			$(document).keypress(function(e) {
			    if(e.which == 13) {
					ajaxRequest = $('#query').serialize();
					clearTimeout(ajaxUpdateTimeout);
					
					ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
						'list-auth-marcas',
						{
						type: 'POST',	
						url: '" . CController::createUrl('almacen/administrador') . "',
						data: ajaxRequest}
						
						)
						},
				
				300);
				return false;
			    }
			});",CClientScript::POS_READY
		);	
		?>
			<?php
		$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <thead>
	        <tr>
	            <th scope="col">Nombre</th>
	            <th scope="col">Ubicacion</th>
	            <th scope="col">Alias</th>
	            <th scope="col">Empresa</th>
	            <th scope="col">Acciones</th>
	        </tr>
	        </thead>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-marcas',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos',
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

