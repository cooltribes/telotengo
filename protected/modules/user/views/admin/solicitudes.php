<style>
.centrar{text-align: center;}

    .table-striped > thead > tr > th{
        border-left: solid 1px white;
        border-top: solid 1px white;
        border-right: 0px;
        border-bottom: 0px;
        color: white;
        background: black;
        vertical-align: top;
    }

</style>
<?php
$this->breadcrumbs=array(
	"Administrar Usuarios",
);
?>

<div class="container">
	<div class="row-fluid">
	 <h1 class="col-md-10">Administrador de solicitudes</h1>
      </div>
	
	<hr class="no_margin_top"/>

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
     
	   	<form class="no_margin_bottom form-search row-fluid formularionuevo">
			<div class="col-md-3 col-md-offset-8 no_padding_right">
				<input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Buscar">	                 
			</div>
			<div class="col-md-1 no_padding_left">
				<a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
			</div>
		</form>


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
					url: '" . CController::createUrl('admin/solicitudes') . "',
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
						url: '" . CController::createUrl('admin/solicitudes') . "',
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
	     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover table-striped margin_top">
	        <thead>
		        <tr>
		            <th scope="col "width="8%">Fecha</th> 
		            <th colspan="2" rowspan="2" scope="col" width="25%">Usuario</th>
		            <th scope="col">Rol</th>
		            <th scope="col">Tipo de invitación</th>
		            <th scope="col">¿Quien invitó?</th>
		            <th colspan="2" rowspan="2" scope="col" width="25%">Empresa</th>
		            <th scope="col">Acción</th>
		        </tr>
		        </tr>
	        </thead>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-categorias',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'solicitudes_view',
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
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<div id="saldoCarga" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>