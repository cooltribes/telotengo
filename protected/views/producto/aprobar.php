<!-- CONTENIDO ON -->
     <div class="container">
     	
<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Aprobar',
);

?>

<div class="row">
	<!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-12" role="main">
			<h1>Aprobar Productos</h1>

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
	
	<hr />
	
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
	    	echo CHtml::link('Crear Producto', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
	    ?>
		</div>
			
	</div>
	<hr/>
	    
	<?php
	$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Nombre</th>
	            <th scope="col">Descripción</th>
	            <th scope="col">Destacado</th>
	            <th scope="col">Marca</th>
	            <th scope="col">Usuario</th>
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-categorias',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_aprobar',
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
</div>
</div>    
