<?php
$this->breadcrumbs=array(
	'Tipos de pago',
);
?>

<div class="container">
	<div class="row-fluid">
    <h1 class="col-md-10">Administrar Tipos de pagos</h1>
        <div class="col-md-2 margin_top_medium">
                <?php
         echo CHtml::link('Crear Tipo de Pago', $this->createUrl('create'), array('class'=>'btn form-control btn-success', 'role'=>'button'));
                ?>
        </div></div>
    
    <hr class="no_margin_top"/>
	

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
	    
	<?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">id</th>
	            <th scope="col">Logo</th>
	            <th scope="col">Nombre</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-tipos',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos',
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