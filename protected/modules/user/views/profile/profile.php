<?php 
$this->breadcrumbs=array(
	"Mi Perfil",
);
?>
	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-Danger text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div> 
	<?php } ?>

<div class="container">	
		<h1><?php echo $profile->first_name." ".$profile->last_name; ?></h1>
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
				
				<span class="text-muted">Miembro desde: <?php echo date('d/m/Y',strtotime($model->create_at)); ?></span>	
				
				<p class="muted">Perfil completado en: <strong><?php echo $model->profile->getPercentage(); ?>%</strong></p>
				<div class="progress">
					<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $model->profile->getPercentage(); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $model->profile->getPercentage(); ?>%;">
					</div>
				</div>
				
				<?php
					$redes = Redes::model()->findAllByAttributes(array('users_id'=>$model->id));
					
					foreach($redes as $red)
					{
						$tipo = TipoRedes::model()->findByPk($red->tipo_id);
						echo $tipo->nombre.' | <a href="'.$red->valor.'">'.$red->valor.'</a><br/>'; 
					}
				?>
				<hr class="no_margin_top" />
				<p>Usuario <?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status)); ?></p>
				<hr class="no_margin_top" />
			</section>
			<section class="col-md-8">
				<!-- Wishlsit ON -->
				<h3 class="no_margin">Productos en listas de deseos:</h3>
				<hr class="no_margin_top" />
				<div class="row-fluid padding_small">
					<?php 
					$wish = new Wishlist;
					
					$dataProvider = $wish->CuatroProductos($model->id);
					
					if($dataProvider != false){
						if(count($dataProvider->getData())>0){	
							foreach($dataProvider->getData() as $row){
								$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$row['id']));
	    						$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"170", "width" => "170"));
							?>
							<?php $producto = Producto::model()->findByPk($row['id']); ?>
								<div class="col-sm-6 col-md-3">
										<div class="thumbnails margin_left_small">
											<a href="<?php echo $producto->getUrl(); ?>"><?php echo $im; ?></a>
											<div class="caption">
												<h5><a href="<?php echo $producto->getUrl(); ?>"><?php echo $row['nombre']; ?></a></h5>
											</div>
										</div>
								</div>
							<?php
							}
						}
						else
							echo '<div class="padding_left_small"><h5> El usuario no tiene ningun producto en listas de deseos.</h5></div>';								
					}
					else
						echo '<div class="padding_left_small"><h5> El usuario no tiene ningun producto en listas de deseos.</h5><div>';	
					
					?>		
																	
				</div>
				<!-- Wishlsit OFF -->
				<!-- Productos comprados -->
				<h3>Productos comprados:</h3>
				<hr class="no_margin_top" />
				<div class="row-fluid padding_small">
					<?php 
					$orden = new Orden;
					
					$dataProvider = $orden->CuatroComprados($model->id);
					if($dataProvider != false){
						if(count($dataProvider->getData())>0){	
							foreach($dataProvider->getData() as $row){
								$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$row['id']));
	    							
								if($principal->getUrl())
									$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"170", "width" => "170"));
								else 
									$im = '<img src="http://placehold.it/170x170" alt="..."">';
							
							?>
								<div class="col-sm-6 col-md-3">
									<div class="thumbnails margin_left_small">
									<?php $producto = Producto::model()->findByPk($row['id']); ?>
										<a href="<?php echo $producto->getUrl(); ?>"><?php echo $im; ?></a>	
										<div class="caption margin_left_small">
											<h5><a href="<?php echo $producto->getUrl(); ?>"><?php echo $row['nombre']; ?></a></h5>
										</div>
									</div>
								</div>
								
							<?php
							} 
						}
						else
							echo '<div class="padding_left_small"><h5> El usuario no ha realizado ninguna compra.</h5></div>';								
					}
					else
						echo '<div class="padding_left_small"><h5> El usuario no ha realizado ninguna compra.</h5><div>';	
					
					?>													
				</div>
				<!-- Productos comprados -->				
			</section>
		</div>
		</div></div>
