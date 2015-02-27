<?php
/* @var $this FlashsaleController */
/* @var $model Flashsale */

$this->breadcrumbs=array(
	'Usuarios de la tienda',
);

?>

<div class="container">
	<h1>Administrar Usuarios</h1>
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
	           		</div>         
	           	</form>
	        </div>
			
			<div class="pull-right">
	        <?php
	        	echo CHtml::link('Agregar usuario a tienda', $this->createUrl('createuser'), array('class'=>'btn btn-success', 'role'=>'button'));
	        ?>
			</div>
			
			
	    </div>
	    <hr/>
	    
	    <?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Usuario</th>
	            <th scope="col">Nombre</th>
	            <th scope="col">Cedula</th>
	            <th scope="col">Teléfono</th>
	            <th scope="col">Tienda</th>
	            <th scope="col">Rol</th> 
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-ordenes',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos',
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
