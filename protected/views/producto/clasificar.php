
<?php
    $this->breadcrumbs=array(
        'Productos Padre'=>array('productoPadre/admin'),
        'Crear'
    );
    ?>
    <h1>Selección de categoría</h1>
    <div class="row-fluid clearfix">
        <p class="mute col-md-9">Selecciona secuencialmente las categorías y subcategorías en las que se clasificará el nuevo producto, al mostrarse el botón de "Seleccionar" haz click para continuar</p>
        <div class="col-md-3">
            <a class="btn btn-large btn-orange white" id="boton" style="display: none;">Seleccionar <span class="glyphicon glyphicon-forward"></span></button>
        </div>
    </div>
    
	<div id="paneles" class="clearfix">
		
		<div id='nivel1' class="niveles">
		<?php 
		$categorias = Categoria::model()->findAllByAttributes(array('id_padre' => '0'));
		
		foreach($categorias as $cate)
		{
			?><a href="#" id="cate<?php echo $cate->id;?>" onclick="buscar(<?php echo $cate->id;?>, 1,'cate<?php echo $cate->id;?>')" > <?php echo $cate->nombre; ?></a>
		<?php
		}
		?>	
		
		</div>
		<div id="nivel2" class="niveles no_border_left" style="display: none;">	
		</div>
		
		<div id="nivel3" class="niveles no_border_left" style="display: none;">	
		</div>
		
		<div id="nivel4" class="niveles no_border_left" style="display: none;">	
		</div>
		
		<div id="nivel5" class="niveles no_border_left" style="display: none;">	
		</div>
		
		<div id="nivel6" class="niveles no_border_left" style="display: none;">	
		</div>
		
			<div id="texto"><h4><strong> </strong> </h4></div>	
			
			
			
	</div>
	</div>
	

	
	<script> 
	
		function buscar(id, nivel, element){	
		var id=id;
		var next=nivel+1;

		$("#texto").hide();
		$("#boton").hide();
		$.ajax({
	         url: "<?php echo Yii::app()->createUrl('Producto/niveles') ?>",
             type: 'POST',
	         data:{
                    id:id, nivel:nivel
                   },
	        success: function (data) {
	        	
	        		for(i=next; i<7;i++)
					{
						$("#nivel"+i).hide();
						$('#'+element).parent().children().removeClass('active');
						$('#'+element).addClass('active');
					}
	        		
                   $("#nivel"+next).show();
                   $( "#nivel"+next ).html(data);        
	       	}
	       })		      
	}
	
	function seleccion(id,  element)
	{
		//$("#texto").html("<h4><strong>"+id+" </strong></h4>");
		$("#texto").show();
		$("#boton").attr("href", "../productoPadre/create/"+id);
		$("#boton").show();
		$('#'+element).parent().children().removeClass('active');
        $('#'+element).addClass('active');
	}
	
</script>
	

	