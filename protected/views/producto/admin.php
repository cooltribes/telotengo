<!-- CONTENIDO ON -->
<div class="container">
	<?php
		$this->breadcrumbs=array(
			'Productos',
		);
	?>
	<div class="row-fluid">
    	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div>
			<h1>Administrar Productos</h1>

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
		
		<div class="row-fluid margin_top">
	        <div class="col-md-4">
	            <form class="no_margin_bottom form-search">
	            	<div class="input-prepend"><span class="add-on"><i class="icon-search"></i></span>
	            		<input class="col-md-9" id="query" name="query" type="text" placeholder="Buscar">
	                	<a href="#" class="btn btn-sm btn-danger margin_left_small" id="btn_search_event">Buscar</a>
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
					'list-auth-categorias',
					{
					type: 'POST',	
					url: '" . CController::createUrl('producto/admin') . "',
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
						'list-auth-categorias',
						{
						type: 'POST',	
						url: '" . CController::createUrl('producto/admin') . "',
						data: ajaxRequest}
						
						)
						},
				
				300);
				return false;
			    }
			});",CClientScript::POS_READY
		);	
		?>
		
	        <div class="pull-right">
	        <?php
	        	echo CHtml::link('Crear Producto', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
	        ?>
			</div>
			
	    </div>
	    <hr/>
	    
		<?php
		$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	        	<th scope="col">ID</th>
	            <th scope="col">Nombre</th>
	            <th scope="col">Estado</th>
	            <th scope="col">Peso (Kg.)</th>
	            <th scope="col">Destacado</th>
	            <th scope="col">Marca</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-categorias',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_prod',
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
