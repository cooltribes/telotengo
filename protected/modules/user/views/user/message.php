<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>

<section class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-md-12 main-content" role="main">
				<div class="page-header">
					<h1><?php echo $title; ?></h1>
				</div>
				<div class="alert alert-success">
					<?php echo $content; ?>
				</div><!-- yiiForm -->
				<div class="col-sm-offset-5 padding_medium">
					<a href="<?php echo Yii::app()->getHomeUrl(); ?>" class="btn btn-success btn-lg">Ir al inicio</a>
				</div>
			</div>
		</div>
	</div>
</section>