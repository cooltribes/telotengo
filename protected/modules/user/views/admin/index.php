<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

?>
<div class="container">
	<h1>Administrar usuarios</h1>
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

	    <div class="row margin_top margin_bottom ">
	        <div class="span4">
	            <form class="no_margin_bottom form-search">
	            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
	            		<input class="span3" id="query" name="query" type="text" placeholder="Buscar">
	                	<a href="#" class="btn" id="btn_search_event">Buscar</a>
	           		</form>
	           	</div>         
	        </div>
	        
	        <div class="pull-right">
	        <?php
	        	echo CHtml::link('Crear Usuario', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
	        ?>
			</div>
			
	    </div>
	    <hr/>
	    
	    <?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">ID</th>
	            <th scope="col">Email</th>
	            <th scope="col" width="40%">Nombre y Apellido</th>
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
		    'dataProvider'=>$model->search(),
		    'itemView'=>'_view_user',
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