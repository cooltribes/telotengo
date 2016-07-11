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
$this->breadcrumbs=array(
	'Categorias',
);
?> 
<div class="container">
    <div class="row-fluid">
    <h1 class="col-md-10">Administrar Categorías</h1>
        <div class="col-md-2 margin_top_medium">
                <?php
         echo CHtml::link('Crear Categoría', $this->createUrl('create'), array('class'=>'btn form-control btn-orange orange_border white', 'role'=>'button'));
                ?>
        </div></div>
    
    <hr class="no_margin_top"/>


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


                    <div class="margin_top col-md-12 no_horizontal_padding">
                 <div>Buscar</div>
        <form>
			<div class="col-md-3 no_horizontal_padding">
				<input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Escribe tu criterio de búsqueda">                   
			</div>
			<div class="col-md-1 no_padding_left">
				<a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
			</div>             
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
					url: '" . CController::createUrl('categoria/admin') . "',
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
						url: '" . CController::createUrl('categoria/admin') . "',
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
	        <tr>
	            <th scope="col">Logo</th>
	            <th scope="col">Nombre</th>
	            <th scope="col" width="40%">Url</th>
	            <th scope="col">Destacado</th>
	            <th scope="col">Estatus</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-items',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos',
		    'template'=>$template,
		              'summaryCssClass'=>'pull-left',
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