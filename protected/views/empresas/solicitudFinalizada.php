<div class="container">
	<div class="row-fluid">
		<h1>Telotengo.com <small>Solicitud</small></h1>
		<hr class="no_margin_top"/>
		<div class="col-sm-12">			
			<div class="no_padding" style="text-align: center">
				<?php if(Yii::app()->user->hasFlash('success')){?>
				    <div class="orangepanel white text_align_center no-radius">
				        <?php echo Yii::app()->user->getFlash('success'); ?>
				    </div>
				<?php } ?>
				<?php if(Yii::app()->user->hasFlash('error')){?>
				    <div class="alert in alert-block fade text_align_center no-radius" style="color:#010">
				        <?php echo Yii::app()->user->getFlash('error'); ?>
				    </div>
				<?php } ?>

				<div class="margin_top">
					<a href="<?php echo Yii::app()->baseUrl;?>" class="white"><b><u>Ir al inicio</u></b></a>
				</div>

	        </div>    
		</div>
	</div>
</div>