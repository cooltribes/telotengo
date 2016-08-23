<div class="modal-header no_border no_padding_bottom">
     <button type="button" class="close pull-right no_margin_top" data-dismiss="modal" aria-hidden="true">&times;</button>
     <h3>Nuevo Avatar</h3>
   
  
</div>

<hr class="no_margin_top"/>
    <div class="padding_small modal-body no_padding text-center">        

				<figure class="clearfix">
					<?php 
	                	if($model->avatar_url){
	                		echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('height'=>'100%','style'=>''));
	                	}else{
	                		echo '<img src="http://placehold.it/300x300" class="img-responsive" alt="Responsive image">';
						}
                	?>
				</figure>
				
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>false,  
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>		
 
			<?php                       
			echo CHtml::activeFileField($model, 'avatar_url',array('name'=>'imagen','class'=>"margin_top margin_left"));			
			?>
			<span class="help-inline error form-control" id="Categoria_imagen_url_em_" style="display: none">Debes elegir una imagen</span>
 
    

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Subir Imagen',
			'htmlOptions'=>array('class'=>'btn-orange white margin_top_small','id'=>'guardar')
		)); ?>            		
                	

    <?php $this->endWidget(); ?>
    
        
        </div>
        