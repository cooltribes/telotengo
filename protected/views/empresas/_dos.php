<?php
$empresa_user = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$data->id));
$representante = User::model()->findByPk($empresa_user->users_id);

echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->rif."</td>";
	echo '<td>'.$data->razon_social.'</td>';
	
	echo "<td>".$representante->profile->first_name.' '.$representante->profile->last_name."</td>";
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="detalles/'.$data->id.'" ><i class=""></i> Ver Detalles </a></li>
			<li><a tabindex="-1" href="#" ><i class="icon-cog"></i> Aceptar </a></li>
			<li><a tabindex="-1" href="#" ><i class="icon-trash"></i> Rechazar </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
	
echo "</tr>";

?>