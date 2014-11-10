<?php

echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->nombre."</td>";
	echo '<td>'.$data->descripcion.'</td>';
	
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
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/detalle',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-zoom-in"></i> Ver </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/calificaciones',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-star"></i> Calificaciones </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
	
echo "</tr>";

?>