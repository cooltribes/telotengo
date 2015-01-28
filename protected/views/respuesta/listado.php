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
    <div class="well preguntaHeader margin_bottom">
        " <?php echo $pregunta->pregunta; ?> "
        
    </div>
	<h1>Respuestas<a class="mediumRLink pull-right margin_top_small" id="answerLink" onclick="answerDisplay()">Aportar Respuesta <span class="glyphicon glyphicon-plus-sign"></span></a></h1>
		
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
	    
	    <div id="answerForm" class="alert alert-block form-inline well hide">
          
                   <div class="row-fluid"> 
                        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
                   </div>
                   
                    
            </div>
	    
	    
	    
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
 <script>
        function answerDisplay(){
            if($('#answerForm').hasClass('hide')){
                $('#answerForm').removeClass('hide');
                $('#answerLink').html('Ocultar');
            }else{
                $('#answerForm').addClass('hide');
                $('#answerLink').html('Aportar Respuesta <span class="glyphicon glyphicon-plus-sign"></span> ');
            }
        }
    </script>