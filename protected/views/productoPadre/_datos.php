<?php

$ima ='';

echo"<tr>";
   	
   	echo "<td>".$data->nombre."</td>";
	echo "<td>".Categoria::model()->findByPk($data->id_categoria)->nombre."</td>";
	if($data->activo==1)
		echo "<td id='".'act'.$data->id."'>Si</td>";
	else
		echo "<td id='".'desact'.$data->id."'>No</td>";
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/productoPadre/update',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/productoPadre/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
			';
		if($data->activo==1)
			echo '<li><a href="" id="activo'.$data->id.'" tabindex="-1" onclick="cambiarStatus('.$data->id.', 0)"><i class="glyphicon glyphicon-pencil"></i> Desacctivar </a></li>';
		else
			echo '<li><a href="" id="desactivo'.$data->id.'" tabindex="-1" onclick="cambiarStatus('.$data->id.', 1)"><i class="glyphicon glyphicon-pencil"></i> Activar </a></li>';
		
		echo '</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		 
			';
	
echo"</tr>";

?>
<script>

	
	
	function cambiarStatus(id, status)
	{
			$.ajax({
		         url: "<?php echo Yii::app()->createUrl('productoPadre/cambiarStatus') ?>",
	             type: 'POST',
		         data:{
	                    id:id, status:status,
	                   },
		        success: function (data) {
		        	
					window.location.reload();
		       	}
		       })
	}
	
			
		
		

	


</script> 