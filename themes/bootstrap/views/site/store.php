
           <div class="col-md-2 leftPanel">                 
               <?php $this->renderPartial('filters'); ?>
           </div>           
           <div class="col-md-10">
               <div class="row-fluid">
                   <div class="col-md-12 mainStore margin_top_minus">
                       <div class="row-fluid">
                           <div class="col-md-4 no_horizontal_padding">
                               <div class="margin_top_small">
                                   <span class="muted">Mostrando 1 - 16 de 256 resultados</span>
                               </div>
                           </div>
                           <div class="col-md-4 col-md-offset-4 no_horizontal_padding">
                               <div style="float:right">
                               Ordenar por: 
                               <div class="dropdown sorter">
                                  <button class="btn btn-default no_radius dropdown-toggle" type="button" id="categorySearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Nombre
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Nombre </a></li>
                                    <li><a href="#">Some Sort </a></li>
                                    <li><a href="#">Another Sort</a></li>
                                     
                                  </ul>  
                                </div>
                                <div class="storeControls no_padding_right">
                                    <a href="#"><span class="glyphicon glyphicon-th-large"></span></a>
                                <a href="#"><span class="glyphicon glyphicon-th-list"></span></a>
                                </div>
                                </div>
                           </div>
                           <div class="col-md-12 plainSeparator margin_bottom"></div>
                           <div class="col-md-12 no_horizontal_padding">
                               <?php  
                               if($list)
                                $this->renderPartial('list_view');
                               else
                                   $this->renderPartial('grid_view'); ?>
                               
                           </div>
                           
                       </div>
                       
                   </div>
               </div>
           </div>
