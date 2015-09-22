<?php

$ima ='';

echo"<tr>";
	
	$ima = CHtml::image(Yii::app()->baseUrl.'/images/categoria/'.$data->id.'/'.str_replace(".jpg","",$data->imagen_url).'_thumb.jpg', $data->nombre);
	$link=Yii::app()->getBaseUrl(true).'/images/categoria/'.$data->id.'/'.str_replace(".jpg","",$data->imagen_url).'_thumb.jpg';
	$file_headers = @get_headers($link);
	if($file_headers[0] == 'HTTP/1.1 200 OK') {
	    $exists = true;
	}
	else {
	    $exists = false;
	}
		if($exists)
   			echo "<td>".$ima."</td>";
		else
   			echo "<td><img src='http://placehold.it/150x150'></td>";
		
   	echo "<td>".$data->nombre."</td>";
	echo "<td>".$data->url_amigable."</td>";
	
	if($data->destacado == 1)
		echo "<td> Destacado </td>";
	else
		echo "<td> No Destacado </td>";
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/categoria/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/categoria/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>