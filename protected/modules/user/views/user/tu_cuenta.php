<div class="container margin_top tu_perfil">
    <div>
        <h1 class="no_margin_bottom">Tu Cuenta
        <small class="pull-right margin_top_xsmall">Saldo disponible: <b><?php echo Balance::model()->getTotal(); ?>  Bs.</b></small></h1>
    </div>
    <hr class="no_margin_top"/>
<?php
$this->breadcrumbs=array(
	'Tu Cuenta',
);
?>
		<?php if(Yii::app()->user->hasFlash('success')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
		    <div class="alert in alert-block fade alert-danger text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } ?>

    <div class="row-fluid margin_top_medium">
    <div class="col-md-9">
        <div class="row-fluid">    
            <aside class="col-md-4">
          	
                    <div class="card">
                    	<?php 
    	                	if($model->avatar_url){
    	                		echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('width'=>'100%','style'=>'border-radius: 50px;'));
    	                	}else{
    	                		echo '<img src="http://placehold.it/300x300" width="100%" class="img-responsive" alt="Responsive image">';
    						}
                            
                    	?><div title="Cambiar avatar" class="text-center foot_option" onclick="$('#changeAvatar').modal()"><span class="glyphicon glyphicon-open"></span></div>
                    	
                        <div class="card_content vcard">
                            <h4 class="fn"><b><?php echo $model->profile->first_name." ".$model->profile->last_name; ?></b></h4>
                            <p class="muted">Miembro desde: <?php echo date('d/m/Y', strtotime($model->create_at)); ?></p>
                            
                           	<div class="progress">
    							<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $model->profile->getPercentage(); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $model->profile->getPercentage(); ?>%;">
    						    <?php echo $model->profile->getPercentage(); ?>%
    						  	</div>
    						</div>					
    						<p class="muted margin_top_minus"><small><?php echo $model->profile->getPercentage()."% del perfil completado."; ?></small></p>
                            
                        </div>
                    </div>

            </aside>
            <div class="col-md-8">
               <div class="row-fluid">
                   <div class="col-md-10 col-md-offset-1">
                       <h4 class="no_margin_bottom"><b>Resumen</b></h4><hr class="no_margin_top"/>
                       <table border="0" cellspacing="0" cellpadding="0" class="table no_border">
                        <?php
                            $orden = new Orden; 
                            $ordengc = new OrdenGC;
                            $user = User::model()->findByPk(Yii::app()->user->id);
                        ?>
                            <tr>
                                <td class="no_border" ><b>Pedidos Activos</b> </td>
                                <td class="no_border"><?php echo $orden->totalActivos(); ?></td>
                            </tr>
                            <tr>     
                                <td><b>Pagos Requeridos</b> </td>
                                <td><?php echo $orden->pagosRequeridos(); ?></td>
                            </tr>
                            <tr>
                                <td ><b>Giftcards compradas</b></td>
                                <td><?php echo $ordengc->total(); ?></td>
                            </tr>
                            <tr>
                                <td><b>Giftcards por pagar</b></td>
                                <td><?php echo $ordengc->porPagar(); ?> </td>
                            </tr>
                            <tr>
                                <td><b>Productos en Listas</b></td>
                                <td><?php echo $user->cantidadListas(); ?> </td>
                            </tr>   
                            <tr>
                                <td><b>Productos en Carrito de compras</b></td>
                                <td><?php echo $user->cantidadCarro(); ?> </td>
                            </tr>                   
                        </table>
                    </div>
               </div>
            </div>
       </div>
       <div>
            <section>
                <h3 class="no_margin_bottom">Redes sociales registradas</h3><hr class="no_margin_top"/>
                <?php if($provider->totalItemCount>0): ?> 
                            <?php
                            $template2 = '{summary}
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                {items}
                                </table>
                                {pager} 
                                ';
                        
                                    $this->widget('zii.widgets.CListView', array(
                                    'id'=>'list-auth-redes',
                                    'dataProvider'=>$provider,
                                    'itemView'=>'_datos_social',
                                    'template'=>$template2,
                                    'enableSorting'=>'true',
                                    'afterAjaxUpdate'=>" function(id, data) {
                                                       
                                                        } ",
                                    'pager'=>array(
                                        'header'=>'',
                                        'htmlOptions'=>array(
                                        'class'=>'pagination pagination-right',
                                    )
                                    ),                  
                                ));
                                
                                ?>
                <?php else: ?>
                 <div class="alert alert-info"><span>No tienes redes sociales en tu perfil, regístralas <b><a href="agregarsocial">aquí</a></b>...</span> </div>                   
                
                <?php endif; ?>     
        </section>
            <section class="margin_top_large">  
        
                    <h3 class="no_margin_bottom">Productos recomendados para tí</h3><hr class="no_margin_top"/>
                    </hr>
                    
                <ul class="thumbnails">
                    
                    <? foreach($productos as $producto): ?>
                    <li class="span2">
                        <a href="#" class="thumbnail autoHeight"><img src="http://placehold.it/200x200" alt=""></a>
                    </li>
                    <?php endforeach; ?>
                    
                </ul>
                
            </section>
           
       </div>
   </div> 

        <aside  class="col-md-3 well bg_white">
            <h4 class="no_margin_bottom"><b>Tu actividad</b></h4><hr class="no_margin_top"/>
                <div class="card">
                                        
                    <?php $this->widget('bootstrap.widgets.TbMenu', array(
                        'type'=>'list',
                        'items'=>array(
                            array('label'=>'Compras', 'active'=>false),
                            array('label'=>' Pedidos y Devoluciones', 'icon'=>'glyphicon glyphicon-gift', 'url'=>Yii::app()->baseUrl.'/orden/listado'),
                            array('label'=>' Tarjetas de regalo', 'icon'=>'glyphicon glyphicon-credit-card', 'url'=>Yii::app()->baseUrl.'/giftcard/comprar'),
                            array('label'=>'Datos de pago', 'icon'=>'glyphicon glyphicon-usd', 'url'=>'','itemOptions'=>array('onclick'=>"$('#datosPago').modal()")), 
                            
                            array('label'=>'Preferencias', 'active'=>false),
                            array('label'=>' Lista de Deseos', 'icon'=>'glyphicon glyphicon-folder-open', 'url'=>Yii::app()->baseUrl.'/wishlist/listado'),
                            array('label'=>' Favoritos', 'icon'=>'glyphicon glyphicon-file', 'url'=>Yii::app()->baseUrl.'/user/user/favoritos'),
                            
                            array('label'=>'Configuración de la cuenta', 'active'=>true),
                            array('label'=>' Avatar', 'icon'=>'glyphicon glyphicon-user', 'url'=>'','itemOptions'=>array('onclick'=>"$('#changeAvatar').modal()")),
                            array('label'=>' Datos Personales', 'icon'=>'glyphicon glyphicon-ok', 'url'=>Yii::app()->baseUrl.'/user/profile/edit'),
                            array('label'=>' Direcciones', 'icon'=>'glyphicon glyphicon-list-alt', 'url'=>Yii::app()->baseUrl.'/direccionEnvio/listado'),
                            array('label'=>' Redes Sociales', 'icon'=>'glyphicon glyphicon-tags', 'url'=>Yii::app()->baseUrl.'/user/user/agregarsocial'),
                            array('label'=>' Privacidad', 'icon'=>'glyphicon glyphicon-cog', 'url'=>Yii::app()->baseUrl.'/user/user/privacidad'),
                            
                            array('label'=>'Ayuda', 'active'=>false),
                            array('label'=>'Preguntas Frencuentes', 'icon'=>'glyphicon glyphicon-th', 'url'=>'#'),
                            array('label'=>'¿Cómo funciona?', 'icon'=>'glyphicon glyphicon-question-sign', 'url'=>'#'),
                            array('label'=>'Servicio al cliente', 'icon'=>'glyphicon glyphicon-bookmark', 'url'=>'#'),
                            
                            array('label'=>'Salir', 'active'=>false),
                            array('label'=>'Cerrar Sesión', 'icon'=>'glyphicon glyphicon-off', 'url'=>Yii::app()->baseUrl.'/user/logout'),
                            
                        ),
                    )); ?>
                    
                </div>
        </aside>
    </div>

    <div id="changeAvatar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; min-height: 600px;">
        <?php echo $this->renderPartial('avatar', array( 'model'=>$model ),true); ?>
    </div>

    <div id="datosPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-header row-fluid">
            <h3 class="col-md-11">Datos de pago por depósito o transferencia</h3>
            <div class="col-md-1"><button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
        </div>
        <div class="modal-body">
            <div class='no_margin_top'>
            Para completar la compra debes realizar el deposito o transferencia electrónica en un máximo de 3 días a cualquiera de las siguientes <strong>cuentas corrientes</strong>:
                        <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                            <li><strong>Banesco</strong> - 0134 0261 2026 1101 8222</li>
                            <li><strong>Venezuela</strong> - 0102 0129 2500 0008 9665</li>
                            <li><strong>Mercantil</strong> - 0105 0735 9417 3503 3014</li>
                            <li><strong>Banfoandes</strong> - 0007 0147 5600 0000 3292</li>
                            <li><strong>Sofitasa</strong> - 0137 0020 6200 0900 7231</li>
                            <li><strong>100% Banco</strong> - 0156 0015 2804 0019 1722</li>
                            <li><strong>BFC C.A</strong> - 0151 0135 1530 0004 2301</li>
                            <li><strong>Banco Activo</strong> - 0171 0018 1660 0037 0854</li>
                            <li><strong>Bancaribe</strong> - 0114 0430 8443 0005 2865</li>
                            <li><strong>Provincial</strong> - 0108 0098 6001 0005 7276</li>
                            <li><strong>Venezolano de Crédito </strong>- 0104 0033 3903 3008 3417.</li>
                            <li><strong>Corpbanca/BOD</strong>- 0121 0312 3700 1338 1504</li>
                            <li><strong>Banco Exterior</strong> - 0115 0114 1410 02398498</li>
                        </ul>

                        <h4 class="margin_top_small">Datos para la transferencia:</h4>
                        <ul style="list-style-type:square" class="margin_top_small margin_left_small">
                            <li><strong>Beneficiario/Razón Social</strong>: Sigmasys C.A.</li>
                            <li><strong>Correo electrónico:</strong> info@sigmatiendas.com</li>
                            <li><strong>RIF</strong>: J-29468637-0</li>
                            <li><strong>Dirección</strong>: Avenida libertador  C.C Las Lomas local 30,  San Cristóbal,  Edo. Táchira.
                            <li><strong>Teléfono</strong>:  02763442626</li>
                        </li>
                        </ul><br/> Al depositar ingresa en tu cuenta => tus pedidos y registra tus datos.
                </div>        
        </div>
    </div>

</div>
<!-- /container -->
