<style>
.centrar{text-align: center;}
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
</style><?php
/* @var $this UnidadController */
/* @var $model Unidad */


$this->breadcrumbs=array(
	'Almacenes',
);

?>


    	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		<div class="row-fluid clearfix">
			<h1 class="col-md-10">Administrar Almacenes</h1>
	        <div class="col-md-2 margin_top_medium">
	                <?php
	       //  echo CHtml::link('Nueva Unidad', $this->createUrl('create'), array('class'=>'btn form-control btn-success', 'role'=>'button'));
	                ?>
	        </div>


			<hr/>
		</div>
		<div class="row-fluid"> 

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
     
	        <!-- <form class="no_margin_bottom form-search row-fluid">
                 <div class="col-md-3 col-md-offset-8 no_padding_right">
                     <input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Escribe tu criterio de búsqueda">                   
                 </div>
                 <div class="col-md-1 no_padding_left">
                     <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
                 </div>   
             </form> -->

        <div class="row-fluid clearfix margin_top margin_bottom">
			<form >
                         <div class="col-md-3 no_horizontal_padding">
                             <input class="form-control no_radius" id="query" name="query" type="text" placeholder="Escribe tu criterio de búsqueda">                   
                         </div>
                         <div class="col-md-1 no_padding_left">
                             <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
                         </div>
                         <div class="col-md-offset-8"></div>
                                
        	</form>
	         <div class="col-md-8 no_horizontal_padding">
	           <div class="row-fluid">
	               <!--<div class="col-md-4">
	                     <select class="form-control">
	                       <option>-- Búsquedas avanzadas --</option>
	                   </select>
	               </div> -->
	               <div class="col-md-3 col-md-offset-1">
	                     <a class="btn btn-gray margin_left_minus" onclick="show('#nuevaBusqueda')">Crear búsqueda avanzada</a>
	               </div>
	           </div>
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
					url: '" . CController::createUrl('almacen/admin') . "',
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
						url: '" . CController::createUrl('almacen/admin') . "',
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
	            <th scope="col">Razón social</th>
	            <th scope="col">Nombre comercial</th>
	            <th scope="col">Sucursal</th>
	           	<th scope="col">Ubicacion</th>
	           	<th scope="col">Ciudad</th>
	           	<th scope="col">Estado</th>
	            <th scope="col">Acción</th>
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
		</div>



		 <script>
    function show(id){
        if($(id).hasClass('hide'))
            $(id).removeClass('hide');
        else
            $(id).addClass('hide');
    }
</script>

