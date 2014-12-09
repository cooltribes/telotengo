<?php

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.zoom.js');

Yii::app()->clientScript->registerMetaTag("Vive la experiencia tecnológica. Sigma Systems", null, null, array('property' => 'og:description'), null);
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag('Sigmatiendas.com', null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag($model->nombre, null, null, array('property' => 'og:title'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$model->mainimage->url), null, null, array('property' => 'og:image'), null); 

?>
<!-- CONTENIDO ON -->
<div class="container">

<?php
	echo CHtml::hiddenField('producto_id', $model->id, array('id'=>'producto_id'));
?>
    <div class="row main-content">

        <section class="col-md-10" role="main">
            <div class="">
                <!-- IMAGENes ON -->
                
                <?php
                $main_image = $model->mainimage->url;
                ?>
                
                <div class=" col-md-5">
                	<div class='imagen_principal'> 
                    <figure>
                        <img width="450px" height="400px" src="<?php echo Yii::app()->baseUrl.$main_image; ?>" alt="<?php echo $model->nombre; ?>" id="principal">
                    </figure>
                    </div>
                    <div class="margin_top_small">
                        
                    <?php 
                        $imagenes = $model->imagenes;
                        
                        foreach($imagenes as $imagen){
                            
                            $path = str_replace(".","_x90.",$imagen->url);
                            
                        /*    echo '  <div class="col-xs-6 col-md-3">
                                    <a href="#" class="thumbnail">
                                        <img width="110px" height="110px" src="'.Yii::app()->baseUrl.$path.'" alt="..."> 
                                    </a>
                                    </div>';
						*/
								
							echo '<div class="col-xs-6 col-md-3">';		
							echo CHtml::image(Yii::app()->baseUrl.$path, $model->nombre, array("width" => "80", "height" => "80", 'id'=>'thumb'.$imagen->id, 'class'=>'thumbnail','style'=>'cursor: pointer'));
							echo '</div>';	
									
                        }
                    ?>
                                                    
                    </div>
                </div>
                <!-- IMAGENes OFF -->
                <div class="col-md-7">
                    <div class="page-header">
                                <h1><?php echo $model->nombre; ?> <small><?php echo $model->modelo; ?></small></h1>
                                <span>Por: <a href="<?php echo Yii::app()->baseUrl.'/marcas/'.$model->marca->nombre; ?>"><?php echo $model->marca->nombre; ?></a></span>
                                <p><span>Agregar a Favoritos: 
                                    <?php

                                        if(!Yii::app()->user->isGuest){
                                            $like = UserFavoritos::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$model->id));
                                        }
                                    ?>
                                    <button id="Favorito" onclick='AddFavorito()' title="Agregar a Favoritos" class="btn-link btn-link-active">
                                    <?php
                                        if(isset($like)){ // le ha dado like    
                                            echo '<span id="like" class="entypo">&hearts;</span>';
                                        }else{
                                            echo "<span id='like' class='entypo icon_personaling_big'>&#9825;</span>";
                                        }
                                    ?>
                                    </button>

                               </span></p>

                                <?php
                                if($calificacion_promedio >= 0 && $calificacion_promedio < 1){
                                    $clase_1 = 'glyphicon glyphicon-star-empty';
                                    $clase_2 = 'glyphicon glyphicon-star-empty';
                                    $clase_3 = 'glyphicon glyphicon-star-empty';
                                    $clase_4 = 'glyphicon glyphicon-star-empty';
                                    $clase_5 = 'glyphicon glyphicon-star-empty';
                                }

                                if($calificacion_promedio >= 1 && $calificacion_promedio < 2){
                                    $clase_1 = 'glyphicon glyphicon-star';
                                    $clase_2 = 'glyphicon glyphicon-star-empty';
                                    $clase_3 = 'glyphicon glyphicon-star-empty';
                                    $clase_4 = 'glyphicon glyphicon-star-empty';
                                    $clase_5 = 'glyphicon glyphicon-star-empty';
                                }

                                if($calificacion_promedio >= 2 && $calificacion_promedio < 3){
                                    $clase_1 = 'glyphicon glyphicon-star';
                                    $clase_2 = 'glyphicon glyphicon-star';
                                    $clase_3 = 'glyphicon glyphicon-star-empty';
                                    $clase_4 = 'glyphicon glyphicon-star-empty';
                                    $clase_5 = 'glyphicon glyphicon-star-empty';
                                }
                                
                                if($calificacion_promedio >= 3 && $calificacion_promedio < 4){
                                    $clase_1 = 'glyphicon glyphicon-star';
                                    $clase_2 = 'glyphicon glyphicon-star';
                                    $clase_3 = 'glyphicon glyphicon-star';
                                    $clase_4 = 'glyphicon glyphicon-star-empty';
                                    $clase_5 = 'glyphicon glyphicon-star-empty';
                                }

                                if($calificacion_promedio >= 4 && $calificacion_promedio < 5){
                                    $clase_1 = 'glyphicon glyphicon-star';
                                    $clase_2 = 'glyphicon glyphicon-star';
                                    $clase_3 = 'glyphicon glyphicon-star';
                                    $clase_4 = 'glyphicon glyphicon-star';
                                    $clase_5 = 'glyphicon glyphicon-star-empty';
                                }

                                if($calificacion_promedio == 5){
                                    $clase_1 = 'glyphicon glyphicon-star';
                                    $clase_2 = 'glyphicon glyphicon-star';
                                    $clase_3 = 'glyphicon glyphicon-star';
                                    $clase_4 = 'glyphicon glyphicon-star';
                                    $clase_5 = 'glyphicon glyphicon-star';
                                }
                                ?>
                                <div>
                                    <?php echo CHtml::link('<span id="calificacion_1" class="'.$clase_1.'"></span>', '', array('onclick'=>'guardar_calificacion('.$model->id.', 1)', 'style'=>'cursor: pointer;')); ?>
                                    <?php echo CHtml::link('<span id="calificacion_2" class="'.$clase_2.'"></span>', '', array('onclick'=>'guardar_calificacion('.$model->id.', 2)', 'style'=>'cursor: pointer;')); ?>
                                    <?php echo CHtml::link('<span id="calificacion_3" class="'.$clase_3.'"></span>', '', array('onclick'=>'guardar_calificacion('.$model->id.', 3)', 'style'=>'cursor: pointer;')); ?>
                                    <?php echo CHtml::link('<span id="calificacion_4" class="'.$clase_4.'"></span>', '', array('onclick'=>'guardar_calificacion('.$model->id.', 4)', 'style'=>'cursor: pointer;')); ?>
                                    <?php echo CHtml::link('<span id="calificacion_5" class="'.$clase_5.'"></span>', '', array('onclick'=>'guardar_calificacion('.$model->id.', 5)', 'style'=>'cursor: pointer;')); ?>
                                    <small><span id="total_calificaciones">
                                        <?php
                                        if($numero_calificaciones > 0){
                                            $texto = ' calificaciones de este producto';
                                            if($numero_calificaciones == 1){
                                                $texto = ' calificación de este producto';
                                            }
                                            echo CHtml::link($numero_calificaciones.$texto, '#');
                                        }else{
                                            echo 'No hay calificaciones para este producto';
                                        }
                                        ?>
                                        
                                    </span></small>
                                    |
                                    <small><span id="calificacion_usuario">
                                        <?php
                                        if($calificacion_usuario){
                                            echo 'Tu calificación: '.$calificacion_usuario->puntuacion;
                                        }else{
                                            echo 'No has calificado este producto';
                                        }
                                        ?>
                                    </span></small>
                                    <!-- <small>Últimos 6 meses: 296 órdenes (296 unidades)</small> -->
                                </div>               
                    </div>  
                    <?php

                        // inventario_menor_precio tiene el inventario con menor precio para el producto
                        $inventario_menor_precio = Inventario::model()->getMenor($model->id);
                        $almacen = Almacen::model()->findByPk($inventario_menor_precio->almacen_id);
                        $ciudad = Ciudad::model()->findByPk($almacen->ciudad_id);
                        $provincia = Provincia::model()->findByPk($almacen->provincia_id);


                        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                            'action'=>Yii::app()->baseUrl.'/bolsa/agregar',
                            'id'=>'inventario_form',
                            'enableAjaxValidation'=>false,
                        ));
                        
                        echo CHtml::hiddenField('inventario_seleccionado_id', $inventario_menor_precio->id, array('id'=>'inventario_seleccionado_id'));

                        $this->endWidget();

                        $caracteristicas_menor_precio = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario_menor_precio->id));

                        // La variable inventarios tiene todos los objetos de inventarios que tenga en producto_id del modelo en cuestion ordenados por precio, excepto el de menor precio
                        $inventarios = Inventario::model()->getOpcionesCompra($inventario_menor_precio->id, $model->id);
                        //foreach($inventarios as $r)
                        //  var_dump($r);

                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="dl-horizontal">
								
								<dt class="padding_xsmall oferta lean" style="display: none;"></dt>
								<dd class="padding_xsmall oferta" style="display: none;"> ¡EN OFERTA! </dd>
								
								<dt class="padding_xsmall fechas" style="display: none;">Hasta: </dt>
								<dd class="padding_xsmall fecha" style="display: none;"></dd>
								
                            	<dt class="padding_xsmall">Disponibilidad </dt>
                                <dd class="padding_xsmall text-danger"> Sólo quedan <span id='inventario_cantidad'><?php echo $inventario_menor_precio->cantidad; ?><span></dd>
                            	
                               <!-- <dt class="padding_xsmall">Precio en tiendas</dt>

                                <dd class="padding_xsmall precio_tienda">Bs. <?php echo $inventario_menor_precio->precio_tienda; ?></dd> -->
                                <dt class="padding_xsmall">Precio</dt>
                                <dd class="padding_xsmall precio">Bs. <?php echo $inventario_menor_precio->precio; ?></dd>

                                <!-- <dt class="padding_xsmall">Ahorras</dt>
                                <dd class="padding_xsmall descuento">Bs. 
                                <?php	
                                		
                               		$a = $inventario_menor_precio->precio / $inventario_menor_precio->precio_tienda;
                                	$b = 1 - $a;
									$c = $b * 100;
                                	
									$porcentaje = round($c,2);
									$valor = $inventario_menor_precio->precio_tienda - $inventario_menor_precio->precio;
								
								echo $valor." (".$porcentaje."%)";
									
                                ?>
                                </dd> -->

                                <?php
                                // Características
                                $caract = array();  

                                // $inventarios_all tiene todos los inventarios. Se usa para buscar las características disponibles para este producto
                                $inventarios_all = Inventario::model()->findAllByAttributes(array('producto_id'=>$model->id));

                                echo CHtml::hiddenField('producto_id', $model->id, array('id'=>'producto_id'));

                                // Recorrer cada una de las categorías asociadas al producto para buscar sus características
                                foreach ($model->categorias as $categoria){
                                    $categoria_caracteristicas = CategoriaHasCaracteristicaSql::model()->findAllByAttributes(array('categoria_id'=>$categoria->id));

                                    // Para cada categoría busco las características
                                    foreach ($categoria_caracteristicas as $c_caracteristica) {
                                        if(!in_array($c_caracteristica->caracteristica->nombre, $caract)){ 
                                            array_push($caract,$c_caracteristica->caracteristica->nombre);

                                            $caracteristica_producto = CaracteristicasProducto::model()->findByAttributes(array('producto_id'=>$model->id, 'caracteristica_id'=>$c_caracteristica->caracteristica_id));;
                                            
                                            if($caracteristica_producto){
                                                ?>
                                                <dt class="padding_xsmall"><?php echo $c_caracteristica->caracteristica->nombre; ?></dt>
                                                <dd class="padding_xsmall">
                                                    <div class="btn-group" data-toggle="buttons">
                                                        <?php
                                                        // Para cada característica asociada a una categoría, busco los diferentes valores cargados en MongoDB
                                                        $criteria = new EMongoCriteria(array(
                                                            'conditions'=>array(
                                                                'caracteristica_id'=>array('==' => $c_caracteristica->caracteristica->id), 
                                                                'producto_id'=>array('==' => $model->id), 
                                                            ),
                                                            'sort'=>array('valor' => EMongoCriteria::SORT_ASC),
                                                        ));
                                                        //$criteria->condition = "caracteristica_id = ".$c_caracteristica->caracteristica->id.' AND producto_id = '.$model->id;
                                                        $caracteristicas_nosql = Caracteristica::model()->findAll($criteria);
                                                        
                                                        //$caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('caracteristica_id'=>$c_caracteristica->caracteristica->id, 'producto_id'=>$model->id), array('order'=>'valor'));
                                                        // En MongoDB hay muchos valores repetidos para cada característica, es necesario guardar valores únicos en $printed
                                                        $printed = array();
                                                        foreach ($caracteristicas_nosql as $c_nosql) {
                                                            if(!in_array($c_nosql->valor, $printed)){
                                                                $printed[] = $c_nosql->valor;
                                                                //echo $c_nosql->valor.'<br/>';
                                                                
                                                            }
                                                        }

                                                        // Muestro los valores guardados en $printed como características disponibles para este producto
                                                        foreach ($printed as $valor) {
                                                            $active = '';
                                                            foreach ($caracteristicas_menor_precio as $caracteristica_mp) {
                                                                /*print_r($caracteristica_mp->_id);
                                                                echo '<br/></br>';
                                                                print_r($c_nosql->_id);*/
                                                                //echo $caracteristica_mp->caracteristica_id.' == '.$c_nosql->caracteristica_id.'</br>';
                                                                //echo $caracteristica_mp->valor.' == '.$c_nosql->valor.'<br/></br>';
                                                                if($caracteristica_mp->caracteristica_id == $c_caracteristica->caracteristica_id && $caracteristica_mp->valor == $valor){
                                                                    $active = 'active';
                                                                }
                                                            }
                                                            ?>
                                                            <label class="btn btn-default radio_caracteristicas <?php echo $active; ?>" >
                                                                <input type="radio" name="<?php //echo $caracteristica_sql->id; ?>" id="<?php //echo $c_nosql->_id; ?>" value="<?php echo $valor; ?>" /> <?php echo $valor; ?>
                                                            </label>
                                                            <?php
                                                        }
                                                        ?>
                                                        
                                                    </div>
                                                </dd>
                                                <?php
                                            }
                                            //print_r($c_caracteristica);
                                            //echo '<br/><br/>';
                                        }
                                    }
                                }
                                //print_r($model->categorias);
                                // $caracteristicas_all almacena todas las caracteristicas encontradas en nosql para este producto, 
                                /*$caracteristicas_all = array();
                                $caracteristicas_agrupadas = array();
                                foreach ($inventarios_all as $inventario) {
                                    $caracteristicas_nosql = Caracteristica::model()->findAllByAttributes(array('inventario_id'=>$inventario->id));
                                    foreach ($caracteristicas_nosql as $caracteristica) {
                                        //if(isset($características_all[$caracteristica->caracteristica->id])){
                                            $caracteristicas_all[$caracteristica->caracteristica_id][] = $caracteristica;
                                            if(!in_array($caracteristica->valor, $caracteristicas_agrupadas)){
                                                $caracteristicas_agrupadas[] = $caracteristica->valor;
                                            }
                                        //}
                                    }
                                    
                                }*/

                                //print_r($caracteristicas_all);

                                // Lógica nueva, esperemos que funcione

                               /* foreach ($caracteristicas_agrupadas as $value) {
                                    
                                }



                                // Lógica anterior, si esta no funciona descomentar esto y comenzar de nuevo

                                /*foreach ($caracteristicas_all as $key => $caracteristica_all) {
                                    //echo $key.' --> ';
                                    //var_dump($caracteristica_all);
                                    //echo 'br/><br/>';
                                    //echo 'Key: '.$key.'<br/>';
                                    //print_r($caracteristicas_nosql);
                                    $caracteristica_sql = CaracteristicasSql::model()->findByPk($key);
                                    //$caracteristicas_array = array();
                                    ?>
                                    <dt class="padding_xsmall"><?php echo $caracteristica_sql->nombre; ?></dt>
                                    <dd class="padding_xsmall">
                                        <div class="btn-group" data-toggle="buttons">
                                            <?php
                                            foreach ($caracteristica_all as $c_nosql) {
                                                /*echo $key.' --> ';
                                                var_dump($c_nosql);
                                                echo '<br/><br/>';
                                                //$caracteristicas_array[] = array('label'=>$value, 'value'=>$key);
                                                $active = '';
                                                foreach ($caracteristicas_menor_precio as $caracteristica_mp) {
                                                    /*print_r($caracteristica_mp->_id);
                                                    echo '<br/></br>';
                                                    print_r($c_nosql->_id);
                                                    //echo $caracteristica_mp->caracteristica_id.' == '.$c_nosql->caracteristica_id.'</br>';
                                                    //echo $caracteristica_mp->valor.' == '.$c_nosql->valor.'<br/></br>';
                                                    if($caracteristica_mp->caracteristica_id == $c_nosql->caracteristica_id && $caracteristica_mp->valor == $c_nosql->valor && $caracteristica_mp->_id == $c_nosql->_id){
                                                        $active = 'active';
                                                    }
                                                }
                                                ?>
                                                <label class="btn btn-default <?php echo $active; ?>">
                                                    <input type="radio" name="<?php echo $caracteristica_sql->id; ?>" id="<?php echo $c_nosql->_id; ?>" value="<?php echo $c_nosql->valor; ?>"> <?php echo $c_nosql->valor; ?>
                                                </label>
                                                <!-- <a href="#" class="btn-default btn"><?php //echo $value; ?></a> -->
                                                <?php
                                            }
                                            /*$this->widget('bootstrap.widgets.TbButtonGroup', array(
                                                'buttonType' => 'button',
                                                'type' => 'info',
                                                'toggle' => 'radio', // 'checkbox' or 'radio'
                                                'buttons' => $caracteristicas_array,
                                            ));*/
                                            ?>
                                        <!-- </div>
                                    </dd> -->
                                    <?php
                                /*}*/

                                //print_r($caracteristicas_menor_precio);

                                ?>

                                
                                
                                <?php 
                                
                                
								                                
                                ?> 
                                <dt class="padding_xsmall">Fecha estimada de entrega</dt>
                                <dd class="padding_xsmall">3-8 días</dd>                        
                            </dl>
                        </div>
                    <!-- REDES SOCIALES -->
                    <?php
                        $link = "http://telotengo.com/sigmatiendas/producto/detalle/".$model->id;
                        $tweetText = "SigmaSystems | ".$model->nombre." ".$model->modelo.". Por ".$model->marca->nombre;
                    ?>
                    <div class="fb-share-button" data-href=<?php echo $link; ?> data-layout="button"></div>
                    <a  href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-text="<?php echo $tweetText; ?>"
                        data-hashtags="LaMejorTecnologia" data-via="Sigmatiendas">Tweet</a>
                    
                    <p><strong>Descripción del producto</strong></p>
                    <?php
                        echo $model->descripcion;
                    ?>
                    
                </div>
            </div>
        </section>
        <section class="col-md-2">
            <div class="caja">
                <div>
                    <h4 >Mejor Precio: <span class="text-danger title_medium precio">Bs. <?php echo $inventario_menor_precio->precio; ?></span></h4>
                </div>
                <h4>Costo de Envio: <span class="text-success">Gratis</span></h4>
                <a href="#" class="btn btn-success btn-block btn-lg" onclick="agregar_bolsa()">Comprar</a>
                <div class="text_align_center margin_top_small">
                    <?php
	                if(!Yii::app()->user->isGuest){
	                	
		                $this->widget('bootstrap.widgets.TbButton', array(
							'icon'=>'glyphicon glyphicon-heart',
						    'label'=>' Añadir a mi lista de deseos',
						    //'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'small', // null, 'large', 'small' or 'mini'
						    'htmlOptions'=> array(
							    'data-toggle'=>'modal',
								'data-target'=>'#modalWishlist', 
							    'onclick'=>"{wishlist();}"
							),
								       
						));
				
					}
					
					?>	
                    
                </div>
                <hr>
                
                <p class="text-muted">Vendido y enviador por:</p>
                <p><strong>Sigma Sys C.A.</strong></p>
                <p><span>Desde San Cristóbal, Táchira</span></p>
            </div>
        </section>

    </div>
    </div>
	
    <hr/>
	
	<h3>Preguntas.</h3>
	<hr/>
	
	<div class="well">
	<div class="row padding_left_large padding_right_large "> 
		<div>
	
	<?php
	
	if(!Yii::app()->user->isGuest)
	{
		$pregunta = new Pregunta;

		$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'pregunta-form',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'type'=>'horizontal',
			'clientOptions'=>array(
				'validateOnSubmit'=>true, 
			),
			'htmlOptions' => array(
		        'enctype' => 'multipart/form-data',
		    ),
		));
	?> 
		
	<div class="form-group">
		<?php echo $form->textAreaRow($pregunta,'pregunta',array('class'=>'form-control','maxlength'=>350)); ?>
	</div>
	
	<?php echo CHtml::hiddenField('id', $model->id, array('id'=>'id')); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Preguntar',
		)); ?>
	</div>
	
<?php $this->endWidget(); 

?>

	</div>
	</div>	
	<hr/>
<?php } // is not guest ?>

	<h4>Anteriores</h4>
	
	<?php
		$preguntas = Pregunta::model()->findAllByAttributes(array('producto_id'=>$model->id));
	
		if(count($preguntas)>0){
			foreach($preguntas as $preg){
				echo '<b>Pregunta:</b> '.$preg->pregunta;
				echo " - <small>".date('d/m/Y',strtotime($preg->fecha))."</small>";
				
				$respuestas = Respuesta::model()->findAllByAttributes(array('pregunta_id'=>$preg->id));
				
				if(count($respuestas)>0){
					foreach($respuestas as $respuesta){
						echo '<div class="row padding_left_large padding_right_large ">';
						echo "Respuesta: ".$respuesta->comentario;
						echo " - <small>".$respuesta->fecha."</small>";
						echo '</div>';					
					}
				}
				
				echo "<hr/>";
				
			}
		}
		else {
			echo "Este producto aún no tiene preguntas.";
		}
	
	?>
	
    </div>
</div>

<!- MODAL WINDOW ON -> 

<div class="modal fade" id="modalWishlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<div class="modal fade" id="modalFavorito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<!- MODAL WINDOW OFF ->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=430758747053394&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type="text/javascript">

	function wishlist()
	{
	
	    <?php echo CHtml::ajax(array(
	            'url'=>array('wishlist/modalchoose'),
	            'data'=>"js:{id:$('#producto_id').attr('value')}",
	            'type'=>'post',
	            'success'=>"function(data)
	            {
	               $('#modalWishlist').html(data);	              
	            } ",
	            )) ?>;
	    return false; 
	 
	}
 
</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


<script>
	
    $(document).ready(function(){

    	var source = $('#principal').attr("src");
    	var imgZ = source.replace(".","_orig.");
    	
    	$('.imagen_principal').zoom({url: imgZ});
    	
    		$(".imagen_principal").hover(function(){ 
    			var source = $('#principal').attr("src");
    			var imgZ = source.replace(".","_orig.");
    			
    			if(imgZ.indexOf(".png")> -1){ // consiguio png
    				zoom = imgZ.replace(".png",".jpg");
    				$('.imagen_principal').zoom({url: zoom});
    			}else{
    				$('.imagen_principal').zoom({url: imgZ});
    			}   		
    			
    		});
    	
    });
	
	
	$(".thumbnail").click(function(){
     	var image = $("#principal");
     	var thumbnail = $(this).attr("src");
     	
     	var cambio = thumbnail.replace("_x90.",".");
     	
     	// primero cargo la imagen del zoom y aseguro que al momento de hacer el cambio de imagen principal esté listo el zoom
     	var source = cambio;
		var imgZ = source.replace(".","_orig.");
		
     	// $('.imagen_principal').zoom({url: imgZ});
        
        if(imgZ.indexOf(".png")> -1){ // consiguio png
    		zoom = imgZ.replace(".png",".jpg");
    		$('.imagen_principal').zoom({url: zoom});
    	}else{
    		$('.imagen_principal').zoom({url: imgZ});
    	}   	 
          
        // cambio de la principal  	
     	$("#principal").fadeOut("slow",function(){
     		$("#principal").attr("src", cambio);
     	});

      	$("#principal").fadeIn("slow",function(){});

    });

    function AddFavorito(){
        var producto_id = $("#producto_id").attr("value");
        
            $.ajax({
                type: "post",
                dataType:"json",
                url: "<?php echo Yii::app()->baseUrl;?>/producto/agregarFavorito", // action Tallas de Producto
                data: { 'idProd':producto_id}, 
                success: function (data) {
                    if(data.mensaje=="ok"){         
                        var a = "♥";
                        $("#Favorito").addClass("btn-link-active");
                        $("span#like").text(a);
                    }
                    if(data.mensaje=="no"){
                        var datos = '<div class="modal-dialog">';
                        datos = datos+'<div class="modal-content">';
        
                        datos = datos+" <div class='modal-header'>"; 
                        datos = datos+"<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
                        datos = datos+"<h3>Agregar a Favoritos</h3></div>";
                        datos = datos+"<div class='modal-body'>";
                        datos = datos+"<div>Debes ingresar con tu cuenta de usuario o registrarte para poder tener un producto como favorito.</div>";
                        datos = datos+"</div>";
                        datos = datos+"<hr/>";
                        datos = datos+"</div>";
                        datos = datos+"</div>";
                        
                        $('#modalFavorito').html(datos);               
                        $('#modalFavorito').modal('show');
                        
                        //bootbox.alert("Debes ingresar con tu cuenta de usuario o registrarte para poder tener un producto como favorito.");          
                    }
                    if(data.mensaje=="borrado"){
                        var a = "♡";
                        $("#Favorito").removeClass("btn-link-active");
                        $("span#like").text(a);
                    }
                      
                }//success
            }) // ajax
    }

    $('.radio_caracteristicas').change(function(){
        //console.log('Clicked: '+$(this).children('input[type=radio]:first').val());
        var selected = '';
        $('input[type=radio]').each(function(){
            if($(this).parent().hasClass('active')){
                //console.log('Selected: '+$(this).val());
                selected += $(this).val()+',';
            }
        });
        var path = location.pathname.split('/');
        $.ajax({
              url: "<?php echo Yii::app()->createUrl('producto/loadInventario'); ?>",
              type: "post",
              data: { clicked : $(this).children('input[type=radio]:first').val(), selected : selected, producto_id : $('#producto_id').val() },
              dataType : 'json',
              success: function(data){
                    console.log(data);
                    $('#inventario_seleccionado_id').val(data.inventario.id);
                    $('input[type=radio]').each(function(){
                        $(this).parent().removeClass('active');
                    });
                    
                    if(data.flashsale.status==true)
                    {
                    	$('.precio').html('Bs. '+data.flashsale.precio);
	                   	$('#inventario_cantidad').html(data.flashsale.cantidad);
	                   	$('.descuento').html("Bs. " +data.flashsale.descuento);
	                   	
	                   	$('.oferta').show();
	                   	
	                   	$('.fecha').html(data.flashsale.fecha_fin);
	                   	$('.fecha').show();
	                   	
	                   	$('.fechas').show();
                    }
                    else
                    {
                    	$('.precio').html('Bs. '+data.inventario.precio);
	                   	$('#inventario_cantidad').html(data.inventario.cantidad);
	                   	
	                   	$('.oferta').hide();
	                   	$('.fecha').hide();
	                   	$('.fechas').hide();
                    }
                    
                    $('.precio_tienda').html('Bs. '+data.inventario.precio_tienda);

                    $('.inventario_provincia').html(data.provincia.nombre);
                    $('.inventario_ciudad').html(data.ciudad.nombre);
                    $('input[type=radio]').each(function(){
                        //console.log($(this).val());
                        for (var key in data.caracteristicas) {
                            //console.log(key + ' - ' + data.caracteristicas[key].valor);
                            if($(this).val() == data.caracteristicas[key].valor){
                                $(this).parent().addClass('active');
                                //console.log($(this).closest());
                            }
                        }

                        for (var key in data.not_found) {
                            //console.log(key + ' - ' + data.caracteristicas[key].valor);
                            if($(this).val() == data.not_found[key]){
                                $(this).parent().attr('disabled', 'disabled');
                                //console.log($(this).closest());
                            }
                        }
                   });
              },
        });
    });

    /*function get_inventario(valor, id_caracteristica, id_producto){
        console.log(valor+' - '+id_caracteristica);
        var path = location.pathname.split('/');
        $.ajax({
              url: "<?php echo Yii::app()->createUrl('producto/loadInventario'); ?>",
              type: "post",
              data: { valor : valor, caracteristica_id : id_caracteristica, producto_id : id_producto },
              dataType : 'json',
              success: function(data){
                    console.log(data);
                    $('input[type=radio]').each(function(){
                        $(this).parent().removeClass('active');
                    });
                    $('.precio').html('Bs. '+data.inventario.precio);
                    $('.precio_tienda').html('Bs. '+data.inventario.precio_tienda);
                    $('input[type=radio]').each(function(){
                        //console.log($(this).val());
                        for (var key in data.caracteristicas) {
                            //console.log(key + ' - ' + data.caracteristicas[key].valor);
                            if($(this).val() == data.caracteristicas[key].valor){
                                $(this).parent().addClass('active');
                                //console.log($(this).closest());
                            }
                        }
                   });
              },
        });
    }*/

	/*
	 * Funcion para agregar a un wishlist 
	 */
	function add(wishlist,producto,usuario)
	{
		var url = "<?php echo Yii::app()->baseUrl."/wishlist/listado"; ?>";
		
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('wishlist/agregar'); ?>",
            type: "post",
            data: { id: wishlist, producto_id:producto},
            success: function(data){
                location.href=url;
			},
        });
	
	}
	
	/*
	 * Funcion para crear un nuevo wishlist y luego agregar el prodicto
	 */
	function createadd(producto,usuario)
	{
		var url = "<?php echo Yii::app()->baseUrl."/wishlist/listado"; ?>";
		var nombre = $('#Wishlist_nombre').attr('value');
		
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('wishlist/crearagregar'); ?>",
            type: "post",
            data: { nombrewish: nombre, producto_id:producto, user_id: usuario},
            success: function(data){
                location.href=url;
			},
        });
		
	}

    function agregar_bolsa(){
        var path = location.pathname.split('/');
        $('#inventario_form').submit();
        /*$.ajax({
              url: "<?php echo Yii::app()->createUrl('bolsa/agregarAjax'); ?>",
              type: "post",
              data: { inventario_id : $('#inventario_seleccionado_id').val() },
              //dataType : 'json',
              success: function(data){
                    console.log('Redirect this shit');
              },
        });*/
    }

    function guardar_calificacion(producto_id, calificacion){
        //console.log('Id: '+producto_id+' - Calificacion: '+calificacion);
        var path = location.pathname.split('/');
        $.ajax({
              url: "<?php echo Yii::app()->createUrl('producto/calificar'); ?>",
              type: "post",
              data: { producto_id : producto_id, calificacion : calificacion },
              dataType : 'json',
              success: function(data){
                    console.log(data);
                    if(data.result == 'error'){
                        if(data.description == 'login'){ // usuario no estaba logueado, redireccionar al login
                            window.location = "<?php echo Yii::app()->createUrl('user/login'); ?>";
                        }
                    }else if(data.result == 'ok'){ // se guardo la calificacion, actualizo lo que se necesita en la pagina
                        var texto = ' calificaciones de este producto';
                        if(data.votes == 1){
                            var texto = ' calificación de este producto';
                        }
                        $('#total_calificaciones').html(data.votes + texto);
                        $('#calificacion_usuario').html('Tu calificación: ' + calificacion);

                        $('.glyphicon').removeClass('glyphicon-star-empty');
                        $('.glyphicon').removeClass('glyphicon-star');

                        if(data.average >= 0 && data.average < 1){
                            $('#calificacion_1').addClass('glyphicon-star-empty');
                            $('#calificacion_2').addClass('glyphicon-star-empty');
                            $('#calificacion_3').addClass('glyphicon-star-empty');
                            $('#calificacion_4').addClass('glyphicon-star-empty');
                            $('#calificacion_5').addClass('glyphicon-star-empty');
                        }

                        if(data.average >= 1 && data.average < 2){
                            $('#calificacion_1').addClass('glyphicon-star');
                            $('#calificacion_2').addClass('glyphicon-star-empty');
                            $('#calificacion_3').addClass('glyphicon-star-empty');
                            $('#calificacion_4').addClass('glyphicon-star-empty');
                            $('#calificacion_5').addClass('glyphicon-star-empty');
                        }

                        if(data.average >= 2 && data.average < 3){
                            $('#calificacion_1').addClass('glyphicon-star');
                            $('#calificacion_2').addClass('glyphicon-star');
                            $('#calificacion_3').addClass('glyphicon-star-empty');
                            $('#calificacion_4').addClass('glyphicon-star-empty');
                            $('#calificacion_5').addClass('glyphicon-star-empty');
                        }
                        
                        if(data.average >= 3 && data.average < 4){
                            $('#calificacion_1').addClass('glyphicon-star');
                            $('#calificacion_2').addClass('glyphicon-star');
                            $('#calificacion_3').addClass('glyphicon-star');
                            $('#calificacion_4').addClass('glyphicon-star-empty');
                            $('#calificacion_5').addClass('glyphicon-star-empty');
                        }

                        if(data.average >= 4 && data.average < 5){
                            $('#calificacion_1').addClass('glyphicon-star');
                            $('#calificacion_2').addClass('glyphicon-star');
                            $('#calificacion_3').addClass('glyphicon-star');
                            $('#calificacion_4').addClass('glyphicon-star');
                            $('#calificacion_5').addClass('glyphicon-star-empty');
                        }

                        if(data.average == 5){
                            $('#calificacion_1').addClass('glyphicon-star');
                            $('#calificacion_2').addClass('glyphicon-star');
                            $('#calificacion_3').addClass('glyphicon-star');
                            $('#calificacion_4').addClass('glyphicon-star');
                            $('#calificacion_5').addClass('glyphicon-star');
                        }
                    }
              },
        });
    }
</script>

<!-- CONTENIDO OFF -->