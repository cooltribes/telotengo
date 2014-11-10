<div class="container margin_top tu_perfil">
    <div class="page-header">
        <h1>Avatar</h1>     
    </div>

<?php
$this->breadcrumbs=array(
	'Tu Cuenta'=>array('/user/user/tucuenta'),
	'Avatar',
);

?>

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

    <div class="row">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'marca-form',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'type'=>'horizontal',
			'clientOptions'=>array(
				'validateOnSubmit'=>true, 
			),
			'htmlOptions' => array(
		        'enctype' => 'multipart/form-data',
		    ),
		)); ?>
	
		<div class="form-group">
		    <label> Sube un avatar: </label>
			<?php                      
				echo CHtml::activeFileField($model, 'avatar_url',array('name'=>'url'));
				echo $form->error($model, 'avatar_url'); 
			?>
	    </div>
	
		 <div class="form-group">
		 	<div class="card">	
			<?php 
				if($model->avatar_url!=""){
					echo '<label>Actual : </label>';
					echo CHtml::image(Yii::app()->request->baseUrl.'/images/user/'.$model->id.'_thumb.jpg',"Avatar");
				}
			?>

		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
			)); ?>
		</div>
	
		<?php $this->endWidget(); ?>

    </div>
</div>
<!-- /container -->
