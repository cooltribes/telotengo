<div class="breadcrumbs">
                   <a href="#"><span>Inicio</span> </a> / 
                   <a href="#"><span class="current">Sub Categoria</span></a>
               </div>
               <h1 class="margin_top">CATEGORIAS</h1>
               <input type="hidden" id="categoriasFilter" value="<?php echo $filter['categoria']?>">
               <ul>
             <?php      foreach($categorias as $categoria): ?>
                        <li><a href="#" onclick="go('#categoriasFilter','<?php echo $categoria['objeto']->url_amigable ?>');"><?php echo $categoria['objeto']->nombre; ?></a>
            <?php           
                           
                            if(count($categoria['hijos'])>0):  ?>
                <ul>
            <?php              foreach($categoria['hijos'] as $subcategoria): ?>
               
                                <li><a href="#" onclick="go('#categoriasFilter','<?php echo $subcategoria->url_amigable ?>');"><?php echo $subcategoria->nombre ?></a></li>
                            
                 <?php      endforeach; ?>
                </ul>
            <?php            endif; ?>      
                            
                            
                             
             <?php      endforeach; ?>

                   </li>
                  
               </ul>


        
               <div class="separator"></div>
               <h1>MARCAS</h1>
               <input type="hidden" id="marcasFilter" value="<?php echo $filter['marcas']?>">
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
                   <li><input <?php echo in_array(1,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca1" onclick="reqCheck('#marca1',1,'brands')"/> Marca 1</li>
                   <li><input <?php echo in_array(2,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca2" onclick="reqCheck('#marca2',2,'brands')"/> M2</li>
                   <li><input <?php echo in_array(3,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca3" onclick="reqCheck('#marca3',3,'brands')"/> Marca numero 3</li>
                   <li><input <?php echo in_array(4,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca4" onclick="reqCheck('#marca4',4,'brands')"/> Marca 4</li>
                   <li><input <?php echo in_array(5,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca5" onclick="reqCheck('#marca5',5,'brands')"/> Marca 5</li>
                   <li><input <?php echo in_array(6,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca6" onclick="reqCheck('#marca6',6,'brands')"/> Marca 6</li>
                   <li><input <?php echo in_array(7,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca7" onclick="reqCheck('#marca7',7,'brands')"/> M7</li>
                    <li><input <?php echo in_array(8,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca8" onclick="reqCheck('#marca8',8,'brands')"/> La Marca 8</li>
                   <li><input <?php echo in_array(9,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca9" onclick="reqCheck('#marca9',9,'brands')"/> Marca9</li>
                   <li><input <?php echo in_array(10,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca10" onclick="reqCheck('#marca10',10,'brands')"/> Marca 10</li>
                   <li>
                       <input <?php echo in_array(11,explode('-',$filter['marcas']))?"checked":""; ?> type="checkbox" id="marca11" onclick="reqCheck('#marca11',11,'brands')"/> M11</li>
                   
                   
               </ul>
                <?php
                   echo CHtml::hiddenField('brands',$filter['marcas']); 
                ?>
               <div class="separator"></div>
               
               <h1>PRECIO</h1> 
                 <input type="hidden" id="precioFilter" value="<?php echo $filter['precio']?>">
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
                        <a class="btn-orange btn-small btn-danger orange_border" onclick="go('#precioFilter',$('#minPrice').val()+'-'+$('#maxPrice').val())">Ir</a>
                    </div>
                 </div>
              <div class="separator"></div>
               
               <h1>CARACTERISTICA</h1>
               <input type="hidden" id="caracteristicaFilter" value="<?php echo $filter['caracteristica']?>"> 
                <ul>
                   <li><a href="#" onclick="go('#caracteriscaFilter','<?php echo "value"; ?>');">Equipos</a></li>
                   <li><a href="#" onclick="go('#caracteriscaFilter','<?php echo "value"; ?>');">Portatiles</a></li>
                   <li><a href="#" onclick="go('#caracteriscaFilter','<?php echo "value"; ?>');">Monitores</a></li>
                   <li><a href="#" onclick="go('#caracteriscaFilter','<?php echo "value"; ?>');">Impresoras</a></li>
                   <li><a href="#" onclick="go('#caracteriscaFilter','<?php echo "value"; ?>');">Consumibles</a></li> 
                   <li><a href="#" onclick="go('#caracteriscaFilter','<?php echo "value"; ?>');">Discos Duros</a></li>
               </ul>
