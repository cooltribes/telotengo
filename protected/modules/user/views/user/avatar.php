<div class="modal-header no_border no_padding_bottom row-fluid">
    <h3 class="no_margin_top col-md-11">Nuevo Avatar</h3>
    <div class="col-md-1"><button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
</div>

<hr class="no_margin_top"/>
    <div class="padding_small modal-body no_padding row-fluid">
        
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'marca-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'type'=>'horizontal',
            'clientOptions'=>array(
                'validateOnSubmit'=>true, 
            ),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        )); ?>

         <?php 
                if($model->avatar_url!=""){ ?>
        <div class='col-md-8 col-md-offset-2 well bg_white'>
            
           <?php 
                    echo '<label>Actual</label><br/>';
                    echo "<div>".CHtml::image(Yii::app()->request->baseUrl.'/images/user/'.$model->id.'_thumb.jpg',"Avatar")."</div>";
                ?>
           
        </div>
     <?php   }
            ?>
        <div class='col-md-8 col-md-offset-2 well bg_white'>    
            <label> Sube un avatar </label>
            <?php                      
                echo CHtml::activeFileField($model, 'avatar_url',array('name'=>'url'));
                echo $form->error($model, 'avatar_url'); 
            ?>

        </div>
        <div class='col-md-8 col-md-offset-2 margin_top_small margin_bottom_small no_padding'>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'url'=>$this->createUrl('addAddress',array('img'=>1)),
                'htmlOptions'=>array('class'=>'form-control'),
                'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
            )); ?>

    
        <?php $this->endWidget(); ?>
        
        
        </div>
        
    </div>
</div>

