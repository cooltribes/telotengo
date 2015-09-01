<div class="container">
	<?php
	$this->breadcrumbs=array(
		UserModule::t('Users')=>array('admin'),
		'Editar datos de usuario',
	);
	?>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<h1><?php echo "Editar usuario"; ?></h1>
			<hr class="no_margin_top" />
			<?php
				echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
			?>
		</div>
	</div>
</div>