<div class="container-fluid" style="padding: 0 15px;">
	
    <div class="row">
        <div class="col-md-10 col-md-push-2 main-content" role="main">

            <?php
            $this->breadcrumbs=array(
            	'Tu cuenta'=>array('tucuenta'),
            	'Notificaciones',
            );
            ?>

            <div class="well">
            	<div class="row padding_left_medium">
            		<div class="col-md-6 1">

                        <h3>Notificaciones</h3>
                        <hr>

                        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                            'id'=>'notificaciones-form',
                            'enableAjaxValidation'=>false,
                            'enableClientValidation'=>true,
                            'type'=>'horizontal',
                            'clientOptions'=>array(
                                'validateOnSubmit'=>true, 
                            ),
                        )); ?>

                            <?php echo $form->errorSummary($model); ?>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo $form->checkBox($model,'mensaje'); ?> <?php echo $form->label($model,'mensaje'); ?>
                                        </label>
                                    </div>
                                </div>
                                <?php echo $form->error($model,'mensaje'); ?>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo $form->checkBox($model,'calificacion'); ?> <?php echo $form->label($model,'calificacion'); ?>
                                        </label>
                                    </div>
                                </div>
                                <?php echo $form->error($model,'calificacion'); ?>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo $form->checkBox($model,'wishlist'); ?> <?php echo $form->label($model,'wishlist'); ?>
                                        </label>
                                    </div>
                                </div>
                                <?php echo $form->error($model,'wishlist'); ?>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo $form->checkBox($model,'reclamo'); ?> <?php echo $form->label($model,'reclamo'); ?>
                                        </label>
                                    </div>
                                </div>
                                <?php echo $form->error($model,'reclamo'); ?>
                            </div>

                            <div class="form-actions">
                                <?php $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType'=>'submit',
                                    'type'=>'primary',
                                    'label'=>'Guardar',
                                )); ?>

                            </div>

                        <?php $this->endWidget(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>