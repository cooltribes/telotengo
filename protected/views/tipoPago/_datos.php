<?php

$ima ='';

echo"<tr>";
	
		echo "<td>".$data->id."</td>";
	
	$ima = CHtml::image(Yii::app()->baseUrl.'/images/tipopago/'.$data->id.'_thumb.jpg', $data->nombre);

	if(isset($ima))
   		echo "<td>".$ima."</td>";
	else
		echo '<td><img src="http://placehold.it/100" align="Nombre de la categoria"/> </td>';
   	
   
   	echo "<td>".$data->nombre."</td>";
	/*echo "<td>".$data->url_amigable."</td>";
		*/
	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/tipopago/create',array('id'=>$data->id)).'" ><i class="icon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/tipopago/delete',array('id'=>$data->id)).'" ><i class="icon-trash"></i> Eliminar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>