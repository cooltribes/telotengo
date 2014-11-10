<?php

echo"<tr>";
   	echo "<td>".$data->id."</td>";
	echo "<td>".$data->ubicacion."</td>";
   	echo "<td>".$data->alias."</td>";
	
	?>
	<td>
		<div class="dropdown">
			<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
				<i class="icon-cog"></i> <b class="caret"></b>
			</a> 

			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><?php echo CHtml::link('<i class="icon-cog"></i> Editar', $this->createUrl('update', array('id'=>$data->id)), array('class'=>'btn')); ?></li>
				<li>
					<?php
					$this->widget('bootstrap.widgets.TbButton', array(
								'buttonType'=>'ajaxLink',
								'icon'=>'trash',
								'url'=>$this->createUrl('almacen/delete'),
								'htmlOptions'=>array('class'=>'btn'),
								'label'=>'Eliminar',
								'ajaxOptions'=>array(
									'type' => 'POST',
									'data' => array( 
								        'id' => $data->id
								    ),
										'success'=>'js:function(data){
											$.fn.yiiListView.update("list-auth-empresas",{});
										}',
									),
							)); 
					?>
				</li>
			</ul>
		</div>
	</td>
	<?php
	
echo"</tr>";

?>