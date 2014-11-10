<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);

?>

<div class="container margin_top">	
		<h1><?php echo $profile->first_name." ".$profile->last_name; ?></h1>
		<div class="row">
			<section class="caja col-md-3" role="main">
				<figure>
					<?php 
	                	if($model->avatar_url){
	                		echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar");
	                	}else{
	                		echo '<img src="http://placehold.it/300x300" class="img-responsive" alt="Responsive image">';
						}
                	?>
				</figure>
				
				<span class="text-muted">Miembro desde: <?php echo date('d/m/Y',strtotime($model->create_at)); ?></span>	
				
				<p class="muted">Ranking: <strong>54%</strong></p>
				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 54%;">
					</div>
				</div>
				
				<?php
					$redes = Redes::model()->findAllByAttributes(array('users_id'=>$model->id));
					
					foreach($redes as $red)
					{
						$tipo = TipoRedes::model()->findByPk($red->tipo_id);
						echo $tipo->nombre.' | '.$red->valor; 
					}
				?>
				
				<!-- <a href="#">Facebook</a> | <a href="#">Twitter</a> -->
				<hr>
				<p>Usuario <?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status)); ?></p>
				<hr>
				<h6>Actividad</h6>
				Reviews <a href="#">23</a>
			</section>
			<section class="col-md-9">
				<!-- Wishlsit ON -->
				<h3>Productos en listas de deseos:</h3>
				<div class="row padding_small">
					<?php 
					$wish = new Wishlist;
					
					$dataProvider = $wish->CuatroProductos($model->id);
					
					if($dataProvider != false)
					{
						if(count($dataProvider->getData())>0){	
							
							foreach($dataProvider->getData() as $row)
							{
								$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$row['id']));
	    							
								if($principal->getUrl())
									$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"170", "width" => "170"));
								else 
									$im = '<img src="http://placehold.it/170x170" alt="...">';
							
							?>
								<div class="col-sm-6 col-md-3">
								<?php echo "<a href='".Yii::app()->baseUrl.'/producto/detalle/'.$row['id']."'>";	?>
										<div class="thumbnail">
											<?php echo $im; ?>
											<div class="caption">
												<h4><?php echo $row['nombre']; ?></h4>
												<?php
												if(strlen($row['descripcion']) > 35)
													echo "<p>".substr($row['descripcion'],0,30).' ... </p>';
												else
													echo '<p>'.$row['descripcion'].'</p>';											
											?>
											</div>
										</div>
									</a>
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
				<div class="row padding_small">
					<?php 
					$orden = new Orden;
					
					$dataProvider = $orden->CuatroComprados($model->id);
					
					if($dataProvider != false)
					{
						if(count($dataProvider->getData())>0){	
							
							foreach($dataProvider->getData() as $row)
							{
								$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$row['id']));
	    							
								if($principal->getUrl())
									$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("height"=>"170", "width" => "170"));
								else 
									$im = '<img src="http://placehold.it/170x170" alt="...">';
							
							?>
								<div class="col-sm-6 col-md-3">
								<?php echo "<a href='".Yii::app()->baseUrl.'/producto/detalle/'.$row['id']."'>";	?>	
									<div class="thumbnail">
										<?php echo $im; ?>
										<div class="caption">
											<h4><?php echo $row['nombre']; ?></h4>
											<?php
											if(strlen($row['descripcion']) > 35)
												echo "<p>".substr($row['descripcion'],0,30).' ... </p>';
											else
												echo '<p>'.$row['descripcion'].'</p>';											
										?>
										</div>
									</div>
								</a>
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
	</div>
