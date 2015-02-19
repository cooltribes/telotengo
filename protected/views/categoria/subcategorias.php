<!-- CONTENIDO ON -->
<div class="container">
	
	<?php

	$categorias = Categoria::model()->findByPk($categoria);

	echo '<p><img src="'.Yii::app()->baseUrl.'/images/categoria/'.$categorias->imagen_url.'"/></p>';
	?>

	<table border="0">
		<tbody>
			<tr> 
			<?php
			$contador = 0;
		    
		    $hijos = Categoria::model()->findAllByAttributes(array('id_padre'=>$categoria));
		    
		    if(sizeof($hijos) > 0){ // hijos de cada categoria
			    foreach ($hijos as $hijo){

			    	if($contador > 2){
						echo "</tr><tr>";
						$contador=0;
					}

			    	$contador++;
			    	?>
			    	<td>
						<a title="Ir a <?php echo $categorias->nombre; ?>" href="<?php echo Yii::app()->baseUrl."/categorias/".$hijo->url_amigable; ?>" target="_self">
							<img title="<?php echo $categorias->nombre; ?>" src="<?php echo Yii::app()->baseUrl."/images/categoria/".$hijo->imagen_url; ?>" alt="E<?php echo $categorias->nombre; ?>" />
						</a>
					</td>
			    	<?php
		        }
		    }
			?>	
			</tr>
		</tbody>
	</table>
</div>