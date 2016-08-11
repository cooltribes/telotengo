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
</style>
<?php
$this->breadcrumbs=array(
	'Administrar',
);
?>
<div class="container">



	<h1>Administrar Empresas</h1>
	<hr/>
			<div class="alert in alert-block fade alert-success text_align_center hide" id="emailSent">
		        Correo enviado satisfactoriamente
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
		<?php } ?>

		<div>
 
		 <hr/>    
		 <!--   <div class="margin_top margin_bottom_small">Filtrar</div> -->

	<div class="row-fluid clearfix margin_top margin_bottom">
		<form >
                         <div class="col-md-3 no_horizontal_padding">
                             <input class="form-control no_radius" id="query" name="query" type="text" placeholder="N° o nombre de empresa">                   
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
					url: '" . CController::createUrl('empresas/admin') . "',
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
						url: '" . CController::createUrl('empresas/admin') . "',
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
	            <th scope="col">ID</th>
	            <th  width="30%" scope="col">Razón Social</th>
	            <th scope="col">RIF</th>
	            <th  width="35%" scope="col">Direccion fiscal</th>
	            <th colspan="2" rowspan="2" scope="col" width="20%">Ubicacion</th>
	            <th scope="col">Telefono</th>
	            <th scope="col">Tipo de Empresa</th>
	            <th scope="col">Acción</th>
	        </tr>
	        <thead>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-items',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_view',
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