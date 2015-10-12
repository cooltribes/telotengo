           
            <div class="col-md-12 no_horizontal_padding margin_top">
                <h2>PREGUNTAS Y RESPUESTAS</h2>
                <div class="moreDetails">
                    <div class="row-fluid clearfix questions">
                        <div class="col-md-9">
                        	
                            <b>HAZ UNA PREGUNTA</b>
                            <textarea id='textArea'rows="2" maxlength="500" placeholder="Escribe tu pregunta (Max 500 caracteres)"></textarea>
                            <input class="btn-orange btn btn-danger btn-small  orange_border margin_right_small" id="publico" type="submit" name="yt1" value="Preguntar Publicamente">
                            <input class="btn-gray btn btn-danger btn-small" type="submit" name="yt1" id="privado" value="Preguntar en Privado">
                            
                           <input type="hidden" id="produco" value="<?php echo $model->id?>">
                           <input type="hidden" id="empresa_id" value="<?php echo $empresa_id?>">
                           

                            <?php 
                            $pregunta=Pregunta::model()->findAllByAttributes(array('producto_id'=>$model->id, 'publica'=>1, 'empresa_id'=>$empresa_id));
							if(isset($pregunta))
							{
								 foreach($pregunta as $preg)
								{?>
									<div class="row-fluid clearfix margin_top question">
		                                <div class="col-md-2 text-center userInfo">
		                                    <img src="http://placehold.it/50x50"/>
		                                  
		                                    <span class="userName ellipsis"><b><?php echo Empresas::model()->findByPk(EmpresasHasUsers::model()->findByAttributes(array('users_id'=>$preg->users_id))->id)->razon_social; ?></b></span>
		                                    <span class="date"><?php echo $preg->fecha;?></span>
		                               </div>
		                                <div class="col-md-10 content">
		                                    <span><b><?php echo $preg->pregunta;?></b></span>
		                                    <?php
		                                    $respuestas=Respuesta::model()->findAllByAttributes(array('pregunta_id'=>$preg->id));
											if(isset($respuestas))
											{
												foreach($respuestas as $respuesta)
												{?>
													<span><?php echo $respuesta->comentario;?></span>
												<?php	
												}
											}
		                                    ?>           
		                                   <!--< <div class="links"><!--<a href="#">Responder</a>| <a href="#">Reportar</a></div> -->                                  
		                                </div>
		                                
		                            </div>
								<?php
								}
							}

                            ?>
                            
                           
                                                        
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
            

<script>
$(document).ready(function() {
	$('#publico').click(function() {
		if(($('#textArea').val()=="")
			return false;
			formulario($('#textArea').val(), 1, $('#produco').val(), $('#empresa_id').val());
	  });
	  	$('#privado').click(function() {
			if(($('#textArea').val()=="")
				return false;
			//formulario($('#textArea').val(), 0, $('#produco').val(), $('#empresa_id').val());
	  });
	  
	  
	  
	  
	  function formulario(texto, tipo, producto_id, empresa_id){
	  		
	  		
	  		//alert(texto); alert(tipo);
	  		$.ajax({
	         url: "<?php echo Yii::app()->createUrl('Site/formuPregunta') ?>",
             type: 'POST',
	         data:{
                    texto:texto, tipo:tipo, producto_id:producto_id, empresa_id:empresa_id
                   },
	        success: function (data) {
	        	
				location.reload();
	       	}
	       })
	  }
	});	


</script>