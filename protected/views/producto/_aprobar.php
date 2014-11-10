<?php

echo"<tr>";
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
	
	$user = User::model()->findByPk($data->users_id);
	
	echo '<td>'.$user->profile->first_name." ".$user->profile->last_name.'</td>';
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/detalle',array('id'=>$data->id)).'" ><i class="icon-cog"></i> Ver </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/create',array('id'=>$data->id)).'" ><i class="icon-trash"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/aprobar',array('id'=>$data->id)).'" ><i class="icon-cog"></i> Aprobar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/rechazar',array('id'=>$data->id)).'" ><i class="icon-trash"></i> Rechazar </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
	
echo "</tr>";

?>