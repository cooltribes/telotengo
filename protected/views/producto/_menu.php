	<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), 
        ),
    )
); ?>	
<!-- FLASH OFF -->


    <ul class="nav nav-tabs margin_top">
        <li id="" class=<?php if($activo == 'informacion_general') echo 'active'; ?>><?php echo CHtml::link('Información General',array('create','id'=>$model->id)); ?></li>
		<li id="" class="<?php if($activo=='imagenes') echo 'active'; ?>"><?php echo CHtml::link('Imágenes',array('imagenes','id'=>$model->id,)); ?></li>
        
        <?php
        	if(Yii::app()->user->id == 1){ // es admin
        ?>
        <li id="" class="<?php if($activo=='seo') echo 'active'; ?>"><?php echo CHtml::link('SEO',array('seo','id'=>$model->id,)); ?>
        	 
        </li>
        <?php } ?>
        
        <li id="" class=<?php if($activo == 'caracteristicas') echo 'active'; ?>><?php echo CHtml::link('Características',array('caracteristicas','id'=>$model->id,)); ?></li>
    </ul>

