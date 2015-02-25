<div>
<?php
    $modelo = Wishlist::model()->findByPk($id);
?>
<div class="modal-header no_border no_padding_bottom row-fluid">
    <h3 class="no_margin_top col-md-11">Cambiar nombre de lista de deseos</h3>
    <div class="col-md-1"><button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
</div>

<hr class="no_margin_top"/>


        <div class="modal-body padding_small row-fluid">
            
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'nombre-form',
                'enableAjaxValidation'=>false,
                'action' => Yii::app()->createUrl('wishlist/cambiar'),
                'enableClientValidation'=>true,
                'type'=>'horizontal', 
                'clientOptions'=>array(
                    'validateOnSubmit'=>true, 
                ),
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                ),
            )); ?>
                
            <div class='col-md-8 col-md-offset-2 well bg_white'>
            
                <?php                      
                    echo $form->textFieldRow($modelo,'nombre',array('class'=>'form-control'));
                    echo $form->error($modelo, 'nombre'); 

                    echo $form->hiddenField($modelo,'users_id',array('value'=>Yii::app()->user->id));
                ?>

            </div>
            <div class='col-md-8 col-md-offset-2 margin_top_small no_padding'>
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'htmlOptions'=>array('class'=>'form-control'),
                    'label'=> 'Guardar',
                )); ?>

        
            <?php $this->endWidget(); ?>
            
            </div>
        </div>
    
</div>