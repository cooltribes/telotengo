<?php
$assetUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.user.views.asset'));
        Yii::app()->getClientScript()->registerCssFile($assetUrl.'/css/redmond/jquery-ui.css');
        Yii::app()->getClientScript()->registerScriptFile($assetUrl.'/js/jquery-ui.min.js');
                                        $usuario=User::model()->findByPk(Yii::app()->user->id);
$userAdmin=EmpresasHasUsers::model()->findByAttributes(array('users_id'=>Yii::app()->user->id))->admin;
?>
<nav class="navbar navbar-default row-fluid seller" id="adminNav">
        <div class="container-fluid col-md-8 col-md-offset-2 no_horizontal_padding">
          <!--<div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>-->
          
          <div id="navbar">
          <div class="row-fluid" id="sellerMenu">
              <div class="col-md-2 col-sm-5 col-xs-6 logoTLTVendedor"><a class="" href="<?php echo Yii::app()->getBaseUrl(true);?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/whitelogo.png" width="100%"/></a></div>
              <div class="col-md-5 col-sm-7 col-xs-7 no_horizontal_padding" id="search-bar">
                  <div class="row-fluid searchBar">
                            <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding">
                                <div class="dropdown">
                                  <select class="btn btn-default form-control no_radius dropdown-toggle orange_border_left"  id="sellerOptions" >
                                    <option value="" selected>En:</option>
                                 <?php 
                                 foreach(Funciones::sellerOptions() as $key=>$opciones)
                                 {?>
                                  <option value="<?php echo $key?>"><?php echo $opciones;?></option>
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
                               <input class="form-control no_radius orange_border_middle" id="querySeller" placeholder:"Nombres o números de registro"/>
                              
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 no_horizontal_padding">
                                <?php 
                                $usuario=User::model()->findByPk(Yii::app()->user->id);
                                echo CHtml::submitButton('Buscar', array('id'=>'btn-sellerLayout','class'=>'btn-orange btn btn-danger orange_border')); ?>
                            </div>
                        </div>
              </div>
              <div class="col-md-5 col-sm-12 col-xs-12 no_right_padding">
                  <div class="row-fluid">
                      <div class="col-md-6 col-sm-5 col-xs-5 no_right_padding">
                          <div class="dropdown drophover">
                                                      <a class="form-control text-left dropdown-toggle no_padding no_border" id="userButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <div class="row-fluid">
                                                            <div class="col-md-2 col-sm-3 col-xs-3 image">
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
                                                            <div class="col-md-10 col-sm-9 col-xs-9 no_right_padding title">
                                                                 <div class="text user"><?php #echo Profile::model()->retornarNombreCompleto(Yii::app()->user->id);
                                                                 echo Funciones::retornarNombreEntorno(Profile::model()->retornarNombreCompleto(Yii::app()->user->id), 0);
                                                                 ?></div>
                                                                 <span class="caret user"></span>
                                                            </div>
                                                            
                                                        </div>                                
                                                      </a>
                                                      
                                                      <ul class="dropdown-menu right" aria-labelledby="dropdownMenu1">
                                                          <li><a href="<?php echo Yii::app()->baseUrl.'/user/profile/index';?>">Mi Cuenta</a></li>
                                                          <li><a href="<?php echo Yii::app()->baseUrl.'/empresas/perfilVendedor';?>">Mi Empresa</a></li>
                                                         <?php if($userAdmin==1):?>
                                                              <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/administrador";>Panel de control</a></li>
                                                         <?php endif;?>
                                                          <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/invitarUsuario";>Invitaciones</a></li>
                                                          <li><a href="<?php echo Yii::app()->baseUrl; ?>/almacen/administrador";>Ver Sucursales</a></li>
                                                          <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/changeMode";>Comprar</a></li>
                                                          <li class="separator"></li>
                                                          <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout";>Cerrar sesión</a></li>
                                                      </ul>
                                                      
                                                                                                    
                                                    </div>
                      </div>
              
              <div class="col-md-6 col-sm-7 col-xs-7 no_horizontal_padding">
                 <!-- <div class="row-fluid">-->
              
              <div class="col-md-6 col-sm-6 col-xs-6 no_right_padding">
                  <div class="dropdown drophover">
                                                      <a class="form-control text-left dropdown-toggle no_padding no_border" id="userButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <div class="row-fluid">
                                                           
                                                            
                                                              <div class="col-md-3 col-md-3 col-xs-3 no_horizontal_padding icon">
                                                                  <span class="glyphicon glyphicon-list-alt"></span>
                                                              </div>
                                                            <div class="col-md-9 col-sm-9 col-xs-9 no_horizontal_padding title">
                                                                <div class="text user">Inventario</div>
                                                   
                                                              <span class="caret user no_margin_left"></span>
                                                              </div>  
                                                        </div>                                
                                                      </a>
                                                      
                                                      <ul class="dropdown-menu right" aria-labelledby="dropdownMenu2">
                                                          
                                                        <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/productoInventario";>Ver/Actualizar</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion";>Cargar</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/nuevoProducto";>Agregar producto nuevo</a></li>                                                      
                                                         <li class="separator"></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/inbound/administrador";>Inbound</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/masterdata/misMasterdata";>Masterdata</a></li>
                                                      </ul>
                                                      
                                                                                                    
                                                    </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6 no_right_padding">
                                            <div class="dropdown drophover">
                                              <a class="form-control text-left dropdown-toggle no_padding no_border " id="orderButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <div class="row-fluid">
                                                    <div class="col-md-3 col-md-3 col-xs-3 no_horizontal_padding icon">
                                                         <span class="glyphicon glyphicon-inbox"></span>
                                                         <span class="counter">
                                                             <?php 
                                                             if($usuario){
                           
                                                            $orders=Orden::model()->findAllBySql("select * from tbl_orden where estado=0 and almacen_id in (select id from tbl_almacen where empresas_id='".$usuario->empresa->id."') order by id desc");
                                                           
                                                             echo count($orders);
                                                             } else {
                                                                 $orders=array();
                                                                 $purchases=array();
                                                             }
                                                             ?> 
                                                         </span>
                                                    </div>
                                                    <div class="col-md-9 col-sm-9 col-xs-9 no_horizontal_padding title">
                                                         <span class="text user">Ordenes</span>
                                                   
                                                        <span class="caret user no_margin_left"></span>
                                                    </div>
                                                </div>                                
                                              </a>
                                              <ul class="dropdown-menu right" aria-labelledby="dropdownMenu1">
                                               
                                                  <?php foreach($orders as $key=>$order): ?> 
                                                   <li><a href="<?php echo Yii::app()->createUrl('orden/detalleVendedor', array('id'=>$order->id))?>"><b><?php echo $order->empresa->razon_social; ?></b> (<?php echo count($order->ordenHasInventarios); ?>)</a></li>
                                                  
                                                  <?php  
                                                    if($key==2)
                                                        break;
                                                  endforeach; ?> 
                                                  
                                                 
                                                <li class="separator"></li>
                                             
                                                    <li><a href="<?php echo Yii::app()->createUrl('orden/misVentas');?>">Ver todas las ordenes</a></li>
                                             
                                              </ul>
                                            </div>
                                        </div>
              
              
               <!-- </div>-->
              </div>
              
          </div> 
          
          
          </div><!--/.nav-collapse -->
                    <div class="busquedaMovil col-xs-12 col-sm-12">
                        <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding">
                                <div class="dropdown">
                                  <select class="btn btn-default form-control no_radius dropdown-toggle orange_border_left"  id="sellerOptionsMovil" >
                                    <option value="" selected>En:</option>
                                 <?php 
                                 foreach(Funciones::sellerOptions() as $key=>$opciones)
                                 {?>
                                  <option value="<?php echo $key?>"><?php echo $opciones;?></option>
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
                               <input class="form-control no_radius orange_border_middle" id="querySellerMovil" placeholder:"Nombres o números de registro"/>
                              
                            </div>
                                <div class="col-md-2 col-sm-2 col-xs-2 no_horizontal_padding">
                                    <?php 
                                    $usuario=User::model()->findByPk(Yii::app()->user->id);
                                    /*echo CHtml::submitButton('', array('span'=>'glyphicon-search','id'=>'botonBusqueda','class'=>'btn-orange btn btn-danger orange_border'));*/ ?>
                                    <button type="submit" id="btn-sellerLayoutMovil" class="btn-orange btn btn-danger orange_border">
                                      <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                     </div>
        </div><!--/.container-fluid -->
      </nav>

     <?php
 
if(isset(Yii::app()->session['banner'])){
  /*
   <a href="<?php echo Funciones::getBanner(1,1);?>"><img src="<?php echo Funciones::getBanner(1,2);?>" width="100%"/></a>
 */?>
   <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    <a href="<?php echo Funciones::getBanner(6,1);?>"><img src="<?php echo Funciones::getBanner(6,2);?>" width="100%"/></a>
    </div>

    <div class="item">
      <a href="<?php echo Funciones::getBanner(7,1);?>"><img src="<?php echo Funciones::getBanner(7,2);?>" width="100%"/></a>
    </div>

    <div class="item">
      <a href="<?php echo Funciones::getBanner(8,1);?>"><img src="<?php echo Funciones::getBanner(8,2);?>" width="100%"/></a>
    </div>

    <div class="item">
      <a href="<?php echo Funciones::getBanner(9,1);?>"><img src="<?php echo Funciones::getBanner(9,2);?>" width="100%"/></a>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Antes</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Despues</span>
  </a>
</div>
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
<script>
    $('#btn-sellerLayout').click(function(e){
        e.preventDefault();
        if($('#querySeller').val().replace(" ","").length>0&&$('')&&$('#sellerOptions').val()!=""){
            if($('#sellerOptions').val()=="producto"){
                window.location.href ='<?php echo $this->createUrl('producto/seleccion')?>?query='+$('#querySeller').val();
            }
            if($('#sellerOptions').val()=="inventario"){
                window.location.href ='<?php echo $this->createUrl('producto/productoInventario')?>?query='+$('#querySeller').val();
            }
            if($('#sellerOptions').val()=="orden"){
                window.location.href ='<?php echo $this->createUrl('orden/misVentas')?>?query='+$('#querySeller').val();
            }

        }
        
    });
    $('#btn-sellerLayoutMovil').click(function(e){
        e.preventDefault();
        if($('#querySellerMovil').val().replace(" ","").length>0&&$('')&&$('#sellerOptionsMovil').val()!=""){
            if($('#sellerOptionsMovil').val()=="producto"){
                window.location.href ='<?php echo $this->createUrl('producto/seleccion')?>?query='+$('#querySellerMovil').val();
            }
            if($('#sellerOptionsMovil').val()=="inventario"){
                window.location.href ='<?php echo $this->createUrl('producto/productoInventario')?>?query='+$('#querySellerMovil').val();
            }
            if($('#sellerOptionsMovil').val()=="orden"){
                window.location.href ='<?php echo $this->createUrl('orden/misVentas')?>?query='+$('#querySellerMovil').val();
            }
           
        }
        
    });
</script>