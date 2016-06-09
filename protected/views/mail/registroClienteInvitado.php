 <div>

               
                         <h1 style="margin-bottom: 1px; margin-left:1%; margin-top:35px">
                            ¡Bienvenido a Telotengo <?php echo Yii::app()->session['email']; ?>!
                         </h1>
                         <hr style="margin-top:0px; border-top:#DDD;"/> 
                         
                         <div style="width:100%; margin-top:35px; font-size:14px">
                         	<?php
                         	 if(Yii::app()->user->isAdmin())
						 {?>
						 	
							Has sido invitado a formar parte de Telotengo, una tienda online creada únicamente para Empresas. Donde podrás participar como vendedor, comprador o de ambas formas.
							Como vendedor tendrás las opciones de: controlar tu inventario, mostrar tus productos y venderlos, verificar todas tus órdenes de compra, además de atender los requerimientos de tus clientes. Y como comprador podrás: buscar los productos que necesites, comparar los precios por proveedor, tener tus productos en un carrito y generar las órdenes de compras que requieras.

							Haz clic <b><a href="<?php echo $activation_url; ?>">aquí</a></b> si deseas registrarte.
							
						<?php
						 }
						else
						{
							echo Yii::app()->session['quienInvita'];?> te ha invitado a formar parte de Telotengo, una tienda online creada únicamente para Empresas. Donde podrás participar como vendedor, comprador o de ambas formas.

Como vendedor tendrás las opciones de: controlar tu inventario, mostrar tus productos y venderlos, verificar todas tus órdenes de compra, además de atender los requerimientos de tus clientes. Y como comprador podrás: buscar los productos que necesites, comparar los precios por proveedor, tener tus productos en un carrito y generar las órdenes de compras que requieras.


Haz clic <b><a href="<?php echo $activation_url; ?>">aquí</a></b> si deseas registrarte.
						<?php
						}
                         	
							?>
                         	
                         
                         </div>
   </div>