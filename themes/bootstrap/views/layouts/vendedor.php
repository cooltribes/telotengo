<?php
$assetUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.user.views.asset'));
        Yii::app()->getClientScript()->registerCssFile($assetUrl.'/css/redmond/jquery-ui.css');
        Yii::app()->getClientScript()->registerScriptFile($assetUrl.'/js/jquery-ui.min.js');
                                        $usuario=User::model()->findByPk(Yii::app()->user->id);

?>
<nav class="navbar navbar-default row-fluid" id="adminNav">
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
          
          <div id="navbar" class="navbar-collapse collapse">
          <div class="row-fluid" id="sellerMenu">
              <div class="col-md-2"><a class="" href="<?php echo Yii::app()->getBaseUrl(true);?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/whitelogo.png" width="100%"/></a></div>
              <div class="col-md-5"></div>
              <div class="col-md-5 no_horizontal_padding">
                  <div class="row-fluid">
                      <div class="col-md-6">
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
                                                          <li><a href="<?php echo Yii::app()->baseUrl; ?>/almacen/administrador";>Ver Almacenes</a></li>
                                                        <li><a href="<?php echo Yii::app()->baseUrl.'/tienda/index';?>">Ir a la tienda</a></li>
                                                          <li class="separator"></li>
                                                          <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout";>Cerrar sesión</a></li>
                                                      </ul>
                                                      
                                                                                                    
                                                    </div>
                      </div>
              <div class="col-md-3">
                  <div class="dropdown drophover">
                                                      <a class="form-control text-left dropdown-toggle no_padding no_border" id="userButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <div class="row-fluid">
                                                           
                                                            <div class="col-md-12 no_horizontal_padding title">
                                                                 <div class="text user">Inventario</div>
                                                                 <span class="caret user"></span>
                                                            </div>
                                                            
                                                        </div>                                
                                                      </a>
                                                      
                                                      <ul class="dropdown-menu right" aria-labelledby="dropdownMenu2">
                                                          
                                                        <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/productoInventario";>Ver Inventario</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/seleccion";>Cargar Inventario</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/nuevoProducto";>Agregar un producto</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/almacen/administrador";>Ver Almacenes</a></li>
                                                         <li class="separator"></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/inbound/administrador";>Inbound</a></li>
                                                         <li><a href="<?php echo Yii::app()->baseUrl; ?>/masterdata/misMasterdata";>Masterdata</a></li>
                                                      </ul>
                                                      
                                                                                                    
                                                    </div>
                  
              
              
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3 no_right_padding">
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
                                                         <span class="text">Ordenes</span>
                                                   
                                                        <span class="caret no_margin_left"></span>
                                                    </div>
                                                </div>                                
                                              </a>
                                              <ul class="dropdown-menu right" aria-labelledby="dropdownMenu1">
                                               
                                                  <?php foreach($orders as $key=>$order): ?> 
                                                   <li><a href="<?php echo Yii::app()->createUrl('orden/detalleVendedor', array('id'=>$order->id))?>"><span><?php echo $order->id;?></span> <b><?php echo $order->empresa->razon_social; ?></b> (<?php echo count($order->ordenHasInventarios); ?>)</a></li>
                                                  
                                                  <?php  
                                                    if($key==2)
                                                        break;
                                                  endforeach; ?> 
                                                  
                                                 
                                                <li class="separator"></li>
                                             
                                                    <li><a href="<?php echo Yii::app()->createUrl('orden/misVentas');?>">Ver todas las ordenes</a></li>
                                             
                                              </ul>
                                            </div>
                                        </div>
              
              
              
              
          </div> 
               
               
               
               
               
            
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
<?php    if(isset(Yii::app()->session['banner'])){?>
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