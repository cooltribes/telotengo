<?php
$empresa_user = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$data->id));
$representante = User::model()->findByPk($empresa_user->users_id);


echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo "<td>".$data->rif."</td>";
	echo '<td>'.$data->razon_social.'</td>';
	
	switch ($data->estado)
	{
	case 1:
		echo "<td> Solicitado </td>";
	  	break;
	case 2:
		echo "<td> Aprobado </td>";
	  	break;
	case 3:
		echo "<td> Rechazado </td>";
	  	break;
	case 4:
		echo "<td> Suspendido </td>";
	  	break;
	}	
	
	if($data->tipo == 1)
		echo "<td> Compradora </td>";
	else if($data->tipo == 2) 
		echo "<td> Vendedora </td>";
	
	echo "<td>".$representante->profile->first_name.' '.$representante->profile->last_name."</td>";
		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/update',array('id'=>$data->id)).'" ><i class="icon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/delete',array('id'=>$data->id)).'" ><i class="icon-trash"></i> Eliminar </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
	
echo "</tr>";

?>