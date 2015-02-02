<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
UserModule::t("Profile")=>array('profile'),
UserModule::t("Edit"),
);
/*$this->menu=array(
((UserModule::isAdmin())
?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
:array()),
array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);*/
?>


<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>

<div class="form container">
	<div class="row">
		<div class="col-md-offset-3 col-md-5">
			<h1><?php echo UserModule::t('Editar perfil'); ?></h1>
			<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'profile-form',
			'enableAjaxValidation'=>true,
			'htmlOptions' => array('enctype'=>'multipart/form-data'),
			)); ?>

				<?php echo $form->errorSummary(array($model,$profile)); ?>

				<?php 
				$profileFields=$profile->getFields();
				if ($profileFields) {
				foreach($profileFields as $field) {
					?>
					<div class="form-group">
						<?php echo $form->labelEx($profile,$field->varname);

						if ($widgetEdit = $field->widgetEdit($profile)) {
							echo $widgetEdit;
						} elseif ($field->range) {
							echo $form->dropDownList($profile,$field->varname,Profile::range($field->range),array('class'=>'form-control'));
						} elseif ($field->field_type=="TEXT") {
							echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
						} else {
							echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255), 'class'=>'form-control'));
						}
						echo $form->error($profile,$field->varname); ?>
					</div>	
					<?php
					}
				}
				?>
				<div class="form-group">
					<?php echo $form->labelEx($model,'email'); ?>
					<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'email'); ?>
				</div>

				<div class="submit">
					<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class'=>'btn btn-default')); ?>
				</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div><!-- form -->
