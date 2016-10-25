<style>
    .negro{
        background-color: black;
        color: #fff;
        border:0;
    }
    .negro:hover, .negro:active, .negro:visited   {
        color: #fff;
        background-color: black;
        border:0;
    }
        .mientras {    
    margin-top: -53px;
    margin-left: 33px;
    }
</style>
<?php
/* @var $this ProductoPadreController */
/* @var $model ProductoPadre */


$this->breadcrumbs=array(
	'Producto Padre',
);

?>


    	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div class="row-fluid">
		<div class="col-md-9 margin_top "><h1>Administrar Productos Padres</h1></div>
	
        
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
		<?php } ?>

		    <div class="row-fluid margin_top margin_bottom_small ">
		       <div class="col-md-3 col-md-offset-9"> 
                <?php
                    echo CHtml::link('Crear Producto Padre', Yii::app()->baseUrl."/producto/clasificar", array('class'=>'btn form-control btn-orange orange_border white', 'role'=>'button')); ?>
                </div>
	          <div class="margin_top col-md-12 no_horizontal_padding">
                 <div>Buscar</div>
                 

             <form class="form-search row-fluid" style="margin-top: -31px;">
                 <div class="col-md-3 no_horizontal_padding">
                    <input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Criterio de búsqueda">              
                 </div>
                 <div class="col-md-1 no_padding_left">
                     <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
                 </div>
                 
                <div class="col-md-3 col-md-offset-2">
                     <a class="btn btn-gray margin_left_minus" onclick="show('#nuevaBusqueda')">Crear búsqueda avanzada</a>
               </div>
                
                <div class="col-md-2"> 
              <?php      echo CHtml::link('Crear Variacion', Yii::app()->baseUrl."/producto/create", array('class'=>'btn form-control btn-darkgray white', 'role'=>'button'));
                ?>
                 </div>
                
                 
                    
             </form>
            </div> 
			
	    </div>
	    
	   <div class="row-fluid clearfix margin_bottom hide" id="nuevaBusqueda">
	     <?php  $this->renderPartial("_filters"); ?>
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
					'list-auth-items',
					{
					type: 'POST',	
					url: '" . CController::createUrl('productoPadre/admin') . "',
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
						'list-auth-items',
						{
						type: 'POST',	
						url: '" . CController::createUrl('productoPadre/admin') . "',
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
	            <th scope="col">Categoria</th>
	            <th scope="col">Status</th>
	            <th scope="col">Editar</th>
	        </tr>
	        </thead>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-items',
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

<script>
    function show(id){
        if($(id).hasClass('hide'))
            $(id).removeClass('hide');
        else
            $(id).addClass('hide');
    }
</script>  