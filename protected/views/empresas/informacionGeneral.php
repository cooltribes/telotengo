
	
	<ul id="myTabs" class="nav nav-tabs" role="tablist">
		<li id="descripcionNav" class="nav active"><a onclick="texto(1)" href="#"  aria-expanded="false">Descripcion</a></li>
		<li id="politicasNav" class="nav"><a onclick="texto(2)" href="#" aria-controls="home" aria-expanded="true">Politicas</a></li>
		<?php if(($empresaPropia==1 && $admin==1 && !Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id)) || ($empresaPropia==0 && $model->rol!="comprador")):?>
			<li id="pagosNav" class="nav"><a onclick="texto(3)" href="#"  aria-controls="home" aria-expanded="true">Pagos</a></li>
			<li id="enviosNav" class="nav"><a onclick="texto(4)" href="#"  aria-controls="home" aria-expanded="true">Envios</a></li>
			<li id="devolucionesNav" class="nav"><a onclick="texto(5)" href="#" aria-controls="home" aria-expanded="true">Devoluciones</a></li>
		<?php endif;?>
	              
	</ul>
	<div class="margin_top">
		<div id="texto" style="text-align: justify;">
		<?php echo $model->descripcion;?> 
		<?php if($empresaPropia==1 && $admin==1):?>
			<a onclick="editField(6,'descripcion',<?php echo $model->id; ?>)">Editar</a>
		<?php endif;?>
		</div>
		<div id="descripcion" class="hide">
		<?php echo $model->descripcion;?> 
		</div>
		<div id="politicas" class="hide">
		<?php echo $model->politicas;?> 
		</div>
		<div id="pagos" class="hide">
		<?php echo $model->pagos;?> 
		</div>
		<div id="envios" class="hide">
		<?php echo $model->envios;?> 
		</div>
		<div id="devoluciones" class="hide">
		<?php echo $model->devoluciones;?>
		</div>
	</div>
    <div id="changeField" class="modal fade miniModal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;" >
        
    </div>

<script>

function texto(vista)
{
	var empresaPropia="<?php if($empresaPropia==1 && $admin==1)echo '1';else echo'0';?>";
	$('.nav').removeClass('active');
	
    switch(vista) 
    {
	    case 1:
	    	var link="<a onclick='editField(6,6,<?php echo $model->id; ?>)'>Editar</a>";
	    	var textoEscape="<?php echo addslashes($model->descripcion);?>";
	    	if(empresaPropia==1)
	        	$('#texto').html(textoEscape+" "+link);
	        else
	        	$('#texto').html(textoEscape);
	        $('#descripcionNav').addClass('active');
	        break;
	    case 2:
	    	var link="<a onclick='editField(7,7,<?php echo $model->id; ?>)'>Editar</a>";
	    	var textoEscape="<?php echo addslashes($model->politicas);?>";
	    	if(empresaPropia==1)
	      		$('#texto').html(textoEscape+" "+link);
	        else
	        	$('#texto').html(textoEscape);
	        $('#politicasNav').addClass('active');
	        break;
	    case 3:
	    	var link="<a onclick='editField(8,8,<?php echo $model->id; ?>)'>Editar</a>";
	    	var textoEscape="<?php echo addslashes($model->pagos);?>";
	        if(empresaPropia==1)
	  			$('#texto').html(textoEscape+" "+link);
	        else
	        	$('#texto').html(textoEscape);
	        $('#pagosNav').addClass('active');
	        break;
	    case 4:
	        var link="<a onclick='editField(9,9,<?php echo $model->id; ?>)'>Editar</a>";
	        var textoEscape="<?php echo addslashes($model->envios);?>";
	        if(empresaPropia==1)
	   			$('#texto').html(textoEscape+" "+link);
	        else
	        	$('#texto').html(textoEscape);
	        $('#enviosNav').addClass('active');
	        break;
	    case 5:
	        var link="<a onclick='editField(10,10,<?php echo $model->id; ?>)'>Editar</a>";
	        var textoEscape="<?php echo addslashes($model->devoluciones);?>";
	        if(empresaPropia==1)
	       		$('#texto').html(textoEscape+" "+link);
	       	else
	       		$('#texto').html(textoEscape);
	        $('#devolucionesNav').addClass('active');
	        break;
	}          
}
function  editField(field,fname, id_empresa){
 
        if (fname==6)
        	fname="descripcion";
        if (fname==7)
        	fname="politicas";
        if (fname==8)
        	fname="pagos";
        if (fname==9)
        	fname="envios";
        if (fname==10)
        	fname="devoluciones";
        $.ajax({
            type: "post", 
            url: "editField", // action 
            dataType: 'json',
            data: { 'field':field,'fname':fname, 'id_empresa':id_empresa}, 
            success: function (data) {
                
                if(data.status=='ok')
                {
                    $('#changeField').html(data.content);
                    $('#changeField').modal();
 
                }
                            
            }
            //success
           });   
        }
</script>
   

        
