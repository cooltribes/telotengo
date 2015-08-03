<?php

echo"<tr>";
	echo "<td>".$data->tlt_codigo."</td>";
	$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$data->id,'orden'=>'1'));
	
	if($imagen)
	{
		 $peque=Yii::app(true)->baseUrl.'/images/producto/'.$data->id.'/'.$imagen->id."_thumb.jpg"; //OJO
		 $ruta=Yii::app(true)->baseUrl.$imagen->url;
		 echo "<td><a href='".$ruta."' target='_blank' > <img height='142' width='142' src='".$peque."' title='Haz Click encima para ver Imagen con detalle'/></a></td>";
	}
	else 
	{
		echo '<td><img src="http://placehold.it/100" align="Nombre del producto"/> </td>';
	}
		
	
	
	echo "<td>".$data->nombre."</td>";
	echo "<td>".$data->modelo."</td>";
	echo "<td>".$data->colore->nombre."</td>";

	if($data->estado==1)
	{
		echo "<td> <div id='".$data->id."s"."'> Activo </div></td>";
	}
	else 
	{
		echo "<td> <div id='".$data->id."s"."'> Desactivo </div></td>";
	}	 


	echo '<td>
	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/producto/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>';
			if($data->estado==1){?>
				<li><a class="pointer" id=<?php echo $data->id;?> tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-remove"></i> Desactivar </a></li><?php }
			else{?><li><a class="pointer" id=<?php echo $data->id;?>  tabindex="-1" onclick="desactivarActivar(<?php echo $data->id;?>)"><i class="glyphicon glyphicon-ok"></i> Activar </a></li><?php } 
			
		echo '	
		</ul>
	    </div></td>	
			';
	
echo "</tr>"; 

?>

<script>

	function desactivarActivar(id)
	{
			
			$.ajax({
	         url: "<?php echo Yii::app()->createUrl('producto/activarDesactivar') ?>",
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
	       })
		
	}

</script>