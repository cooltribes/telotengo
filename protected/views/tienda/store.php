           <div class="col-md-2 leftPanel">  
           	<?php
           	if(isset( $filter['producto']))
           	{
           	?>
           	 <input type="hidden" id="producto" value="<?php echo  $filter['producto'];?>">  
           	 <?php 
           	 }
           	 ?>             
               <?php $this->renderPartial('filters',array('categorias'=>$categorias,'filter'=>$filter)); ?>
           </div>           
           <div class="col-md-10">
               <div class="row-fluid">
                   <div class="col-md-12 mainStore margin_top_minus no_horizontal_padding ">
                       <div class="row-fluid">
                           <div class="col-md-4 no_horizontal_padding">
                               <div class="margin_top_small">
                                   <span class="muted">Mostrando 1 - 16 de 256 resultados</span>
                               </div>
                           </div>
                           <div class="col-md-4 col-md-offset-4 no_horizontal_padding">
                               <div style="float:right">
                               Ordenar por: 
                               <input type="hidden" id="orderBy" value="<?php echo $order?>">
                               <div class="dropdown sorter">
                                  <button class="btn btn-default no_radius dropdown-toggle" type="button" id="categorySearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Seleccione
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <!--    <li><a href="#" onclick="go('#orderBy','nombre-asc');">Nombre </a></li> -->
                                    <li><a href="#" onclick="go('#orderBy','mayorPrecio-asc');">Mayor Precio </a></li>
                                    <li><a href="#" onclick="go('#orderBy','menorPrecio-desc');">Menor Precio </a></li>

                                     
                                  </ul>  
                                </div>
                                <div class="storeControls no_padding_right">
                                	 <input type="hidden" id="display" value="<?php echo $list?>"> 
                                	 
                                    <a href="#" onclick="go('#display',0);"><span class="glyphicon glyphicon-th-large"></span></a>
                               	    <a href="#" onclick="go('#display',1);"><span class="glyphicon glyphicon-th-list"></span></a>
                                </div>
                                </div>
                           </div>
                           <div class="col-md-12 plainSeparator margin_bottom"></div>
                           <div class="col-md-12 no_horizontal_padding">
                               <?php  
                               if($list==1)
                                $this->renderPartial('list_view', array('model'=>$model, 'model2'=>$model2));
                               else
							   	$this->renderPartial('grid_view', array('model'=>$model, 'model2'=>$model2));
                                   ?>
                               
                           </div>
                           
                       </div>
                       
                   </div>
               </div> 
           </div>
<script>
    function removeLast(string,letter){
         if(string.substring(string.length - 1, string.length)==letter){
            string=string.substring(0, string.length - 1);
        }
        return string;
    }
     function filtrar(){
        var params="?";
        if($("#producto").length > 0){params=params+"producto="+$('#producto').val()+"&"};
        if($('#categoriasFilter').val()!=''){params=params+"categoria="+$('#categoriasFilter').val()+"&";}
            
        if($('#marcasFilter').val()!=''){params=params+"marcas="+$('#marcasFilter').val()+"&";}
            
        if($('#precioFilter').val()!=''){params=params+"precio="+$('#precioFilter').val()+"&";}
        
        if($('#orderBy').val()!=''){params=params+"order="+$('#orderBy').val()+"&";}
        
        if($('#display').val()!=''){params=params+"display="+$('#display').val()+"&";}
            
       // if($('#caracteristicaFilter').val()!=''){params=params+"caracteristica="+$('#caracteristica').val()+"&";}   //TODO para otra entrega        

        var url = window.location.href.split("?");
        
        window.location.href=url[0]+removeLast(params,'&'); 
    }
    function go(id,value){
        $(id).val(value);
        filtrar();
    }
    function reqCheck(id,value,name){
         if($(id).is(':checked')){
            $('#'+name).val(''+value+'-'+$('#'+name).val()); 
       }                            
       else{
           $('#'+name).val($('#'+name).val().replace(''+value+'-',''));           
        }                       
        $('#'+name).val( removeLast( $('#'+name).val(),'-' ) );   
        $('#marcasFilter').val( removeLast( $('#'+name).val(),'-' ) );    
        filtrar();
    }


  $(function() {
    $( "#slider" ).slider({
      range: true,
      min: 0, 
      max: 200000,

      values: [ 10000 , 190000 ],
      slide: function( event, ui ) {
        $( "#from" ).html(ui.values[ 0 ]);
        $( "#to" ).html(ui.values[ 1 ]); 
        $('#minPrice').val(ui.values[ 0 ]); 
        $('#maxPrice').val(ui.values[ 1 ]); 
      }
    });
    $( "#from" ).html($( "#slider" ).slider( "values", 0 ));
    $( "#to" ).html($( "#slider" ).slider( "values", 1 ));
 
  });
</script>