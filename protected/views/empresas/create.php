<div class="row-fluid">
    <h5 class="col-md-8 col-md-offset-2 text-center">
            <?php if(isset(Yii::app()->session['quieninvita'])) 
            	{?>
            		
¡Bienvenido <?php Yii::app()->session['quieninvita'];?>Te han invitado a formar parte de Telotengo, una tienda online creada únicamente para Empresas. Donde podrás participar como vendedor, comprador o de ambas formas.
            		
            	<?php
            	}else
            	{?>
            		No hemos encontrado ningún registro de invitación a este correo electrónico, por lo que iniciaremos un proceso de validación que nos permitirá generar una para hacertela llegar a
            	<?php }?>
            
   </h5>
    <div class="col-md-6 col-md-offset-3 margin_top orangepanel">
        <h4 class="text-center">
            Por favor completa los siguientes datos personales:
        </h4>
               <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
                
    
    </div>
    
</div>
