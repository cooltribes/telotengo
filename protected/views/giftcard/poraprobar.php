<?php
$this->breadcrumbs=array(
	'Gift Cards' => array('admin'),
	'Por Aprobar',
);

?>
<div class="container">
	<h1>Pagos de Gift Cards por aprobar</h1>
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

	    <hr/>

		<?php
		$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Orden GC</th>
	            <th scope="col">Fecha</th>
	            <th scope="col">Total Orden</th>
	            <th scope="col">Usuario</th>
	            <th scope="col">Monto Pago</th>
	            <th scope="col">Fecha Pago</th>
	            <th scope="col">Numero Pago</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-poraprobar',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_poraprobar',
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
