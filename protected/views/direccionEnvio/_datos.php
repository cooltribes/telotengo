<?php

echo"<tr>";
   	echo "<td>".$data->direccion_1."</td>";
	echo "<td>".$data->direccion_2."</td>";
	
	$prov = Provincia::model()->findByPk($data->provincia_id);
   	echo "<td>".$prov->nombre."</td>";
	
	$ciud = Ciudad::model()->findByPk($data->ciudad_id);
	echo "<td>".$ciud->nombre."</td>";
	
   	echo "<td>".$data->telefono."</td>";
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="create/'.$data->id.'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="delete/'.$data->id.'" ><i class="glyphicon glyphicon-remove"></i> Eliminar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>