<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */

$this->breadcrumbs=array(
	'Listado de Pedidos',
);

?>

<div class="container">
	<h1>Listado de Pedidos</h1>
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
	        <div class="span4">
	            <form class="no_margin_bottom form-search">
	            	<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
	            		<input class="span3" id="query" name="query" type="text" placeholder="Buscar">
	                	<a href="#" class="btn" id="btn_search_event">Buscar</a>
	           		</div>         
	           	</form>
	        </div>
			
	    </div>
	    <hr/>
	    
	    <?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Pedido #</th>
	            <th scope="col">Fecha</th>
	            <th scope="col">Total Bs.</th>
	            <th scope="col">Vendedor</th>
	            <th scope="col">Estado</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-listado',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos_usuario', 
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
