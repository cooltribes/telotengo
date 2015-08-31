<style>
    h1{
        font-size: 24px;
    }
    .mainDetail>h1{
        padding:0px;
        margin: 0px;
        max-height: 78px;
        height: 78px; 
    }
    .mainDetail .separator{
        height: 2px;
        margin: 5px 0;
        background: #555;
    }
    .mainDetail .priceTable td{
        padding: 5px; 
    }
    .mainDetail .priceTable .title{
        font-weight:900;
        text-align: right;
    }
    .mainDetail .priceTable .success{
        font-weight:900;
        color: #3ca13c;
    }
    .mainDetail .priceTable .error{
        font-weight:900;
        color: #cb1020;
    }
    .mainDetail .priceTable td .highlighted{
        color: #ec1f24;
        font-weight:900;
        font-size: 18px;
    }
    .mainDetail .shippingInfo{
        background-color: #e9e9e9;
        height:80px;
        padding: 8px 10px;
        font-weight: 900;
    }
    .shippingInfo .title{
        margin-top:3px; 
        display: inline-block;
        color:#222;
    }
    .shippingInfo .price{
        font-size: 18px;
        font-weight: 900;
        color:#222;
    }
    .shippingInfo a{
        color:#222;
    }
    .shippingInfo .estimated{
        display:block;
        margin-top: 10px;
        font-weight: 500;
    }
    .orderBox{
        border: 2px solid #222;
        padding: 10px 6px; 
    }
    .moreOptions{
        border: 2px solid #222;
        padding: 5px 6px; 
    }
    
    .orderBox table td.highlighted{
        color: #ec1f24;
        font-weight:900;
        font-size: 18px;
    }
    .orderBox table td.emphasis{
        color: #222;
        font-weight:900;
        font-size: 18px;
    }
    .orderBox table td.call{
        padding:0px 15%;        
    }
    .orderBox table tr td.name{
        color: #222;
        font-weight:900;
        font-size: 18px;
        padding-left:15%;
    } 
    .orderBox table tr td{
        padding: 7px ;
    }
    .orderBox table tr td input.quantity{
        width:60%;
    }
    .orderBox .sellerInfo, .moreOptions .item{
            padding: 5px 5% 5px 15%;
    }
    .sellerInfo span{
        display:block;
    }
    .sellerInfo .title, .moreOptions .item .title{
        font-size:18px;        
    }
    .sellerInfo .name{
        font-size:18px;
        margin-top:12px;
        font-weight: 900;
    }
    .orderBox .sellerInfo .location{
        margin-bottom:12px;
    }
    
   .btn-unfilled{
       border: solid 1px #ec1f24;
       color: #ec1f24;
       background: transparent; 
   }
   .miniSlide{
       margin-top: 10px;
   }
   .miniSlide .item{
       width: 18%;
       padding:2px; 
       float: left;
   }
   .miniSlide .control{
       width: 5%;
        text-align: center;
       float: left;
   }
   .miniSlide .control span{
        font-weight: bold;
        border: 1px solid #AAA;
        margin-top: 18px;
    
        padding: 0px 2px;
        font-size: 10px;
        display: inline-block;
        border-radius: 1px;
        box-shadow: 1px 1px 2px #CCC;
   }
   .dropdown.drophover:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
    .specs h2, h2 {
        font-size: 18px;
        font-weight: bolder;
        margin: 0px;
    }
    .main .specs ul li{
        font-size: 12px;
        color: #55;
        margin-top:5px;
    }
    .main .specs ul{
        padding-left: 0px;
    }
    .main .specs ul li .glyphicon{
        margin-right: 5px;
    }
    .moreDetails{
        border: 2px solid #222;
        padding: 10px 10px 20px 10px;  
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus{
            border: 1px solid #222;
            border-bottom-color: transparent;
            border-radius: 0px;
            border-left-color: transparent;
    }
    .nav-tabs{
        border-bottom: 1px solid #222;
    }
    .nav-tabs>li.active>a{
        color: #555;
    }
    .nav-tabs>li>a{
        font-size:12px;
        color: #CCC;
    }
    .nav-tabs{
        width: 70%;
    }
    .detailTable{
        border: solid 1px #AAA;
        font-size: 12px;
    }
    .detailTable .title{
        background-color: #CCC;
        text-align: right;
        font-weight: bolder;
        padding-right: 10px;
       
    }
    .detailTable td{
        padding: 5px;
        table-layout: fixed;
        border: solid 1px #AAA;
    }
    .moreDetails textarea{
        width:100%;
        resize: none;
        margin: 7px 0px;
    }
    .btn-gray {
        background-color: #E8E8E8;
        height: 34px;
        border: solid 1px #E8E8E8;
        font-weight: 800;
        border-radius: 0;
        color: #888;
    }
    .btn-gray:hover{
        background-color: #D8D8D8;
        border: solid 1px #D0D0D0;
        color: #555;
    }
    .moreDetails .title{
        display: block;
        font-weight: 900;
    }
  
    .questions .question .userInfo>span{
        display: block;
        font-size: 12px;
        width:100%;        
    }
    
    .questions .question .content>span, .questions .best>span{
        display: block;
        font-size: 14px;
        width:100%;        
    }
    .questions .question .content .links{
        color: #ec1f24;
        text-align: right;      
    }
    .questions .question .content .links a{
        color: #ec1f24;
        text-decoration: underline;
        padding: 0px 4px;
        font-size: 11px;
             
    }
    .ellipsis{
        overflow:hidden;
        white-space:nowrap;
        text-overflow: ellipsis;
    }

</style>
<div class="col-md-8 col-md-offset-2">
        <div class="breadcrumbs margin_top">
                <a><span>Inicio</span></a>/&nbsp;
                <a><span>Sub Categoria</span></a>/&nbsp;
                <a><span>Sub Categoria 1.1</span></a>/&nbsp;
                <a><span class="current">Producto</span></a>
        </div>
        
        
        
        
        
        <div class="row-fluid margin_top">
            
            
            <div class="col-md-9 main no_left_padding">
                <div class="row-fluid">
                    
                
                    <div class="col-md-4 no_left_padding">
                       <img src="http://placehold.it/300x300" width="100%" />
                       <div class="miniSlide">
                           <div class="control"><span><</span></div>
                           <div class="item"><img src="http://placehold.it/30x30" width="100%" /></div>
                           <div class="item"><img src="http://placehold.it/30x30" width="100%" /></div>
                           <div class="item"><img src="http://placehold.it/30x30" width="100%" /></div>
                           <div class="item"><img src="http://placehold.it/30x30" width="100%" /></div>
                           <div class="item"><img src="http://placehold.it/30x30" width="100%" /></div>
                           <div class="control"><span>></span></div>
                       </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    <div class="col-md-8 mainDetail">
                        <h1 class="no_margin_top">
                          PRODUCTO MARCA MODELO COD XXXXXX KK/ 00000 / 0000 000  
                        </h1>
                        <div class="separator"></div>
                        <table width="100%" class="priceTable">
                            <tr>
                                <td class="title" width="25%">Precio en tienda</td>
                                <td width="33%" class="throughlined">350,000 Bs</td>
                                <td class="title" width="22%">Estatus</td>
                                <td class="success" width="20%"> En Stock</td>                        
                            </tr>
                            
                            <tr>
                                <td class="title">Precio al mayor</td>
                                <td ><span class="highlighted">320,000</span> Bs por und.</td>
                                <td class="title">Disponibilidad</td>
                                <td > 2000 und.</td>                        
                            </tr>
                            
                            <tr>
                                <td  class="title">Días de Crédito</td>
                                <td  >7</td>
                                <td  class="title" >Empaque</td>
                                <td  >10 und. / 1 caja</td>                        
                            </tr>
                            
                            <tr>
                                <td class="title">Descuento Adicional</td>
                                <td >5% desde 100 und.</td>
                                <td class="title">Orden mínima</td>
                                <td >50 und. / 5 cajas</td>                        
                            </tr>
                            
                            
                        </table>
                        
                        <div class="shippingInfo margin_top">
                            <div class="row-fluid">
                                <div class="col-md-3 text-right">
                                    <span class="title">Envío:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="price">Gratis</span>
                                    <a href="#">(en la región occidente) <span class="caret"></span></a>
                                    <span class="estimated">Fecha estimada de entrega: 3-5 días</span>
                                    
                                </div> 
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-8  col-md-offset-4 specs margin_top">
                        <h2>CARACTERÍSTICAS DEL PRODUCTO</h2>
                        <ul>
                            <li><span class="glyphicon glyphicon-ok"></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                            <li><span class="glyphicon glyphicon-ok"></span>Aliquam aliquet, quam eu finibus varius, nulla felis pellentesque ante, eget aliquet neque odio</li>
                            <li><span class="glyphicon glyphicon-ok"></span> Etiam quam sem, eleifend id nulla nec, scelerisque convallis odio.</li>
                        </ul>
                    </div>
                    <div class="col-md-12 no_padding_left slider">
                        <h1>OTROS PRODUCTOS DE ESTE PROVEEDOR</h1>
                        
                        <?php $this->renderPartial('carousel_productos',array('destacados'=>NULL,'carousel'=>'proveedor')); ?>  
                    </div>
             
             
             </div>
            </div>
            <div class="col-md-3 no_right_padding ">
                <div class="orderBox">
                    <table width="100%">
                        <tr>
                            <td width="50%" class="name">Cantidad:</td>
                            <td width="50%"><input type="number" class="quantity" /></td>
                        </tr>
                        <tr>
                            <td class="name">Precio:</td>
                            <td class="highlighted">150,000 Bs</td>
                        </tr>
                        <tr>
                            <td class="name">Envio:</td>
                            <td class="option emphasis">Gratis</td>
                        </tr>
                        <tr>
                            <td class="call" colspan="2">
                                <?php echo CHtml::submitButton('ORDENAR', array('class'=>'btn-orange margin_bottom_small btn btn-danger btn-large orange_border form-control')); ?>
                            </td>
                        </tr>
                    </table>
                    <div class="plainSeparator"></div>
                    <div class="sellerInfo">
                        <span class="title">Vendido y enviado por:</span>
                        <span class="name">Sigma System C.A.</span>
                        <span class="location">San Cristóbal (Táchira)</span>
                        <span>610 Transacciones</span>
                        <span>98% Feedbacks positivos</span>
                    </div>
                </div>
                <div class="moreOptions margin_top">
                    <div class="item">
                       <span class="title">Mas opciones de compra</span>                    
                        <div class="sellerInfo">
                            <span class="name">Compumall</span>
                            <span class="location">San Cristóbal (Táchira)</span>
                            <span><b>320.100 Bs.</b> + 1600 Bs. de Envío</span>
                            <button class="btn btn-small btn-unfilled"> ORDENAR</button>
                        </div>
                        
                    </div>
                    <div class="plainSeparator"></div>
                    <div class="item">              
                        <div class="sellerInfo">
                            <span class="name">Compumall</span>
                            <span class="location">San Cristóbal (Táchira)</span>
                            <span><b>320.100 Bs.</b> + 1600 Bs. de Envío</span>
                            <button class="btn btn-small btn-unfilled"> ORDENAR</button>
                        </div>
                        
                    </div>
                    <div class="plainSeparator"></div>
                    <div class="item">           
                        <div class="sellerInfo">
                            <span class="name">Compumall</span>
                            <span class="location">San Cristóbal (Táchira)</span>
                            <span><b>320.100 Bs.</b> + 1600 Bs. de Envío</span>
                            <button class="btn btn-small btn-unfilled"> ORDENAR</button>
                        </div>
                        
                    </div>

                    
                     
                </div>               
            </div>
            <div class="col-md-12 no_horizontal_padding margin_top">
                <div class="moreDetails">
                    
                                       
                    <ul id="myTabs" class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#moreDetails" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">DETALLES DEL PRODUCTO</a></li>
                      <li role="presentation" class=""><a href="#specifications" role="tab" id="specifications-tab" data-toggle="tab" aria-controls="specifications" aria-expanded="false">CARACTERÍSTICAS GENERALES</a></li>
                      <li role="presentation" class=""><a href="#recommendations" role="tab" id="recommendations-tab" data-toggle="tab" aria-controls="recommendations" aria-expanded="false">RECOMENDACIONES DEL PRODUCTO</a></li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="moreDetails" aria-labelledby="home-tab">
                        <?php $this->renderPartial('more_details'); ?>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="specifications" aria-labelledby="specifications-tab">
                        <?php $this->renderPartial('more_details'); ?>
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="recommendations" aria-labelledby="recommendations-tab">
                        <?php $this->renderPartial('more_details'); ?>
                      </div>
                      
                    </div>
                
                </div>  
                              
            </div>
            
           
            <div class="col-md-12 no_horizontal_padding margin_top">
                <h2>PREGUNTAS Y RESPUESTAS</h2>
                <div class="moreDetails">
                    <div class="row-fluid clearfix questions">
                        <div class="col-md-9">
                            <b>HAZ UNA PREGUNTA</b>
                            <textarea rows="2" maxlength="500" placeholder="Escribe tu pregunta (Max 500 caracteres)"></textarea>
                            <input class="btn-orange btn btn-danger btn-small  orange_border" type="submit" name="yt1" value="Preguntar Publicamente">
                            <input class="btn-gray btn btn-danger btn-small" type="submit" name="yt1" value="Preguntar en Privado">
                            <div class="row-fluid clearfix margin_top question">
                                <div class="col-md-2 text-center userInfo">
                                    <img src="http://placehold.it/50x50"/>
                                  
                                    <span class="userName ellipsis"><b>Compumall CA</b></span>
                                    <span class="date">27/11/2014</span>
                               </div>
                                <div class="col-md-10 content">
                                    <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                  
                                    <div class="links"><a href="#">Responder</a>|<a href="#">Reportar</a></div>                                   
                                </div>
                                
                            </div>
                            
                             <div class="row-fluid clearfix margin_top question">
                                <div class="col-md-2 text-center userInfo">
                                    <img src="http://placehold.it/50x50"/>
                                  
                                    <span class="userName ellipsis"><b>Compumall CA</b></span>
                                    <span class="date">27/11/2014</span>
                               </div>
                                <div class="col-md-10 content">
                                    <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                    <span>Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span> 
                                    <div class="links"><a href="#">Responder</a>|<a href="#">Reportar</a></div>                                   
                                </div>
                                
                            </div>
                            
                            <div class="row-fluid clearfix margin_top question">
                                <div class="col-md-2 text-center userInfo">
                                    <img src="http://placehold.it/50x50"/>
                                  
                                    <span class="userName ellipsis"><b>Compumall CA</b></span>
                                    <span class="date">27/11/2014</span>
                               </div>
                                <div class="col-md-10 content">
                                    <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                    <span>Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span> 
                                    <div class="links"><a href="#">Responder</a>|<a href="#">Reportar</a></div>                                   
                                </div>
                                
                            </div>
                           
                                                        
                        </div>
                        <div class="col-md-3">
                          <b>MEJORES RESPUESTAS</b>
                          <section class="margin_top">
                              <article class="best margin_bottom_large">
                                  <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                  <span class="margin_top_small">Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span>
                                  
                              </article>
                              
                              <article class="best margin_bottom_large">
                                  <span><b>¿Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh?</b></span>
                                  <span class="margin_top_small">Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</span>
                                  
                              </article>
                              
                          </section>
                          
                          
                            
                        </div>
                    </div>                                  
                </div>  
                              
            </div>
            
            
            
            
            
        </div>
</div>