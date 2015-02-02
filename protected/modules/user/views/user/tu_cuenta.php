<div class="container margin_top tu_perfil">
    <div class="page-header">
        <h1>Tu Cuenta</h1>     
    </div>
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
		    <div class="alert in alert-block fade alert-error text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } ?>

    <div class="row-fluid">
        <aside class="col-lg-3">
            <div>            	
                <div class="card">
                	<?php 
	                	if($model->avatar_url){
	                		echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('width'=>'100%','style'=>'border-radius: 50px;'));
	                	}else{
	                		echo '<img src="http://placehold.it/300x300" width="100%" class="img-responsive" alt="Responsive image">';
						}
                        
                	?><div title="Cambiar avatar" class="text-center foot_option" onclick="$('#changeAvatar').modal()"><span class="glyphicon glyphicon-open"></span></div>
                	
                    <div class="card_content vcard" style="color:white">
                        <h4 class="fn"><?php echo $model->profile->first_name." ".$model->profile->last_name; ?></h4>
                        <p class="muted">Miembro desde: <?php echo date('d/m/Y', strtotime($model->create_at)); ?></p>
                        
                       	<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
						    60%
						  	</div>
						</div>
						
						
						
						<p class="muted">60% del perfil completado.</p>
                        
                    </div>
                </div>
                <hr/>
                <h5>Tu actividad</h5>
                <aside class="card">
                	                    
                    <?php $this->widget('bootstrap.widgets.TbMenu', array(
					    'type'=>'list',
					    'items'=>array(
					        array('label'=>'Compras', 'active'=>false),
					        array('label'=>' Pedidos y Devoluciones', 'icon'=>'glyphicon glyphicon-gift', 'url'=>Yii::app()->baseUrl.'/orden/listado'),
					        //array('label'=>' Calificar a un vendedor', 'icon'=>'glyphicon glyphicon-thumbs-up', 'url'=>'#'),
					        
					        //array('label'=>'Pagos y Balance', 'active'=>false),
					        //array('label'=>' Preferencias de pago', 'icon'=>'glyphicon glyphicon-check', 'url'=>'#'),
					        array('label'=>' Tarjetas de regalo', 'icon'=>'glyphicon glyphicon-credit-card', 'url'=>Yii::app()->baseUrl.'/giftcard/comprar'),
					        
							array('label'=>'Preferencias', 'active'=>false),
					        array('label'=>' Lista de Deseos', 'icon'=>'glyphicon glyphicon-folder-open', 'url'=>Yii::app()->baseUrl.'/wishlist/listado'),
					        array('label'=>' Favoritos', 'icon'=>'glyphicon glyphicon-file', 'url'=>Yii::app()->baseUrl.'/user/user/favoritos'),
							
							array('label'=>'Configuración de la cuenta', 'active'=>true),
							array('label'=>' Avatar', 'icon'=>'glyphicon glyphicon-user', 'url'=>Yii::app()->baseUrl.'/user/user/avatar'),
					        array('label'=>' Datos Personales', 'icon'=>'glyphicon glyphicon-ok', 'url'=>Yii::app()->baseUrl.'/user/profile/edit'),
					        array('label'=>' Direcciones', 'icon'=>'glyphicon glyphicon-list-alt', 'url'=>Yii::app()->baseUrl.'/direccionEnvio/listado'),
					        array('label'=>' Redes Sociales', 'icon'=>'glyphicon glyphicon-tags', 'url'=>Yii::app()->baseUrl.'/user/user/agregarsocial'),
					        array('label'=>' Privacidad', 'icon'=>'glyphicon glyphicon-cog', 'url'=>Yii::app()->baseUrl.'/user/user/privacidad'),
							
							array('label'=>'Ayuda', 'active'=>false),
					        array('label'=>'Preguntas Frencuentes', 'icon'=>'glyphicon glyphicon-th', 'url'=>'#'),
					        array('label'=>'¿Cómo funciona?', 'icon'=>'glyphicon glyphicon-question-sign', 'url'=>'#'),
					        array('label'=>'Servicio al cliente', 'icon'=>'glyphicon glyphicon-bookmark', 'url'=>'#'),
						),
					)); ?>
                    
                </aside>
                <hr/>
               
            </div>
        </aside>
        <div class="col-lg-9">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table no_border">
   
    <tr>
      	<td><p class=""><?php echo "1"; ?></p> Pedidos Activos </td>
      	<td><p class=""><?php echo "1"; ?></p> Pagos Requeridos </td>
      	<td><p class=""><?php echo "1"; ?></p> Entregas Sin Confirmar </td>
      	<td><p class=""><?php echo "1"; ?></p> Compras Sin Calificar </td>
		<td><p class=""><?php echo "1"; ?></p> Entregas Sin Calificar </td>
    </tr>
</table> 
    <section class="bg_color3 margin_bottom_small padding_small box_1">
    	<h3> Saldo total disponible </h3>
    	<h5><?php echo Balance::model()->getTotal(); ?> Bs.</h5> 
    </section>
    <section class="bg_color3 margin_bottom_small padding_small box_1">
    <?php if($provider->totalItemCount>0): ?> 
        
		
		<h3> Redes sociales registradas </h3>
					
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
	    <span>No tienes redes sociales en tu perfil, regístralas <a href="#">aquí</a>...</span>			 	    
    
    <?php endif; ?>     
	</section> 
	
<section class="bg_color3 margin_bottom_small padding_small box_1">	
		
		<h3> Productos que te pueden gustar </h3>
		</hr>
		
<ul class="thumbnails">
	
    <? foreach($productos as $producto): ?>
	<li class="span2">
    	<a href="#" class="thumbnail"><img src="http://placehold.it/200x200" alt=""></a>
	</li>
  	<?php endforeach; ?>
  	
</ul>
	
</section>	
        </div>
    </div>
</div>
    <div id="changeAvatar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <?php echo $this->renderPartial('avatar', array( 'model'=>$model ),true); ?>
    </div>
<!-- /container -->
