<?php 
echo CHtml::hiddenField('name' , '', array('id' => 'oculto')); 
// $model = Categoria::model()->findAllBySql("select * from tbl_categoria where id_padre in (select id from tbl_categoria where id_padre=0)  order by nombre asc");
 $model=Categoria::model()->findAllByAttributes(array('id_padre'=>0), array('order'=>' id asc'));
?>
<div class="navbar row-fluid b2b clearfix no_margin_bottom" >
    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 no_horizontal_padding" id="headerContainer">
                <div class="row-fluid">
                    <div class="col-md-2 col-sm-2 col-xs-5 no_padding_left">
                        <a href="<?php echo Yii::app()->baseUrl."/site/inhome2"; ?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/logo.png" width="100%"/></a> 
                    </div>
                    
            
                            
                            
                            
                            
                    <div class="col-md-6 col-sm-6 col-xs-6 no_horizontal_padding" id="searchSet">
                        <div class="row-fluid searchBar">
                            <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding">
                                <div class="dropdown">
                                  <select class="btn btn-default form-control no_radius dropdown-toggle orange_border_left"  id="categorySearch" >
                                    <option value="" selected>Todas las categorias</option>
                                 <?php 
                                 foreach($model as $modelado)
                                 {?>
                                  <option value="<?php echo $modelado->id?>"><?php echo $modelado->nombre;?></option>
                                 <?php  
                                 }?>      
                                  </select>
                                  
                                <!--  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Action in <span class="highlighted">Your life</span></a></li>
                                    <li><a href="#">Another action in <span class="highlighted">Another's life</span></a></li>
                                    <li class="separator"></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul> -->
                                </div> 
                            </div> 
                            <div class="col-md-7 col-sm-7 col-xs-7 no_horizontal_padding">
                               <!-- <input class="form-control no_radius orange_border_middle" placeholder:"incluye palabras clave..."/> -->
                               <?php
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'id'=>'busqueda',
                                    'name'=>'busqueda',
                                    'source'=>Yii::app()->createUrl('Site/autoComplete'),
                                    'htmlOptions'=>array(
                                          //'size'=>22,
                                          'placeholder'=>'Incluye palabras claves...',
                                          'class'=>'form-control no_radius orange_border_middle',
                                          //'maxlength'=>45,
                                        ),
                                    // additional javascript options for the autocomplete plugin
                                    'options'=>array(
                                            'showAnim'=>'fold'
                                             
                                            
                                    ),
                                    )); 
                                    ?>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 no_horizontal_padding">
                                <?php 
                                $usuario=User::model()->findByPk(Yii::app()->user->id);
                                echo CHtml::submitButton('Buscar', array('id'=>'botonBusqueda','class'=>'btn-orange btn btn-danger orange_border')); ?>
                            </div>
                        </div>
                    </div> 
                            
                            
                            
                            
                            
                            
                            
                            
                            <div class="col-md-4 col-sm-4 col-xs-12 no_horizontal_margin no_horizontal_padding">
                                    <div class="row-fluid" id="userMenu">
                                        
                                        <div class="col-md-5 col-sm-5 col-xs-5 no_horizontal_padding">
                                            <div class="dropdown drophover">
                                              <a class="form-control text-left dropdown-toggle no_padding no_border" id="userButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <div class="row-fluid">
                                                    <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding image">
                                                        <div class="imgContainer">
                                                    
                                                            <?php 
                                                            if(isset($usuario))
                                                            {   if(!is_null($usuario->avatar_url)):
                                                                 ?>   
                                                                <img src="<?php echo Yii::app()->baseUrl;
                                                                            if(strpos($usuario->avatar_url, ".png")==-1)
                                                                                echo str_replace(".jpg", "_thumb.jpg", $usuario->avatar_url);
                                                                            else
                                                                                echo str_replace(".png", "_thumb.png", $usuario->avatar_url); ?>" height="26px" width="26px"/>    
                                                                
                                                                <?php  else: ?>
                                                                    <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.2.png" width="100%" id="layout-avatar"/>       
                                                                <?php endif;                                                 
                                                            } 
                
                                                            ?>
                                                      
                                                            
                                                        </div>
                                                         
                                                    </div>
                                                    <div class="col-md-9 col-sm-9 col-xs-9 no_horizontal_padding title">
                                                         <div class="text user"><?php if(isset($empresas))echo $empresas->empresas->razon_social; else echo $usuario->empresa->razon_social?></div>
                                                         <span class="caret user"></span>
                                                    </div>
                                                    
                                                </div>                                
                                              </a>
                                              <ul class="dropdown-menu right" aria-labelledby="dropdownMenu1">
                                                  <li><a href="<?php echo Yii::app()->baseUrl.'/user/profile/index';?>">Mi perfil</a></li>
                                                  <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/invitarUsuario";>Invitaciones</a></li>
                                                  <li class="separator"></li>
                                                
                                            <?php
                                                if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id)): ?>
                                                        <li class="title">COMPRAR</li>
                                                        <li><a href="<?php echo Yii::app()->baseUrl.'/tienda/index';?>">Ir a la tienda</a></li>
                                                        <li class="separator"></li>
                                                         <li class="title">VENDER</li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/productoInventario";>Ver Inventario</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion";>Cargar Inventario</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/nuevoProducto";>Agregar un producto</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/almacen/administrador";>Ver Almacenes</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/inbound/administrador";>Ver Inbound</a></li>
                                               
                                                    <!--<li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/cargarInbound";>Cargar Inventario Masivo</a></li> -->          
                                                <?php endif; 
                                                
                                                    if(Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id)):?>
                                                          <li><a href="<?php echo Yii::app()->baseUrl.'/tienda/index';?>">Ir a la tienda</a></li>                                                
                                                <?php endif; 
                                                
                                                    if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)):?>
                                                    
                                                    <li><a href="<?php echo Yii::app()->baseUrl; ?>/almacen/administrador";>Ver Almacenes</a></li>
                                                     <li class="separator"></li>
                                                    <li><a href="<?php echo Yii::app()->baseUrl.'/tienda/index';?>">Ir a la tienda</a></li>   
                                                                                                        
                                                <?php endif; ?>
                                               
                                               
                                               
                                                <li class="separator"></li>
                                                <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout";>Cerrar sesión</a></li>
                                              </ul>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <?php if( Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)): ?>
                                             <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding">
                                             
                                                      
                                              <div class="dropdown drophover">
                                              <a class="form-control text-left dropdown-toggle no_padding no_border" id="inventoryButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <div class="row-fluid">
                                                    
                                                    <div class="col-md-12 col-sm-12 col-xs-12 no_horizontal_padding title">
                                                        <span class="text" >Inventario</span>
                                                         <span class="caret"></span>
                                                    </div>
                                                    
                                                </div>                                
                                              </a>
                                              <ul class="dropdown-menu right" aria-labelledby="dropdownMenu2">
                                                
                                                <?php
                                                if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)): ?>
                                                          
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/cargarInbound";>Cargar Inventario</a></li>
                                                   <!--      <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion";>Cargar Inventario</a></li>-->
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/productoInventario";>Ver Inventario</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/nuevoProducto";>Agregar un producto</a></li>
                                                <?php endif;?> 
                                              
                                              </ul>
                                            </div>          
                                                      
                                                      
                                                      
                                                </div>
                                        <?php endif; ?>
                                        <div class="col-md-4 col-sm-4 col-xs-4 no_right_padding">
                                            <div class="dropdown drophover">
                                              <a class="form-control text-left dropdown-toggle no_padding no_border " id="orderButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <div class="row-fluid">
                                                    <div class="col-md-3 col-md-3 col-xs-3 no_horizontal_padding icon">
                                                         <span class="glyphicon glyphicon-inbox"></span>
                                                         <span class="counter">
                                                             <?php 
                                                             if($usuario){
                           
                                                            $orders=Orden::model()->findAllBySql("select * from tbl_orden where estado=0 and almacen_id in (select id from tbl_almacen where empresas_id='".$usuario->empresa->id."') order by id desc");
                                                            $purchases=Orden::model()->findAllByAttributes(array('empresa_id'=>$usuario->empresa->id,'estado'=>0), array('order'=>'id desc'));
                                                             echo count($orders)+count($purchases);
                                                             } else {
                                                                 $orders=array();
                                                                 $purchases=array();
                                                             }
                                                             ?> 
                                                         </span>
                                                    </div>
                                                    <div class="col-md-9 col-sm-9 col-xs-9 no_horizontal_padding title">
                                                         <span class="text">Ordenes</span>
                                                   
                                                        <span class="caret no_margin_left"></span>
                                                    </div>
                                                </div>                                
                                              </a>
                                              <ul class="dropdown-menu right" aria-labelledby="dropdownMenu1">
                                               <?php   if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("Vendedor", Yii::app()->user->id)):?>
                                                 <li class="padding_left_xsmall"><small><u><a href="<?php echo Yii::app()->createUrl('orden/misVentas');?>">VENTAS</u></small></li>   
                                               <?php endif; ?>
                                                  <?php foreach($orders as $key=>$order): ?> 
                                                   <li><a href="<?php echo Yii::app()->createUrl('orden/detalleVendedor', array('id'=>$order->id))?>"><span><?php echo $order->id;?></span> <b><?php echo $order->empresa->razon_social; ?></b> (<?php echo count($order->ordenHasInventarios); ?>)</a></li>
                                                  
                                                  <?php  
                                                    if($key==2)
                                                        break;
                                                  endforeach; ?> 
                                                  
                                                <li class="separator"></li>
                                                
                                                <?php 
                                                  if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id)):?>
                                                      <li class="padding_left_xsmall"><small><u><a href="<?php echo Yii::app()->createUrl('orden/misCompras');?>">COMPRAS</u></small></li>       
                                          <?php      foreach($purchases as $key=>$order): ?> 
                                                   <li><a href="<?php echo Yii::app()->createUrl('orden/detalle', array('id'=>$order->id))?>"><span><?php echo $order->id;?></span> <b><?php echo $order->almacen->empresas->razon_social; ?></b> (<?php echo count($order->ordenHasInventarios); ?>)</a></li>
                                                  
                                                  <?php  
                                                    if($key==2)
                                                        break;
                                                  endforeach; ?> 
                                                <li class="separator"></li>
                                                <?php endif; 
                                                 if(Yii::app()->authManager->checkAccess("compraVenta", Yii::app()->user->id) || Yii::app()->authManager->checkAccess("comprador", Yii::app()->user->id)):?>
                                                         <li><a href="<?php echo Yii::app()->createUrl('orden/misCompras');?>">Ver todas las ordenes</a></li>
                                              <?php endif;
                                              if(Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)):?>
                                                    <li><a href="<?php echo Yii::app()->createUrl('orden/misVentas');?>">Ver todas las ordenes</a></li>
                                              <?php endif; ?>
                                              </ul>
                                            </div>
                                        </div>
                                       <?php if(!Yii::app()->authManager->checkAccess("vendedor", Yii::app()->user->id)): ?> 
                                        <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding">
                                            <div class="dropdown drophover">
                                      
                                           <a class="form-control text-left dropdown-toggle no_padding no_border" id="cartButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <div class="row-fluid">
                                                    <div class="col-md-4 col-sm-4 col-xs-4 no_horizontal_padding icon">
                                                         <span class="glyphicon glyphicon-shopping-cart"></span>
                                                         <?php
                                                         $empresas = EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id));
                                                         ?>
                                                         <span class="counter"><?php 
                                                        if(isset($empresas))
                                                        {
                                                             if(Bolsa::model()->findByAttributes(array('empresas_id'=>$empresas->empresas_id)))
                                                             {
                                                                 $bolsa=Bolsa::model()->findByAttributes(array('empresas_id'=>$empresas->empresas_id)); 
                                                                 echo BolsaHasInventario::model()->countByAttributes(array('bolsa_id'=>$bolsa->id));
                                                             }
                                                             else
                                                             {
                                                                echo "0";
                                                             }
                                                        }
                                                            ?></span>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-xs-8 no_horizontal_padding title">
                                                   
                                                        <span class="text" >Carrito</span>                                        
                                                        <span class="caret no_margin_left"></span>                                        
                                                    </div>
                                                </div>                                
                                              </a>
                                              <ul class="dropdown-menu right" aria-labelledby="dropdownMenu1">
                                                
                                               
                                                    <?php 
                                                    
                                                    if($usuario):
                                                     $myempresa = $usuario->empresa;
                                                     if(!is_null($myempresa->bolsa->getLastItems(3) ))
                                                     foreach($myempresa->bolsa->getLastItems(3) as $item): ?>
                                                        <li>
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true)."/site/carrito"?>" class="ellipsis" style="width:100%" href="#">
                                                                <img src="<?php echo $item->getImagenPrincipal(true);?>" width="30" height="30"/> 
                                                                <?php echo $item->nombre ?>
                                                            </a>                                            
                                                        </li>
                                
                                                   <?php endforeach; ?>
                                                 
                                                   <li class="separator"></li>
                                                    <li><a class="text-center" href="<?php echo Yii::app()->getBaseUrl(true)."/site/carrito"?>">Ver carrito</a></li>
                                                <?php  endif;?>
            
                                              </ul>                                                                           
                                             
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            
                            
                            
                            
                            
                            
                                           
               
             <!--       <div class="col-md-5 col-sm-5 col-xs-6  no_horizontal_padding" id="headLinks"></div>
                    <div class="col-md-5 col-sm-5  col-xs-6 no_horizontal_padding">
                        <div class="text-right clientService" title="(0800) 568.36.46 - SERVICIO@TELOTENGO.COM">
                            SERVICIO AL CLIENTE: (0800) 568.36.46 | SERVICIO@TELOTENGO.COM
                        </div>
                    </div> -->
                    <div class="col-md-2 col-sm-2 col-xs-2 no_padding_left" id="categoryMenu">
                        <div class="dropdown drophover">
                                  <a class="form-control text-left dropdown-toggle no_horizontal_padding no_border" id="categoryMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="mainText">Categorías</span><span class="caret"></span> <span class="searchby">Buscar por:</span>                                 
                                  </a>
                                  <ul class="dropdown-menu arrow_box" aria-labelledby="dropdownMenu1" id="categories">
                                    <?php foreach($model as $modelado)
                                    {?>
                                        <li>
                                            <a href='<?php echo Yii::app()->createUrl('tienda/index', array('categoria'=>$modelado->url_amigable))?>'>
                                                <?php echo $modelado->nombre;?>
                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                                    <?php   
                                    }?>
                                    
                                  <!--  <li class="separator"></li>
                                    <li><a href="#">Something else here</a></li> -->
                                    
                                  </ul>
                            </div> 
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12 no_horizontal_padding">
                        <div class="separator no_horizontal_padding"></div>
                    </div>
                    
                    
                    
                    
                </div> 
        </div>
</div>
<?php
if(isset(Yii::app()->session['banner'])){?>
    <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/banner.jpg" width="100%"/>
<?php 
    unset(Yii::app()->session['banner']);
    }
?>

<div class="col-md-8 col-md-offset-2 no_horizontal_padding" id="pageContainer">
        <div class="row-fluid margin_top_small">   
             <?php if(isset($this->breadcrumbs)):?>
              <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                    )); ?>
              <!-- breadcrumbs -->
              <?php endif?> 
            <?php echo $content; ?>
    </div>
</div>
<div class="col-md-12 margin_top_large margin_bottom_large"></div>
<!--
  <div class="footer padding_bottom_small">
      <div class="container">
          <div class="row-fluid">
              
          </div>
      </div>
  </div>
-->

<script>
$(document).ready(function() {
    var filtroBusqueda="";
    $('#busqueda').on('change', function(event) { //// REVISAR EVENTOS JQ
        var filtro=$('#categorySearch').val()
                $.ajax({
                 url: "<?php echo Yii::app()->createUrl('Site/filtroBusqueda') ?>",
                 type: 'POST',
                 data:{
                        filtro:filtro,
                       },
                success: function (data) {
                    filtroBusqueda=data;
                    $('#oculto').val(data);
                    
                }
               })
    });
    
    $('#categorySearch').on('change', function(event) {
            
            var filtro=$(this).val();
                $.ajax({
                 url: "<?php echo Yii::app()->createUrl('Site/filtroBusqueda') ?>",
                 type: 'POST',
                 data:{
                        filtro:filtro,
                       },
                success: function (data) {
                    filtroBusqueda=data;
                    $('#oculto').val(data);
                }
               })
            
        });
        
        
        $('#botonBusqueda').on('click', function(event) {
            
            var busqueda=$('#busqueda').val();
            if(busqueda=="")
                return false;
            var path='<?php echo Yii::app()->createUrl('tienda/index');?>';
            '<?php unset(Yii::app()->session['menu']);?>'
                if(filtroBusqueda!="")
                {
                    $.ajax({
                     url: "<?php echo Yii::app()->createUrl('tienda/buscarCategoria') ?>",
                     type: 'POST',
                     data:{
                            filtroBusqueda:filtroBusqueda,
                           },
                    success: function (data) {
                        window.location.href = path+'?producto='+busqueda+'&categoria='+data;
                        
                    }
                   })
                    
                }
                else
                {
                    window.location.href = path+'?producto='+busqueda;
                }
            //window.location.href = '../tienda/index?producto='+busqueda;
            //window.location.href = '../tienda/index/'+busqueda;
                
            
        });
        
        $('#busqueda').on('click', function(event) {
            var filtro=$('#categorySearch').val()
                $.ajax({
                 url: "<?php echo Yii::app()->createUrl('Site/filtroBusqueda') ?>",
                 type: 'POST',
                 data:{
                        filtro:filtro,
                       },
                success: function (data) {
                    filtroBusqueda=data;
                    $('#oculto').val(data);
                    
                }
               })
        });
        
        $('#busqueda').on('focus', function(event) {
            $(document).keypress(function(e) {
             if(e.which == 13) 
             {
                var busqueda=$('#busqueda').val();
                if(busqueda=="")
                    return false;
                var path='<?php echo Yii::app()->createUrl('tienda/index');?>';
                if(filtroBusqueda!="")
                {
                    $.ajax({
                     url: "<?php echo Yii::app()->createUrl('tienda/buscarCategoria') ?>",
                     type: 'POST',
                     data:{
                            filtroBusqueda:filtroBusqueda,
                           },
                    success: function (data) {
                        window.location.href = path+'?producto='+busqueda+'&categoria='+data;
                        
                    }
                   })
                    
                }
                else
                {
                    window.location.href = path+'?producto='+busqueda;
                }
                
              }
            });
        });
}); 
</script>