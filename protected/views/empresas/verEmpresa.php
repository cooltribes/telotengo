		<div class="row" id="empresa" >
		<div class="col-md-offset-3 col-md-6">
			<h1><?php echo "Ver Empresa"; ?></h1>
			<hr class="no_margin_top" />

			<div class="form-horizontal margin_top" role="form">

							<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'empresas-form',
							'enableAjaxValidation'=>true,
							'htmlOptions' => array('enctype'=>'multipart/form-data'),
						));
						?>

							<?php #echo $form->errorSummary(array($empresas,$profile)); ?>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'razon_social'); ?>
									<?php echo $form->textField($empresas,'razon_social',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'razon_social'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'sector'); ?>
										<?php echo CHtml::textField("sector", CHtml::encode( $empresas->itemAlias("Sector",$empresas->sector)) , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
					
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'rif'); ?>
									<?php echo $form->textField($empresas,'rif',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'rif'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'direccion'); ?>
									<?php echo $form->textField($empresas,'direccion',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'direccion'); ?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'tipo_contribuyente'); ?>
									<?php echo CHtml::textField("sector", CHtml::encode( $empresas->itemAlias("TipoContribuyente",$empresas->tipo_contribuyente)) , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
								</div>
							</div>

							<?php if($empresas->telefono!=""):?>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'telefono'); ?>
									<?php echo $form->textField($empresas,'telefono',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'telefono'); ?>
								</div>
							</div>
						<?php endif;?>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'provincia'); ?>
									<?php echo CHtml::textField("provincia", Provincia::model()->findByPk($provincia_id)->nombre , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas,'ciudad'); ?>
									<?php echo CHtml::textField("ciudad", Ciudad::model()->findByPk($empresas->ciudad)->nombre , array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-12">
									<?php echo $form->labelEx($empresas, 'tipo de Empresa'); ?>
									<?php echo $form->textField($empresas,'rol',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'disabled'=>'disabled')); ?>
									<?php echo $form->error($empresas,'rol'); ?>
								</div>
							</div>

							<div>
								<div class="col-md-3 col-md-offset-5 padding_right">
									<a href="<?php echo Yii::app()->createUrl('empresas/admin')?>" id="admin" class="btn btn-primary" id="btn_search_event">Ir Admin</a>
								</div>

						<?php $this->endWidget(); ?>


			</div><!-- form -->




		</div>
	</div>