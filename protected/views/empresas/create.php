<!-- CONTENIDO ON -->
<div class="container">
	<div class="row-fluid">
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
		<h1>Telotengo.com <small>Solicitud</small></h1>
		<hr class="no_margin_top"/>
		<div class="col-sm-12">			
			<div class="col-sm-10 no_padding" style="text-align: center">
	            <div class="margin_top margin_bottom alert in alert-block fade alert-info text_align_center">
	                Y ahora permítenos conocer acerca de tu empresa:
	            </div>
	        </div>    

			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

		</div>
	</div>
</div>