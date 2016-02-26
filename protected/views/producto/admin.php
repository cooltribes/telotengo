<!-- CONTENIDO ON -->
<div class="container">
	<?php
		$this->breadcrumbs=array(
			'Productos',
		);
	?>
	<div class="row-fluid clearfix">
		<h1 class="col-md-10">Administrar Variaciones de los Productos</h1>
        <div class="col-md-2 margin_top_medium">
                <?php
         echo CHtml::link('Crear Producto', $this->createUrl('create'), array('class'=>'btn form-control btn-orange orange_border white', 'role'=>'button'));
                ?>
        </div>
    </div>
    
    <div class="row-fluid">
            <hr/>
	
		<div>

			<?php if(Yii::app()->user->hasFlash('success')){?>
			    <div class="alert in alert-block fade alert-success text_align_center">
			        <?php echo Yii::app()->user->getFlash('success'); ?>
			    </div>
			<?php } ?>
			<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert in alert-block fade alert-danger text_align_center">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php } ?>

		<div class="row-fluid margin_top">
	       
             
             
            <div class="margin_top col-md-12 no_horizontal_padding">
                 <div>Buscar</div>


             <form class="margin_bottom form-search row-fluid">
                 <div class="col-md-3 no_horizontal_padding">
                    <input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Criterio de búsqueda">              
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
		
	     
			
	

	    
		<?php
		$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	     <thead>   <tr>
	            <th scope="col">Codigo TLT</th>
	            <th scope="col">Imagen</th>
	            <th scope="col">Nombre</th>
	            <th scope="col">Status</th>
	            <th scope="col">Destacado</th>
	            <th scope="col">Acción</th>
	        </tr>
	      </thead>
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
		     'summaryCssClass'=>'pull-left',
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
