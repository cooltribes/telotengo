<?php $nivel+=1;?>

		<?php 
		$categorias = Categoria::model()->findAllByAttributes(array('id_padre' => $id));
		if(isset($categorias))
		{
			foreach($categorias as $cate)
			{
				if($cate->ultimo==0)
				{ ?>
					<a href="#" onclick="buscar(<?php echo $cate->id;?>, <?php echo $nivel;?>)" > <br> <?php echo $cate->nombre; ?><br></a>
				<?php	
				}
				else 
				{
				?>
					<a href="#" onclick="seleccion(<?php echo $cate->id;?>)" > <br> <?php echo $cate->nombre; ?><br></a>
			<?php
				}
			}	
		}
		?>
