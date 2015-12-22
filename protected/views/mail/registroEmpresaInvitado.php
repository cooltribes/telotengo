 <div>

               
                         <h1 style="margin-bottom: 1px; margin-left:1%; margin-top:35px">
                            ¡Bienvenido <?php echo Yii::app()->session['email']; ?>
                         </h1>
                         <hr style="margin-top:0px; border-top:#DDD;"/> 
                         
                         <div style="width:100%; margin-top:35px; font-size:14px">
                         <?php
                         if(Yii::app()->user->isAdmin())
						 {?>
						 	
							Has sido invitado a formar parte de Telotengo a través de <?php echo Empresas::model()->findByPk($empresa_id)->razon_social; ?>.Telotengo es una tienda online creada únicamente para Empresas.
							Haz clic <b><a href="<?php echo $activation_url; ?>">aquí</a></b> si deseas registrarte y disfrutar de nuestros servicios.
							
						<?php
						 }
						 else 
						 {
							    echo Yii::app()->session['quienInvita'];?> te ha ha invitado a formar parte de Telotengo, a través de <?php echo Empresas::model()->findByPk($empresa_id)->razon_social; ?>.
								Telotengo es una tienda online creada únicamente para Empresas.

								Haz clic <b><a href="<?php echo $activation_url; ?>">aquí</a></b> si deseas registrarte y disfrutar de nuestros servicios.
								<?php
						 }
                         
                          ?>


                         	
                         
                         </div>
   </div>