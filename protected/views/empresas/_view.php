<?php
$empresa_user = EmpresasHasUsers::model()->findByAttributes(array('empresas_id'=>$data->id));



echo"<tr>";
	echo '<td>'.$data->id.'</td>';
	echo '<td>'.$data->razon_social.'</td>';
	echo "<td>".$data->rif."</td>";
	echo '<td>'.$data->direccion.'</td>'; 

	echo '<td>'.Ciudad::model()->findByPk($data->ciudad)->nombre.'</td>';
	$provincia=Ciudad::model()->findByPk($data->ciudad)->provincia_id;
	echo '<td>'.Provincia::model()->findByPk($provincia)->nombre .'</td>';
	echo '<td>'.$data->telefono.'</td>';
	echo '<td>'.$data->rol.'</td>';	
	

	

		
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>  

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/update',array('id'=>$data->id)).'" ><i class="icon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/verEmpresa',array('id'=>$data->id)).'" ><i class="icon-trash"></i> Ver </a></li>
		</ul>
	    </div></td>
	    
	    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    </div>		
			';
	
echo "</tr>";

?>