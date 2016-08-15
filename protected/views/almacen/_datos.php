<?php

$ima ='';

echo"<tr>";

   	echo "<td>".$data->empresas->razon_social."</td>";
	echo "<td>".$data->nombre."</td>";
	echo "<td>".$data->alias."</td>";
   	echo "<td>".$data->ubicacion."</td>";

	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/almacen/update',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		 
			';
	
echo"</tr>";

// esto se comento porque no queremos borrar los almacenes
// <li><a tabindex="-1" href="'.Yii::app()->createUrl('/almacen/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Desactivar </a></li>
?>