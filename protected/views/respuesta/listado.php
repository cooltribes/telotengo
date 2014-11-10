<?php

$user = User::model()->findByPk(Yii::app()->user->id);

if($user->isAdmin()){
$this->breadcrumbs=array(
	'Preguntas'=>array('pregunta/admin'),
	'Respuestas',
);
}
else{
$this->breadcrumbs=array(
	'Preguntas'=>array('pregunta/preguntas'),
	'Respuestas',
);
}
?>
<div class="container">
	<h1>Respuestas</h1>
		
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
	    
	    
		<?php
		
		
		$template = '{summary}
		    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
		        <tr>
		        	<th scope="col">Usuario</th>
		            <th scope="col">Respuesta</th>
		            <th scope="col">Fecha</th>
		            <th scope="col">Acción</th>
		        </tr>
		    {items}
		    </table>
		    {pager} 
			';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-respuestas',
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
