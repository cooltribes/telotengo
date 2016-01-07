<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */
$this->breadcrumbs=array(
	'Mis compras',
); 

if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)):
?>
          
                    <ul id="myTabs" class="nav nav-tabs margin_bottom" role="tablist">
                      <li role="presentation" class="active"><a href="#">COMPRAS</a></li>
                      <li role="presentation" class=""><a href="misVentas">VENTAS</a></li>

                    </ul>
<?php endif; ?>

    <h1 class="orderTitle">Mis Compras</h1>

    
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
		<div>
		    
		 <div class="row-fluid clearfix stats">
		     <div class="col-md-1 stat">
		         <span class="value"><?php echo Orden::model()->countByAttributes(array('users_id'=>Yii::app()->user->id));?></span>
		         <span class="legend">Totales</span>
		     </div>
		     <div class="col-md-1 stat">
                 <span class="value"><?php echo Orden::model()->countByAttributes(array('estado'=>0, 'users_id'=>Yii::app()->user->id))?></span>
                 <span class="legend">Pendiente</span>
             </div>
		     <div class="col-md-1 stat">
                 <span class="value"><?php echo Orden::model()->countByAttributes(array('estado'=>2, 'users_id'=>Yii::app()->user->id))?></span>
                 <span class="legend">Rechazados</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value"><?php echo Orden::model()->countByAttributes(array('estado'=>1, 'users_id'=>Yii::app()->user->id))?></span>
                 <span class="legend">Aprobados</span>
             </div>
           <!--  
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Pago confirmado</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Pago insuficiente</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Enviados</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Recibidos</span>
             </div>
             <div class="col-md-1 stat">
                 <span class="value">8888</span>
                 <span class="legend">Devueltos</span>
             </div>
            -->
		 </div>   
		 <hr/>    
		    <div class="margin_top margin_bottom_small">Filtrar</div>
	   <form class="margin_bottom form-search no_horizontal_padding row-fluid clearfix">
                         <div class="col-md-4 no_horizontal_padding">
                             <input class="form-control no_radius" id="query" name="query" type="text" placeholder="Número de Orden o Empresa Vendedora">                   
                         </div>
                         <div class="col-md-1 no_padding_left">
                             <a href="#" class="btn form-control btn-darkgray white" id="btn_search_event">Buscar</a>
                         </div>
                         <div class="col-md-offset-7"></div>
                                
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
					url: '" . CController::createUrl('orden/misCompras') . "',
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
						url: '" . CController::createUrl('orden/misCompras') . "',
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
		Yii::app()->clientScript->registerScript('query1',
			"var ajaxUpdateTimeout;
			var ajaxRequest;
			$('#btn_search_event').click(function(){
				ajaxRequest = $('#query').serialize();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-ordenes',
					{
					type: 'POST',	
					url: '" . CController::createUrl('orden/misCompras') . "',
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
						'list-auth-ordenes',
						{
						type: 'POST',	
						url: '" . CController::createUrl('orden/misCompras') . "',
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
	            <th scope="col">N°</th>
	            <th scope="col">Fecha de emisión</th>
	            <th scope="col">Empresa Vendedora</th>
	            <th scope="col">Vendido por</th>
	            <th>Última acción</th>	
	            <th class="text-right padding_right_large" scope="col">Monto</th>
	            <th scope="col">Estado</th>
	            <th scope="col">Acciones</th>
	        </tr>
	       </thead>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-ordenes',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos_compras',
		    'template'=>$template,
		    'summaryCssClass'=>'pull-left',
		    'enableSorting'=>'true',
			'pager'=>array(
				'header'=>'',
				'htmlOptions'=>array(
				'class'=>'pagination pagination-right',
			)
			),					
		));  
		
		?>

	<div id="productosOrden" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>	

</div>

<script>
function modal(id){

    $.ajax({ 
        type: "post",
        //'url' :'/site/orden/modalventas/'+id,
        'url' : '<?php echo $this->createUrl('orden/modalorden'); ?>'+'/'+id,
        data: { 'orden':id}, 
        'success': function(data){
            $('#productosOrden').html(data);
            $('#productosOrden').modal();
        },
        'cache' :false}); 

}
</script>
