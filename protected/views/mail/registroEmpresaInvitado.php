 <div>

               
                         <h1 style="margin-bottom: 1px; margin-top:35px">
                            ¡Bienvenido <?php echo Yii::app()->session['email']; ?>!
                         </h1>
                         <hr style="margin-top:0px; border-top:#DDD;"/> 
                         
                         <div style="width:100%; margin-top:35px; font-size:14px">
                         <p align="justify">
                         <?php
                         if(Yii::app()->user->isAdmin())
						 {?>
						 	<p>
							Has sido invitado a participar en Telotengo, formando parte de  <?php echo Empresas::model()->findByPk($empresa_id)->razon_social; ?>. Telotengo es una tienda online creada exclusivamente para Empresas.</p>
							Haz clic <b><a href="<?php echo $activation_url; ?>">aquí</a></b> si deseas registrarte y disfrutar de nuestros servicios.
							
						<?php
						 }
						 else 
						 {		
							    $user=User::model()->findByAttributes(array('email'=>Yii::app()->session['quienInvita']));
							    echo Profile::model()->retornarNombreCompleto($user->id);?> te ha invitado a participar en Telotengo formando parte de <?php echo Empresas::model()->findByPk($empresa_id)->razon_social; ?>.
								 Telotengo es una tienda online creada exclusivamente para Empresas.
								<br><br>
								Haz clic <b><a href="<?php echo $activation_url; ?>">aquí</a></b> si deseas registrarte y disfrutar de nuestros servicios.
								<?php
						 }
                         
                          ?>
                         </p>

                         	
                         
                         </div>
   </div>