<?php

echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->nombre."</td>";

	switch ($data->estado)
	{
	case 0:
		echo "<td> Inactivo </td>";
	  	break;
	case 1:
		echo "<td> Activo </td>";
	  	break;
	}	 

	echo '<td>'.$data->peso.'</td>';
	
	switch ($data->destacado)
	{
	case 0:
		echo "<td> No </td>";
	  	break;
	case 1:
		echo "<td> Si </td>";
	  	break;
	}	 
	
	$marca = Marca::model()->findByPk($data->marca_id);
	
	echo "<td>".$marca->nombre."</td>"; 

	$inventario = Inventario::model()->findByAttributes(array('producto_id'=>$data->id));
	if(isset($inventario))
		echo "<td>".$inventario->cantidad."</td>"; 
	else
		echo "<td>0</td>";
	
	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.$data->getUrl().'" ><i class="glyphicon glyphicon-zoom-in"></i> Ver </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/calificaciones',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-star"></i> Calificaciones </a></li>
		</ul>
	    </div></td>	
			';
	
echo "</tr>"; 

?>