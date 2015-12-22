                 
               <h1 class="margin_top">CATEGORIAS</h1>
               
                <?php if($filter['categoria']!=''):?>
                    <a href="#" class="cleanFilter" onclick="clean('#categoriasFilter')">Ver Todas</a>
               <?php endif; ?>
               <input type="hidden" id="categoriasFilter" value="<?php echo $filter['categoria']?>">
               <ul>
             <?php      foreach($categorias as $categoria): ?>
                           
                        <li><a href="#" class="<?php echo $filter['categoria']==$categoria['objeto']->url_amigable?"underlined highlighted":'';?>" onclick="go('#categoriasFilter','<?php echo $categoria['objeto']->url_amigable ?>');"><?php echo $categoria['objeto']->nombre; ?></a>
            <?php           
                           
                            if(count($categoria['hijos'])>0):  ?>
                <ul>
            <?php              foreach($categoria['hijos'] as $subcategoria): ?>
               
                                <li><a href="#" class="<?php echo $filter['categoria']==$subcategoria->url_amigable?"underlined highlighted":''?>" onclick="go('#categoriasFilter','<?php echo $subcategoria->url_amigable ?>');"><?php echo $subcategoria->nombre ?></a></li>
                            
                 <?php      endforeach; ?>
                </ul>
            <?php            endif; ?>      
                             
                            
                             
             <?php      endforeach; ?>

               </li> 
                   
               </ul>  


        
               <div class="separator"></div>
               <h1>MARCAS</h1>

               <?php if($filter['marcas']!=''):?>
                   <a href="#" class="cleanFilter" onclick="clean('#marcasFilter')">Ver Todas</a>
               <?php endif; ?>
               <input type="hidden" id="marcasFilter" value="<?php echo $filter['marcas']?>">
               <ul>
               	<?php /*
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
                            
                       
                       
                       
                       
                       
                   </li> */?>
                   
                   <?php 
                   $i=0;
				   $model=Marca::model()->findAllByAttributes(array('destacado'=>1), array('limit'=>11)); //TODO en una proxima entrega hacerlo como rakuten
                   foreach($model as $modelado)
				   {?>
				   	 <li><input <?php echo in_array($modelado->id,explode('-',$filter['marcas']))?"checked":""; ?> 
				   	 	type="checkbox" id="marca<?php echo $modelado->id; ?>" onclick="reqCheck('#marca<?php echo $modelado->id;?>',<?php echo $modelado->id;?>,'brands')"/> <?php echo $modelado->nombre;?></li>
				   <?php
				   $i++;
				   }
                   ?>
                   
               </ul>
                <?php
                   echo CHtml::hiddenField('brands',$filter['marcas']); 
                ?>
               <div class="separator"></div>
               
               <h1>PRECIO</h1>
           
               <?php if($filter['precio']!=''):?>
                   <a href="#" class="cleanFilter" onclick="clean('#precioFilter')">Todos</a>
               <?php endif; ?> 
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
            <?php //TODO esto va para otra entrega.
               /*
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
		*/
		