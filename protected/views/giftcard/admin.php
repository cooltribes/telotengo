<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */

$this->breadcrumbs=array(
	'Gift Cards'=>array('admin'),
	'Administrar',
);
 
?>

<div class="container">

	
	<div class="row-fluid">
    <h1 class="col-md-10">Administrar Gift Cards</h1>
        <div class="col-md-2 margin_top_medium">
                <?php
         echo CHtml::link('Generar Gift Card', $this->createUrl('create'), array('class'=>'btn form-control btn-success', 'role'=>'button'));
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
	            <th scope="col">ID</th>
	            <th scope="col">Fecha de Compra</th>
	            <th scope="col">Fecha de Cobro</th>
	            <th scope="col">Total (Bs.)</th>
	            <th scope="col">Comprador</th>
	            <th scope="col">Beneficiario</th>
	            <th scope="col">Estado</th>
	            <th scope="col"></th>
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
