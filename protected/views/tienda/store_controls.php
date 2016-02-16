<div class="row-fluid clearfix">
                           <div class="col-md-4 no_horizontal_padding">
                               <div class="margin_top">
                                   <span class="muted" id="mostrando">{summary}</span>
                               </div>
                           </div>
                           <div class="col-md-4 col-md-offset-4 no_horizontal_padding">
                               <div style="float:right">
                               Ordenar por: 
                               <input type="hidden" id="orderBy" value="<?php echo $order?>">
                               <div class="dropdown" style="display:inline">
                                  <button class="btn btn-default no_radius dropdown-toggle" type="button" id="categorySearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                       <?php echo $order=='asc'?"Menor Precio":$order=='desc'?"Mayor Precio":"Seleccione"; ?>
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <!--    <li><a href="#" onclick="go('#orderBy','nombre-asc');">Nombre </a></li> -->
                                    <li><a href="#" onclick="go('#orderBy','asc');">Mayor Precio </a></li>
                                    <li><a href="#" onclick="go('#orderBy','desc');">Menor Precio </a></li>

                                     
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
</div>