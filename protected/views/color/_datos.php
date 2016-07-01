<?php

$ima ='';

echo"<tr>";
   	
   	echo "<td>".$data->nombre."</td>";
   	
   	if($data->activo==1)
	{
		$status="Desactivar";
		echo "<td> Activo </td>";	
	}
	else
	{
		$status="activar";
		echo "<td> Inactivo </td>";
	}


	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/color/update',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/color/borrar',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-pencil"></i>' .$status.'</a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		 
			';
	
echo"</tr>";

?> 
