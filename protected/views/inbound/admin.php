<style>
.summary{padding-top:17px;}
</style>
<?php
/* @var $this UnidadController */
/* @var $model Unidad */


$this->breadcrumbs=array(
	'Inbound',
);

?>

		
    	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<h1 class="col-md-10 no_padding_left">Administrador de Inbound</h1>
        <div class="col-md-2 margin_top_medium text-right no_padding_right">
                <?php
       # echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> Crear almacen', Yii::app()->baseUrl."/almacen/create", array('class'=>'btn btn-orange white', 'role'=>'button'));
                ?>
        </div>

		

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
		   
		     <div class="margin_top col-md-12 no_horizontal_padding">
		         <div>Buscar</div>


	         <form class="margin_bottom form-search row-fluid">
                 <div class="col-md-3 no_horizontal_padding">
                 	<input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Filtre por ID, Nombre de Empresa o Nombre de Usuario">              
                 </div>
                 <div class="col-md-1 no_padding_left">
                     <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
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
					url: '" . CController::createUrl('inbound/admin') . "',
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
						url: '" . CController::createUrl('inbound/admin') . "',
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
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover table-striped">
	        <thead>
	        <tr>
	            <th scope="col">ID</th>
	            <th scope="col">Empresa</th>
	            <th scope="col">Subido por</th>
	            <th scope="col">Fecha-Hora</th>
	            <th scope="col">N° de Productos</th>
	            <th scope="col">Cantidad Total</th>
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

