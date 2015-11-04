<div class="modal-header no_border no_padding_bottom row-fluid">
    <h3 class="no_margin_top col-md-11">Nuevo Avatar</h3>
    <div class="col-md-1"><button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
</div>

<hr class="no_margin_top"/>
    <div class="padding_small modal-body no_padding row-fluid">
        
		<div class="row-fluid">
			<section class="col-md-4">
				<figure class="card">
					<?php 
	                	if($model->avatar_url){
	                		echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('width'=>'70%','style'=>'border-radius: 50px;'));
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
	<div class="col-md-6 col-md-offset-3 margin_top_small"> 
	    <label> Imagen </label>
			<?php                       
			echo CHtml::activeFileField($model, 'avatar_url',array('name'=>'imagen'));			
			?>
			<span class="help-inline error" id="Categoria_imagen_url_em_" style="display: none">Debes elegir una imagen</span>
    </div>
    
    	<div class="col-md-6 col-md-offset-3 margin_top">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Subir Imagen',
			'htmlOptions'=>array('class'=>'form-control','id'=>'guardar')
		)); ?>            		
                	
	</div>
    <?php $this->endWidget(); ?>
        
        
        </div>
        
    </div>
</div>

