<tr>
	<td><?php echo $data->caracteristica->nombre; ?></td>
	<td>
		<?php
		if($data->producto->estado == 0){
			?>
			<div class="dropdown">
				<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
					<i class="icon-cog"></i> <b class="caret"></b>
				</a> 

				
				<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
					<!-- <li>
						<a tabindex="-1" href="#" onclick="editar(<?php //echo $data->id; ?>)"><i class="icon-cog"></i> Editar </a>
					</li> -->
					
					<li>
						<?php
						$this->widget('bootstrap.widgets.TbButton', array(
									'buttonType'=>'ajaxLink',
									'icon'=>'trash',
									'url'=>$this->createUrl('producto/eliminarCaracteristica/id/'.$data->id),
									'htmlOptions'=>array('class'=>'btn'),
									'label'=>'Eliminar',
									'ajaxOptions'=>array(
											'success'=>'js:function(data){
												$.fn.yiiListView.update("list-auth-caracteristicas",{});
											}',
										),
								)); 
						?>
					</li>
				</ul>
	        </div>
	        <?php
		}else{
			echo 'No hay acciones disponibles';
		}
		?>
	</td>
</tr>