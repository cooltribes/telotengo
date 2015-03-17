<div class="container">
    <div class="row-fluid">
        <div class="col-md-12">

            <?php
            $this->breadcrumbs=array(
            	'Tu cuenta'=>array('tucuenta'),
            	'Privacidad',
            );
            ?>

        	<div class="row">
        		<div class="col-md-10">

                    <h1>Privacidad</h1>
                    <hr class="no_margin_top">

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

                        <div class="form-group margin_left_small">
                            <div class="col-sm-6">
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
                            <div class="form-group margin_left_small">
                                <div class="col-sm-6">
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
                                'htmlOptions' => array('class'=>'btn btn-danger btn-lg'),
                            )); ?>

                        </div>

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
