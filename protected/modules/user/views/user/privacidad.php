<div class="container-fluid" style="padding: 0 15px;">
	
    <div class="row">
        <div class="col-md-10 col-md-push-2 main-content" role="main">

            <?php
            $this->breadcrumbs=array(
            	'Tu cuenta'=>array('tucuenta'),
            	'Privacidad',
            );
            ?>

            <div class="well">
            	<div class="row padding_left_medium">
            		<div class="col-md-6 1">

                        <h3>Privacidad</h3>
                        <hr>

                        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                            'id'=>'privacidad-form',
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
                                            <?php echo $form->checkBox($model,'email'); ?> <?php echo $form->label($model,'email'); ?>
                                        </label>
                                    </div>
                                </div>
                                <?php echo $form->error($model,'email'); ?>
                            </div>

                            <?php
                            if(!$user->isAdmin() && !$user->hasEmpresasVendedoras()){
                                ?>
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
                                <?php
                            }
                            ?>

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
