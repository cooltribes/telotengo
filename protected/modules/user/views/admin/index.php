<?php
$this->breadcrumbs=array(
	"Administrar Usuarios",
);
?>

<style>
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

<div class="container">
	<h1>Administrar Usuarios</h1>
	<div class="row-fluid clearfix margin_top margin_bottom">
        <div class="col-md-4 no_padding_left">
                <form class="no_margin_bottom form-search row-fluid formularionuevo clearfix">
                    <div class="col-md-2 no_horizontal_padding">
                        <a href="#" class="btn form-control btn-gray no_radius_right" id="btn_search_event">
                            <span class="glyphicon glyphicon-search margin_left_minus"></span>
                       </a>
                    </div>
                    <div class="col-md-10 no_padding_left">
                        <input class="form-control margin_left_minus" id="query" name="query" type="text" placeholder="Buscar">                    
                    </div>
                    
                </form>
        </div>
         <div class="col-md-8 no_horizontal_padding">
           <div class="row-fluid">
               <div class="col-md-4">
                     <select class="form-control">
                       <option>-- Búsquedas avanzadas --</option>
                   </select>
               </div>
               <div class="col-md-3 col-md-offset-1">
                     <a class="btn btn-gray margin_left_minus" onclick="show('#nuevaBusqueda')">Crear búsqueda avanzada</a>
               </div>
          
               <div class="col-md-3 col-md-offset-1 no_padding_right">
                     <?php
         echo CHtml::link('Invitar usuario', $this->createUrl('invitarUsuario'), array('class'=>'btn form-control btn-orange orange_border white', 'role'=>'button'));
                ?>
               </div>
           </div>
        </div>
        
        </div>
	
	
	
	<div class="row-fluid clearfix margin_bottom hide" id="nuevaBusqueda">
	    <div class="col-md-12 no_horizontal_padding">
	       <h4 class="no_margin_bottom margin_top_small">Nueva búsqueda avanzada</h4>
	       <hr class="no_margin_top"/>
	    </div>
	    <div class="col-md-8 no_horizontal_padding">
	       <div class="row-fluid">
	           <div class="col-md-5 no_padding_left">
	               <select class="form-control">
	                   <option>-- Seleccione --</option>
	               </select>
	           </div>
	           <div class="col-md-3">
                   <select class="form-control">
                       <option>-- Operador --</option>
                   </select>
               </div>
               <div class="col-md-3 no_padding_right">
                   <input class="form-control no_radius"/>
               </div>
               <div class="col-md-1 no_padding_left">
                   <a class="btn btn-black" style="color:white; border:solid 1px black">Buscar</a>
               </div>
	       </div>
	    </div>
	    
	    <div class="col-md-4 no_padding_right">
	        <div class="row-fluid">
	            <div class="col-md-8 text-center">
	                <a class="btn btn-gray">Buscar y Guardar</a>
	            </div>
	            <div class="col-md-4 text-rightno_padding_right">
                    <a class="btn btn-gray">Borrar Filtro</a>
                </div>
	        </div>
	    </div>
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
					url: '" . CController::createUrl('admin') . "',
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
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover table-striped">
	        <thead>
	        <tr>
	           <th rowspan="2"><input type="checkbox" rowspan="2"/></th>
	            <th colspan="3" rowspan="2">Usuario</th>
	            <th scope="col" rowspan="2">Empresa</th>
	            <th rowspan="2">Cargo</th>
                <th colspan="2">Ingresos al Portal</th>
                 
	            <th rowspan="2">Estado</th>

	            <th rowspan="2" scope="col"></th>
	        </tr>
	        
	        <tr>
	           <th>#</th>
                <th>Fecha</th>
	        </tr>
	      </thead>
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



    function desactivarActivar(id)
    {
            
            $.ajax({
             url: "<?php echo Yii::app()->createUrl('user/user/activarDesactivar') ?>",
             type: 'POST',
             data:{
                    id:id,
                   },
            success: function (data) {
                if(data==0)//lo contrario
                {
                    $('#'+id).html('<i class="glyphicon glyphicon-ok"></i> Activar');
                    $('#'+id+'s').html('Desactivo')
                }
                else
                {
                    $('#'+id).html('<i class="glyphicon glyphicon-remove"></i> Desactivar');
                    $('#'+id+'s').html('Activo')
                }
            }
           })
        
    }


    function show(id){
        if($(id).hasClass('hide'))
            $(id).removeClass('hide');
        else
            $(id).addClass('hide');
    }
    
</script>
