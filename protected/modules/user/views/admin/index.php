<?php
$this->breadcrumbs=array(
	"Administrar Usuarios",
);
?>

<div class="container">
	<div class="row-fluid">
	 <h1 class="col-md-10">Administrar Usuarios</h1>
        <div class="col-md-2 margin_top_medium">
                <?php
         echo CHtml::link('Invitar usuario', $this->createUrl('invitarUsuario'), array('class'=>'btn form-control btn-success', 'role'=>'button'));
                ?>
        </div>
      </div>
	
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
     
	   	<form class="no_margin_bottom form-search row-fluid formularionuevo">
			<div class="col-md-3 col-md-offset-8 no_padding_right">
				<input class="form-control no_radius_right" id="query" name="query" type="text" placeholder="Buscar">	                 
			</div>
			<div class="col-md-1 no_padding_left">
				<a href="#" class="btn form-control btn-sigmablue no_radius_left" id="btn_search_event">Buscar</a>
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
					url: '" . CController::createUrl('admin/admin') . "',
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
						url: '" . CController::createUrl('admin/admin') . "',
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
	            <th scope="col">ID</th>
	            <th scope="col">Email</th>
	            <th scope="col" width="25%">Nombre y Apellido</th>
	            <th scope="col">Tipo de invitación</th>
	            <th scope="col">¿Quien invitó?</th>
	            <th scope="col">Estado</th>
	            <th scope="col">Fecha de Creación</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-categorias',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_view_user',
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

<script>
    function carga(id){

    $.ajax({
        type: "post",
        'url' :'<?php echo  CController::createUrl('admin/cargaSaldo');?>',
        data: { 'id':id}, 
        'success': function(data){
            $('#saldoCarga').html(data);
            $('#saldoCarga').modal(); 
        },
        'cache' :false});

}
    
    
    
    
    function saldo(id){ 
        
        var cant=$("#cant").val();
        var desc=0;
        var id =id.toString();
        var pattern = /^[+-]?[0-9]{1,9}(?:\,[0-9]{1,2})?$/;
       
    /*   if($('#discount').attr('checked')=='checked')
        desc=1;
      */ 
        
        if (pattern.test(cant)&&cant.length>0) { 
          
           $.ajax({
            type: "post",
            dataType: "json",
            url :'<?php echo  CController::createUrl('admin/addSaldo');?>',
            data: { 'cant':cant,'id':id,'desc':desc}, 
            'success': function(data){
                $('#saldoCarga').modal('hide'); 
                window.location.reload();                                       
            },
            'cache' :false});
        }else{
            alert("Formato de cantidad no válido");
         }     
}
    
</script>
