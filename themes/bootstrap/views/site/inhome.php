<a href="<?php echo Funciones::getBanner(1,1);?>"><img src="<?php echo Funciones::getBanner(1,2);?>" width="100%"/></a>
<div class="col-md-8 col-md-offset-2">
        <div class="row-fluid margin_top">           
           <div class="col-md-9 mainHome">
               <div class="row-fluid">
                   <div class="col-md-12"><h1>CATEGORIAS DESTACADAS</h1></div>
                   
<!-- +++++++++++++++++++++++++++++ CATEGORIAS ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->                   
                   <div class="col-md-12 no_horizontal_padding">
                       <section class="row-fluid">
                           <article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3>CATEGORIA 1</h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                           <li>Subcategoria 1.1</li>
                                           <li>Subcategoria 1.2</li>
                                           <li>Subcategoria 1.3</li>
                                           <li>Subcategoria 1.4</li>
                                           <li>Subcategoria 1.5</li>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <img  width="100%" src="http://placehold.it/90x120"/>
                                   </div>
                               </div>                       
                           </article>
                           
                           <article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3>CATEGORIA 1</h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                           <li>Subcategoria 1.1</li>
                                           <li>Subcategoria 1.2</li>
                                           <li>Subcategoria 1.3</li>
                                           <li>Subcategoria 1.4</li>
                                           <li>Subcategoria 1.5</li>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <img width="100%" src="http://placehold.it/90x120"/>
                                   </div>
                               </div>                       
                           </article>
                           
                           <article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3>CATEGORIA 1</h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                           <li>Subcategoria 1.1</li>
                                           <li>Subcategoria 1.2</li>
                                           <li>Subcategoria 1.3</li>
                                           <li>Subcategoria 1.4</li>
                                           <li>Subcategoria 1.5</li>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <img width="100%" src="http://placehold.it/90x120"/>
                                   </div>
                               </div>                       
                           </article>
                           
                           <article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3>CATEGORIA 1</h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                           <li>Subcategoria 1.1</li>
                                           <li>Subcategoria 1.2</li>
                                           <li>Subcategoria 1.3</li>
                                           <li>Subcategoria 1.4</li>
                                           <li>Subcategoria 1.5</li>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <img width="100%" src="http://placehold.it/90x120"/>
                                   </div>
                               </div>                       
                           </article>
                           
                           <article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3>CATEGORIA 1</h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                           <li>Subcategoria 1.1</li>
                                           <li>Subcategoria 1.2</li>
                                           <li>Subcategoria 1.3</li>
                                           <li>Subcategoria 1.4</li>
                                           <li>Subcategoria 1.5</li>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <img  width="100%" src="http://placehold.it/90x120"/>
                                   </div>
                               </div>                       
                           </article>
                           
                           <article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3>CATEGORIA 1</h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                           <li>Subcategoria 1.1</li>
                                           <li>Subcategoria 1.2</li>
                                           <li>Subcategoria 1.3</li>
                                           <li>Subcategoria 1.4</li>
                                           <li>Subcategoria 1.5</li>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <img width="100%" src="http://placehold.it/90x120"/>
                                   </div>
                               </div>                       
                           </article>
                           
                           
                           
                       </section>                                            
                   </div>
<!-- +++++++++++++++++++++++++++++ CATEGORIAS ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->  


    <div class="col-md-12 margin_top">
                <h1>ULTIMOS PUBLICADOS</h1>
                                           
                <?php $this->renderPartial('carousel_productos',array('ultimos'=>NULL,'carousel'=>'ultimos')); ?>         
                    
    </div>
    
    <div class="col-md-12 margin_top">
                <h1>DESTACADOS</h1>
                                           
                <?php $this->renderPartial('carousel_productos',array('destacados'=>NULL,'carousel'=>'destacados')); ?>         
                    
    </div>               
                                    
               </div>
           </div>
           
           <div class="col-md-3">
                <div class="row-fluid">
                    <div class="col-md-12">
                        <img width="100%" src="http://placehold.it/196x432">
                    </div>
                    <div class="col-md-12 margin_top">
                        <img width="100%" src="http://placehold.it/196x462">
                    </div>           
                </div>
           </div>
           
           <div class="col-md-12 volumeSales margin_top_large">
               <h1>
                   OFERTAS DESTACADAS POR VOLUMEN
               </h1>
           </div>
           <div class="col-md-9 volumeSales">
               <div class="row-fluid">
                           <?php $this->renderPartial('volume_sales',array('volumeSales'=>NULL)); ?>
                   
               </div>
               
           
           </div>
           <div class="col-md-3 margin_top">
                <div class="row-fluid">
                    <div class="col-md-12">
                         <img width="100%" src="http://placehold.it/196x330">
                    </div>
                    <div class="col-md-12 margin_top">
                         <img width="100%" src="http://placehold.it/196x328">
                    </div>           
                </div>
           </div>
           
            
        </div>
</div>
