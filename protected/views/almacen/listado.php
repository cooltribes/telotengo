<?php
$this->breadcrumbs=array(
	'Listado de almacenes',
);

?>
<div class="container">
<h1>Listado de almacenes para: <?php echo $empresa->razon_social; ?></h1>
	
	<hr/>

	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

    <div class="row margin_top margin_bottom ">

        
        <div class="pull-right">
        <?php
        	echo CHtml::link('Agregar sucursal', $this->createUrl('create', array('id_empresa'=>$empresa->id)), array('class'=>'btn btn-success', 'role'=>'button'));
        ?>
		</div>
		
    </div>
    <hr/>
    
<?php 
$template = '{summary}
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
	            <th scope="col">Nombre</th>
	            <th scope="col">Ubicacion</th>
	            <th scope="col">Alias</th>
	            <th scope="col">Empresa</th>
	            <th scope="col">Acciones</th>
        </tr>
    {items}
    </table>
    {pager} 
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-empresas',
	    'dataProvider'=>$model->search(),
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