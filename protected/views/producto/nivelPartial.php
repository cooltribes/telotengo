<?php $nivel+=1;?>

		<?php 
		$categorias = Categoria::model()->findAllByAttributes(array('id_padre' => $id)); 
		if(isset($categorias))
		{
			foreach($categorias as $cate)
			{
				if($cate->ultimo==0)
				{ ?>
					<a href="#" id="cate<?php echo $cate->id;?>" onclick="buscar(<?php echo $cate->id;?>, <?php echo $nivel;?>,'cate<?php echo $cate->id;?>')" ><?php echo $cate->nombre; ?></a>
				<?php	
				}
				else 
				{
				?>
					<a href="#" id="cate<?php echo $cate->id;?>"  onclick="seleccion(<?php echo $cate->id;?>,'cate<?php echo $cate->id;?>')" > <?php echo $cate->nombre; ?></a>
			<?php
				}
			}	
		}
		?>
