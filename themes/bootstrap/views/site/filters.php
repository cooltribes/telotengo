<script>
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
  function reqCheck(id,value,name){
     if($(id).is(':checked')){
                             
        $('#'+name).val(''+value+','+$('#'+name).val()); 
   }                            
   else
       $('#'+name).val($('#'+name).val().replace(''+value+',',''));
                           
    console.log( $('#'+name).val());
}  
 </script> 
<div class="breadcrumbs">
                   <a href="#"><span>Inicio</span> </a> / 
                   <a href="#"><span class="current">Sub Categoria</span></a>
               </div>
               <h1 class="margin_top">CATEGORIAS</h1>
               <ul>
                   <li>Equipos
                        <ul>
                            <li>sub categoria de equipos</li>
                        </ul>
                   </li>
                   <li>Portatiles</li>
                   <li>Monitores</li>
                   <li>Impresoras</li>
                   <li>Consumibles</li> 
                   <li>Discos Duros</li>
               </ul>
               
               <div class="separator"></div>
               <h1>MARCAS</h1>
               <ul>
                   <li class="dropdown dropdown-input">
                       
                       <?php
                            
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'id'=>'marcas',
                    'name'=>'marcas',
                    'source'=>array('Marca','Mora','Mira'),//$this->createUrl('Look/autocomplete'),
                    'htmlOptions'=>array(
                          //'size'=>22,
                          //'placeholder'=>'Introduzca la marca',
                          'class'=>'btn btn-default form-control no_radius dropdown-toggle',
                          "data-toggle"=>"dropdown",
                           "aria-haspopup"=>"true",
                           "aria-expanded"=>"true"
                           
                          //'maxlength'=>45,
                        ),
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                            'showAnim'=>'fold',
                    ),
                    )); 
                    
                    ?>
                       
                                 
                                    <span class="caret dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Action in <span class="highlighted">Your life</span></a></li>
                                    <li><a href="#">Another action in <span class="highlighted">Another's life</span></a></li> 
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                   </ul>                                     
                            
                       
                       
                       
                       
                       
                   </li>
                   <li><input type="checkbox" id="marca1" onclick="reqCheck('#marca1',1,'brands')"/> Marca 1</li>
                   <li><input type="checkbox" id="marca2" onclick="reqCheck('#marca2',2,'brands')"/> M2</li>
                   <li><input type="checkbox" id="marca3" onclick="reqCheck('#marca3',3,'brands')"/> Marca numero 3</li>
                   <li><input type="checkbox" id="marca4" onclick="reqCheck('#marca4',4,'brands')"/> Marca 4</li>
                   <li><input type="checkbox" id="marca5" onclick="reqCheck('#marca5',5,'brands')"/> Marca 5</li>
                   <li><input type="checkbox" id="marca6" onclick="reqCheck('#marca6',6,'brands')"/> Marca 6</li>
                   <li><input type="checkbox" id="marca7" onclick="reqCheck('#marca7',7,'brands')"/> M7</li>
                    <li><input type="checkbox" id="marca8" onclick="reqCheck('#marca8',8,'brands')"/> La Marca 8</li>
                   <li><input type="checkbox" id="marca9" onclick="reqCheck('#marca9',9,'brands')"/> Marca9</li>
                   <li><input type="checkbox" id="marca10" onclick="reqCheck('#marca10',10,'brands')"/> Marca 10</li>
                   <li>
                       <input type="checkbox" id="marca11" onclick="reqCheck('#marca11',11,'brands')"/> M11</li>
                   
                   
               </ul>
                <?php
                   echo CHtml::hiddenField('brands',''); 
                ?>
               <div class="separator"></div>
               
               <h1>PRECIO</h1> 
                 
                <div class="margin_top_small margin_bottom clearfix">    
                    <div id="slider"></div>
                    <p>
                      <div id="edad" class="sliderLegend clearfix">
                          <div class="indicator" id="from"></div>
                          <div class="spacer"> - </div>
                          <div class="indicator" id="to"></div>
                      </div>
                      <?php
                            echo CHtml::hiddenField('minPrice',''); 
                            echo CHtml::hiddenField('maxPrice',''); 
                        ?>
                    </p>
                    <div class="margin_top_small text-center">
                        <a href="" class="btn-orange btn-small btn-danger orange_border">Ir</a>
                    </div>
                 </div>
              <div class="separator"></div>
               
               <h1>CARACTERISTICA</h1> 
                <ul>
                   <li>Equipos</li>
                   <li>Portatiles</li>
                   <li>Monitores</li>
                   <li>Impresoras</li>
                   <li>Consumibles</li> 
                   <li>Discos Duros</li>
               </ul>
