<?php

$empresa = Empresas::model()->findByPk($data->empresa_id);

echo"<tr>";
   	echo "<td>".$empresa->razon_social."</td>";
	echo "<td>".$data->numero."</td>";
   	echo "<td>".$data->rif."</td>";
	echo "<td>".$data->banco."</td>";
   	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/DatosPago/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-plus"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/DatosPago/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar Dato </a></li>
		</ul>
        </div>
   	</td>	
			';
	
echo"</tr>";

?>