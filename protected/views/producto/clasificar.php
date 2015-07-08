 <style>
    .niveles{	
      	margin-top: 40px;
      	display: inline-block;
        border: 5px solid gray;
        padding: 5px;
        background: white;
        width: 240px;
        height: 400px;
        overflow-y: scroll;
        float: left;
    }    
    
    #paneles{
    	margin-left: 220px; 	
    }
    
 
    
    
    	
 	
 </style>



	<div id="paneles">
		
		<div id='nivel1' class="niveles">
		<?php 
		$categorias = Categoria::model()->findAllByAttributes(array('id_padre' => '0'));
		
		foreach($categorias as $cate)
		{
			?><a href="#" onclick="buscar(<?php echo $cate->id;?>, 1)" > <br> <?php echo $cate->nombre; ?><br></a>
		<?php
		}
		?>	
		
		</div>
		<div id="nivel2" class="niveles" style="display: none;">	
		</div>
		
		<div id="nivel3" class="niveles" style="display: none;">	
		</div>
		
		<div id="nivel4" class="niveles" style="display: none;">	
		</div>
		
		<div id="nivel5" class="niveles" style="display: none;">	
		</div>
		
		<div id="nivel6" class="niveles" style="display: none;">	
		</div>
		
			<div id="texto"><h4><strong> </strong> </h4></div>	
			<a class="btn btn-primary btn-lg" id="boton" style="display: none;">Seleccionar</button>
			
			
	</div>
	</div>
	

	
	<script> 
	
		function buscar(id, nivel){	
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
					}
	        		
                   $("#nivel"+next).show();
                   $( "#nivel"+next ).html(data);        
	       	}
	       })		      
	}
	
	function seleccion(id, nombre)
	{
		//$("#texto").html("<h4><strong>"+id+" </strong></h4>");
		$("#texto").show();
		$("#boton").attr("href", "../productoPadre/create/"+id);
		$("#boton").show();
	}
	
</script>
	

	