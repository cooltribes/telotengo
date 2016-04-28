<div class="container">
	<?php
	if(Yii::app()->user->isAdmin())
	{
		$this->breadcrumbs=array(
		UserModule::t('Users')=>array('admin'),
		'Invitar usuario',
		);
	}
	else
	{
		$this->breadcrumbs=array(
		'Invitar usuario',
		);
	}

	?>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<h1><?php echo "Invitar usuario a telotengo.com"; ?></h1>
			<hr class="no_margin_top" />
			<?php
				echo $this->renderPartial('_form_invitar', array('model'=>$model,'profile'=>$profile));
			?>
		</div>
	</div>
</div>