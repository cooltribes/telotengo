<div class="container">
	<div class="row-fluid">
		<h1>Telotengo.com <small>Solicitud</small></h1>
		<hr class="no_margin_top"/>
		<div class="col-sm-12">			
			<div class="no_padding" style="text-align: center">
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

				<div>
					<a href="http://telotengo.com/new"><button type="button" class="btn btn-success">Ir al inicio</button></a>
				</div>

	        </div>    
		</div>
	</div>
</div>