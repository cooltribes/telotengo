<?php /*$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
	
	if($_GET['solicitud']=="nueva")
		$mensaje="Crea tu Contraseña";
	else
		$mensaje="Cambiar contraseña";
	
	$this->breadcrumbs=array(
		'Iniciar sesión' => array('/user/login'),
		$mensaje
	);*/
	$mensaje="Crea tu contraseña";
	?>
<div class="col-md-6 col-md-offset-3 margin_top_large orangepanel">
        <h4 class="text-center margin_top margin_bottom">
            <?php echo $mensaje; ?>
        </h4>
    <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($form); ?>
        

        <?php echo CHtml::activePasswordField($form,'password', array('class'=>'form-control', 'placeholder'=>'Introduce tu nueva contraseña')); ?>
        <p class="hint">
        <!-- <small><?php echo 'Al menos 4 caracteres'; ?></small> -->
        </p>
      
        

        <?php echo CHtml::activePasswordField($form,'verifyPassword', array('class'=>'form-control margin_top_small', 'placeholder'=>'Repite la contraseña')); ?>
      
        <div class="text-center margin_top margin_bottom_large">
            <?php echo CHtml::submitButton('Crear',array('class'=>'btn-black btn btn-danger btn-large padding_left padding_right')); ?>
        </div>
        

        


    <?php echo CHtml::endForm(); ?>
        
</div>