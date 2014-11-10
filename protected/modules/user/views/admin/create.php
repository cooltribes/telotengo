<div class="container">
	<?php
	$this->breadcrumbs=array(
		UserModule::t('Users')=>array('admin'),
		UserModule::t('Create'),
	);
	?>
	<div class="row">
		<div class="col-md-offset-4 col-md-4">
			<h1><?php echo UserModule::t("Create User"); ?></h1>

			<?php
				echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
			?>
		</div>
	</div>
</div>