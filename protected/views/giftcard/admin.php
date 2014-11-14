<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */

$this->breadcrumbs=array(
	'Gift Cards'=>array('admin'),
	'Administrar',
);
 
?>

<div class="container">
	<h1>Administrar Gift Cards</h1>
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

			<div class="pull-right">
	        <?php
	        	echo CHtml::link('Generar Gift Card', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
	        ?>
			</div>

	    <hr/>
	    
	    <?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Tarjeta #</th>
	            <th scope="col">Fecha de Compra</th>
	            <th scope="col">Fecha de Cobro</th>
	            <th scope="col">Total (Bs.)</th>
	            <th scope="col">Comprador</th>
	            <th scope="col">Beneficiario</th>
	            <th scope="col">Estado</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-gift',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos',
		    'template'=>$template,
		    'enableSorting'=>'true',
			'pager'=>array(
				'header'=>'',
				'htmlOptions'=>array( 
				'class'=>'pagination pagination-right',
			)
			),					
		));  
		
		?>
</div>
