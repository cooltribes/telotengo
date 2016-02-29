
<!-- FLASH OFF -->
<?php if(Yii::app()->user->isAdmin()):?>
    <ul class="nav nav-tabs margin_top">
        <li id="" class=<?php if($activo == 'informacion_general') echo 'active'; ?>><?php echo CHtml::link('Información Vital',array('create','id'=>$model->id)); ?></li>
		<?php if(!$model->isNewRecord): ?> 
		<li id="" class="<?php if($activo=='imagenes') echo 'active'; ?>"><?php echo CHtml::link('Imágenes',array('imagenes','id'=>$model->id,)); ?></li>
        <li id="" class="<?php if($activo=='seo') echo 'active'; ?>"><?php echo CHtml::link('SEO',array('seo','id'=>$model->id,)); ?></li> 
        <li id="" class="<?php if($activo=='caracteristicas') echo 'active'; ?>"><?php echo CHtml::link('Caracteristicas',array('caracteristicas','id'=>$model->id,)); ?></li> 	
   
       <li id="" class="<?php if($activo=='detalles') echo 'active'; ?>"><?php echo CHtml::link('Mas Detalles',array('details','id'=>$model->id,)); ?></li>
       <?php endif; ?>
       <!-- <li id="" class=<?php // if($activo == 'caracteristicas') echo 'active'; ?>><?php // echo CHtml::link('Características',array('caracteristicas','id'=>$model->id,)); ?></li> -->
    </ul>
<?php else: ?>
    <ul class="nav nav-tabs margin_top">
         <?php if(!$model->isNewRecord): ?> 
        <li id="" class="<?php if($activo=='imagenes') echo 'active'; ?>"><?php echo CHtml::link('Imágenes',array('imagenes','id'=>$model->id,)); ?></li>
     
        <li id="" class="<?php if($activo=='caracteristicas') echo 'active'; ?>"><?php echo CHtml::link('Caracteristicas',array('caracteristicas','id'=>$model->id,)); ?></li>  
     <?php if($model->aprobado): ?>   

    <?php endif; ?>  
       <li id="" class="<?php if($activo=='detalles') echo 'active'; ?>"><?php echo CHtml::link('Mas Detalles',array('details','id'=>$model->id,)); ?></li>
       <?php endif; ?>
       <!-- <li id="" class=<?php // if($activo == 'caracteristicas') echo 'active'; ?>><?php // echo CHtml::link('Características',array('caracteristicas','id'=>$model->id,)); ?></li> -->
    </ul>
<?php endif; ?>
