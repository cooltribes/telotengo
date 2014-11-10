<?php

echo"<tr>";
	echo '<td>'.$data->user->profile->first_name.' '.$data->user->profile->last_name.'</td>';
	echo "<td>".$data->user->email."</td>";
	echo '<td>'.$data->puntuacion.'</td>';
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/eliminarCalificacion',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>
			';
	
echo "</tr>";

?>