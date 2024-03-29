<?php
/* @var $this UnidadController */
/* @var $model Unidad */


$this->breadcrumbs=array(
	'Almacenes',
);
?>
		
    	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div class="row-fluid">
		<h1 class="col-md-10 no_padding_left">Las sucursales de tu empresa</h1>
        <div class="col-md-2 margin_top_medium text-right no_padding_right">
                <?php
         if($empresaUsuario->admin==1)
         {
         	echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> Crear sucursal', Yii::app()->baseUrl."/almacen/create", array('class'=>'btn btn-orange white', 'role'=>'button'));
         	$columnaExtra='<th scope="col">Acción</th>';
         }
         else
         	$columnaExtra='';

                ?>
        </div>
		     <div class="margin_top col-md-12 no_horizontal_padding">
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
		   ?>
		        <!-- <div>Buscar</div> -->


	         <form class="margin_bottom form-search row-fluid">
                 <div class="col-md-3 no_horizontal_padding">
                     <input class="form-control no_radius" id="query" name="query" type="text" placeholder="Escribe tu criterio de búsqueda">                   
                 </div>
                 <div class="col-md-1 no_padding_left">
                     <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event"><span class="glyphicon glyphicon-search margin_left_minus"></span></a>
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
		</div>
		<div class="margin_top_small">
			<?php
		$template = '
		<div>{summary}</div>
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover table-striped">
	        <thead>
	        <tr>
	            <th scope="col">Razón social</th>
	            <th scope="col">Nombre comercial</th>
	            <th scope="col">Sucursal</th>
	           	<th scope="col">Ubicacion</th>
	           	<th scope="col">Ciudad</th>
	           	<th scope="col">Estado</th>
	            '.$columnaExtra.'
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
		</div>
