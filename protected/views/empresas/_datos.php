<?php

$empresa = Empresas::model()->findByPk($data->empresas_id);

echo"<tr>";
   	echo "<td>".$empresa->razon_social."</td>";
	echo "<td>".$empresa->mail."</td>";
   	echo "<td>".$empresa->rif."</td>";
	echo "<td>".$empresa->direccion."</td>";
   	echo "<td>".$empresa->web."</td>";
	
	if($empresa->destacado == 1)
	   	echo "<td> Si </td>";
	else 
		echo "<td> No </td>";
	
   	echo "<td>".$empresa->url."</td>";

	switch ($empresa->estado)
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
	case 5:
		echo "<td> Cancelada </td>";
	  	break;
	}
			
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>
	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
		';
		if($empresa->estado==1)
			echo '<li><a tabindex="-1" href="'.Yii::app()->createUrl('/empresas/cancelar',array('id'=>$empresa->id)).'" ><i class="glyphicon glyphicon-trash"></i> Cancelar Solicitud </a></li>';
		//	echo '<li><a tabindex="-1" href="cancelar/id/'.$empresa->id.'" ><i class="glyphicon glyphicon-trash"></i> Cancelar solicitud </a></li>';
		else if($empresa->estado==2){ 
			echo '<li><a tabindex="-1" href="update/'.$empresa->id.'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>';
			echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-plus"></i> Agregar sucursal', Yii::app()->baseUrl.'/almacen/create/id_empresa/'.$empresa->id, array()).'</li>'; 
			echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-search"></i> Ver sucursales', Yii::app()->baseUrl.'/almacen/listado/id_empresa/'.$empresa->id, array()).'</li>'; 
			echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-list-alt"></i> Inventario', Yii::app()->baseUrl.'/empresas/inventarios/'.$empresa->id, array()).'</li>'; 
			echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-tag"></i> Vender producto', Yii::app()->baseUrl.'/producto/seleccion/', array()).'</li>';
			echo '<li>'.CHtml::link('<i class="glyphicon glyphicon-th-large"></i> Ventas', Yii::app()->baseUrl.'/empresas/ventas/'.$empresa->id, array()).'</li>';
		}
		else{
		 	echo '<li><a tabindex="-1" href="create" ><i class="glyphicon glyphicon-plus"></i> Solicitar nuevamente </a></li>';	
		}

		echo'		
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>