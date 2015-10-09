<?php /* @var $this Controller */ 
Yii::app()->session['menu']="";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.png" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon.ico" type="image/x-icon">
<?php  //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/styles.css',null); ?>


<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/helper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/dropdown.vertical.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/themes/default/default.css');
?>
<?php Yii::app()->bootstrap->register(); ?>
<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css',null); 
// $model = Categoria::model()->findAllBySql("select * from tbl_categoria where id_padre in (select id from tbl_categoria where id_padre=0)  order by nombre asc");
 $model=Categoria::model()->findAllByAttributes(array('id_padre'=>0), array('order'=>' id asc'));
?>
<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title>Sigma Tiendas</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

</head>

<div class="navbar row-fluid b2b clearfix no_margin_bottom" >
    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2" id="headerContainer">
                <div class="row-fluid">
                    <div class="col-md-2 col-sm-2 col-xs-5 no_padding_left">
                        <a href="<?php echo Yii::app()->baseUrl."/site/inhome2"; ?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/logo.png" width="100%"/></a> 
                    </div>     
                    <div class="col-md-5 col-sm-5 col-xs-6  no_horizontal_padding" id="headLinks"></div>
                    <div class="col-md-5 col-sm-5  col-xs-6 no_horizontal_padding">
                        <div class="text-right clientService" title="(0800) 568.36.46 - SERVICIO@TELOTENGO.COM">
                            SERVICIO AL CLIENTE: (0800) 568.36.46 | SERVICIO@TELOTENGO.COM
                        </div>
                    </div> 
                    <div class="col-md-2 col-sm-2 col-xs-2 no_padding_left" id="categoryMenu">
                        <div class="dropdown drophover">
                                  <a class="form-control text-left dropdown-toggle no_horizontal_padding no_border" id="categoryMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="mainText">Categorías</span><span class="caret"></span> <span class="searchby">Buscar por:</span>                                 
                                  </a>
                                  <ul class="dropdown-menu arrow_box" aria-labelledby="dropdownMenu1" id="categories">
                                  	<?php foreach($model as $modelado)
                                  	{?>
                                  		<li><a href="<?php echo Yii::app()->createUrl('site/category', array('categoria'=>$modelado->id));?>"><?php echo $modelado->nombre;?><span class="arrow"></span></a></li>
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
								    'source'=>$this->createUrl('Site/autoComplete'),
									'htmlOptions'=>array(
								          //'size'=>22,
										  'placeholder'=>'Incluye palabras claves...',
										  'class'=>'form-control no_radius orange_border_middle',
								          //'maxlength'=>45,
								        ),
								    // additional javascript options for the autocomplete plugin
								    'options'=>array(
								            'showAnim'=>'fold',
								            
								    ),
									));	
									?>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 no_horizontal_padding">
                                <?php echo CHtml::submitButton('Buscar', array('id'=>'botonBusqueda','class'=>'btn-orange btn btn-danger btn-large orange_border')); ?>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-4 col-sm-4 col-xs-12 no_horizontal_margin no_horizontal_padding">
                        <div class="row-fluid" id="userMenu">
                            <div class="col-md-4 col-sm-4 col-xs-4 no_right_padding">
                                <div class="dropdown drophover">
                                  <a class="form-control text-left dropdown-toggle no_padding no_border " id="orderButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <div class="row-fluid">
                                        <div class="col-md-3 col-md-3 col-xs-3 no_horizontal_padding icon">
                                             <span class="glyphicon glyphicon-inbox"></span>
                                             <span class="counter">88</span>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 no_horizontal_padding title">
                                             <span class="text">Ordenes</span>
                                       
                                            <span class="caret no_margin_left"></span>
                                        </div>
                                    </div>                                
                                  </a>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="separator"></li>
                                    <li><a href="#">Separated link</a></li>
                                  </ul>
                                </div>
                            </div>
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
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    
                                   
                                        <?php 
                                        $usuario=User::model()->findByPk(Yii::app()->user->id);
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
                            <div class="col-md-5 col-sm-5 col-xs-5 no_horizontal_padding">
                                <div class="dropdown drophover">
                                  <a class="form-control text-left dropdown-toggle no_padding no_border" id="userButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <div class="row-fluid">
                                        <div class="col-md-3 col-sm-3 col-xs-3 no_horizontal_padding image">
                                            <div class="imgContainer">
                                            	<?php 
												if(isset($usuario))
												{
													$link=Yii::app()->getBaseUrl(true).'/images/user/'.$usuario->id."_thumb.png";
	                                            	$file_headers = @get_headers($link);
													if($file_headers[0] == 'HTTP/1.1 200 OK')
													{?>
													   <img src="<?php echo Yii::app()->baseUrl.'/images/user/'.$usuario->id."_thumb.png"?>" height="26px" width="26px"/>
													<?php
													}
													else
													{
														$link=Yii::app()->getBaseUrl(true).'/images/user/'.$usuario->id."_thumb.jpg";
	                                            		$file_headers = @get_headers($link);
														if($file_headers[0] == 'HTTP/1.1 200 OK')
														{?>
															<img src="<?php echo Yii::app()->baseUrl.'/images/user/'.$usuario->id."_thumb.jpg"?>" height="26px" width="26px"/>
														<?php
														}
														else 
														{?>
															<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.2.png" width="100%"/>
														<?php
														}
													}
												} 
	
                                            	?>
                                            </div>
                                             
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9 no_horizontal_padding title">
                                             <div class="text user"><?php if(isset($empresas))echo $empresas->empresas->razon_social;?></div>
                                             <span class="caret user"></span>
                                        </div>
                                        
                                    </div>                                
                                  </a>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo Yii::app()->baseUrl.'/user/profile';?>">Mi perfil</a></li>

                                    <li class="separator"></li>
                                    <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout";>Cerrar sesión</a></li>
                                  </ul>
                                </div>
                            </div>
                        </div>
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
        <div class="row-fluid margin_top">   
 
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
	$('#categorySearch').on('change', function(event) {
			
			var filtro=$(this).val();
				$.ajax({
		         url: "<?php echo Yii::app()->createUrl('Site/filtroBusqueda') ?>",
	             type: 'POST',
		         data:{
	                    filtro:filtro,
	                   },
		        success: function (data) {
		       	}
		       })
			
		});
		
		
		$('#botonBusqueda').on('click', function(event) {
			
			var busqueda=$('#busqueda').val();
			if(busqueda=="")
				return false;
			window.location.href = '../tienda/index?producto='+busqueda;
			//window.location.href = '../tienda/index/'+busqueda;
				
			
		});
});	
</script>
