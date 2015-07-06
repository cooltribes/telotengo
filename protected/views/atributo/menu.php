	<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>	 
<!-- FLASH OFF -->

<input id="opcion" type="hidden" value="<?php echo $opcion; ?>" />

	<!-- SUBMENU ON -->
   <div class="navbar margin_top">
    <div class="navbar-inner">
      <ul class="nav">
        <li id="1"><?php echo CHtml::link('Creacion',array('create',
                                     'id'=>$model->id,)); ?></li>
        <li id="2"><?php echo CHtml::link('Opciones de Atributo',array('opciones',
                                     'id'=>$model->id,)); ?></li>
      </ul>
    </div>
  </div>
  
<script>
	$(document).ready(function(){
		
		var opc = $("#opcion").attr("value");
		
		if(opc == 1)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#1').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 2)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#2').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 2)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#2').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 3)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#3').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 4)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#4').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 5)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#5').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 6)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#6').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 7)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#7').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 8)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#8').addClass('active'); // añado la clase active al seleccionado
		}
		
		if(opc == 9)
		{			
			// para quitar el active en caso de que ya alguno estuviera seleccionado
   			$(".nav").find("li").siblings().removeClass('active');
						
  			$('li#9').addClass('active'); // añado la clase active al seleccionado
		}
	
	});
</script>