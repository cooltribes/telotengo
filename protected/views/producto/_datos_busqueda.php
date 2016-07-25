<tr>
<?php

    $principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$data->id));
	
    							
    if($principal)
	{
		$im = CHtml::image(str_replace(".","_x180.",$principal->getUrl()), "Imagen ", array("height"=>"65px"));
	} 
    	
   	else
	{
		$im= '<img src="http://placehold.it/65x65" height="65px">';
	} 
    								  
    echo " <td>".$im."</td>"; 
    echo " <td>".$data->tlt_codigo."</td>"; 
		
	echo "<td><strong>".$data->nombre."</strong></td>";
    echo "<td><span class='hide' id='texto".$data->id."'>".$data->descripcion."</span><a class='leerMas' id='".$data->id."' href='#'><span>Leer descripcion</span><a/></td>";							
								
    echo ' <td class="text_align_center">';
    if($data->aprobado&&$data->estado)
    echo'<a href="'.Yii::app()->baseUrl.'/producto/inventario/'.$data->id.'" class="margin_top btn btn-orange white"><span class="glyphicon glyphicon-plus"></span> Cargar/Actualizar inventario</a>'; 
    else{
        if($data->aprobado==0)
            echo "<p style='color:#f4a611; font-weight:900'>Pendiente</p>";
        if($data->aprobado==2)
            echo "<p style='color:#ea2424; font-weight:900'>Rechazado</p>";

        if($data->estado==0)
            echo "<p style='font-weight:bolder'>Inactivo</p>";
        if($data->estado==1)
            echo "Activo<br>";
    }
    echo'</td>';


?>   
    							
</tr>

<script>
$(document).ready(function() {
    $(".leerMas").on("click", function(event){
       /* event.preventDefault();
        event.stopPropagation();
        var id=$(this).attr('id');
       alert($("#"+id).text());
        if($("#"+id).text()=="Leer descripcion")
        {
            $("#texto"+id).removeClass('hide');
            $("#"+id).text('No leer descripcion');

        }
        else
        {
            $("#texto"+id).addClass('hide');
            $("#"+id).text('Leer descripcion');
        }
        return false;*/
        var id=$(this).attr('id');
        $("#texto"+id).removeClass('hide');
        $("#"+id).text('No leer descripcion');
    })

});
</script>