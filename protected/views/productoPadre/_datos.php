<?php

$ima ='';

echo"<tr>";
   	
   	echo "<td>".$data->nombre."</td>";
	echo "<td>".Categoria::model()->findByPk($data->id_categoria)->nombre."</td>";
	if($data->activo==1)
	{
		echo "<td> <div id='".$data->id."s"."'> Activo </div></td>";
	}
	else 
	{
		echo "<td> <div id='".$data->id."s"."'> Desactivo </div></td>";
	}	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/productoPadre/update',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="#" onclick="submit('.$data->id.')"><i class="glyphicon glyphicon-ok"></i> Crear Variacion </a></li>
			';
		if($data->activo==1){?>
				<li><a class="pointer" id=<?php echo $data->id;?> tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-remove"></i> Desactivar </a></li><?php }
			else{?><li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Activar </a></li><?php } 
			
        ?>
            <form id="form<?php echo $data->id?>" action="../producto/create" method="post">
                <input type="hidden" name="padre"  value="<?php echo $data->id?>"/>
            </form>
        <?php
		echo '</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		 
			';
	
echo"</tr>";

?>
<script>

	function desactivarActivar(id)
	{
			
			$.ajax({

	         url: "<?php echo Yii::app()->createUrl('productoPadre/activarDesactivar') ?>",
             type: 'POST',
	         data:{
                    id:id,
                   },
	        success: function (data) {
				if(data==0)//lo contrario
				{
					$('#'+id).html('<i class="glyphicon glyphicon-ok"></i> Activar');
					$('#'+id+'s').html('Desactivo')
				}
				else
				{
					$('#'+id).html('<i class="glyphicon glyphicon-remove"></i> Desactivar');
					$('#'+id+'s').html('Activo')
				}
	       	}
	   });
		

	}

	
	function submit(id){
	    $('#form'+id).submit(); 
	}
	

			
		
		

	


</script> 