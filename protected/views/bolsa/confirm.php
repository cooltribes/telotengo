<?php include("zoom.php"); ?>
<div class="container" style="padding: 0 15px;">

    <div class="page-header">
        <h1>Completar Compra</h1>
    </div>
    <section class="row">

        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
    

        <h3>Dirección</h3>
        <div class="col-sm-3" id="addresses">
        	<?php
        	foreach ($addresses as $address) {
        		?>
        		<div class="radio">
	                <label>
	                    <input type="radio" name="optionsRadios" class="address_radio" id="address_<?php echo $address->id; ?>" value="<?php echo $address->id; ?>">
	                    <strong><?php echo $address->nombre; ?>: </strong><?php echo $address->direccion_1.' '.$address->direccion_2; ?>. <?php echo $address->ciudad->nombre; ?>, <?php echo $address->provincia->nombre; ?>.
	                </label>
	            </div>
        		<?php
        	}
        	?>
        </div>

        <div class="col-sm-8 col-sm-offset-1" id="direccion">
            <p>O ingresa una nueva dirección:</p>
            <?php
            $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'address-form',
				'enableAjaxValidation'=>true,
				'clientOptions'=>array(
			        'validateOnSubmit'=>true,
			    ),
				'htmlOptions'=>array('onsubmit'=>"return false;",),
			));
            ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="nombre" class="sr-only">Nombre</label>
                        <?php echo $form->textField($newAddress,'nombre',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Nombre')); ?>
                        <?php echo $form->error($newAddress, 'nombre'); ?>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="direccion2" class="sr-only">Dirección 1</label>
                        <?php echo $form->textField($newAddress,'direccion_1',array('class'=>'form-control','maxlength'=>255, 'placeholder'=>'Dirección 1')); ?>
                        <?php echo $form->error($newAddress, 'direccion_1'); ?>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="direccion2" class="sr-only">Dirección 2</label>
                        <?php echo $form->textField($newAddress,'direccion_2',array('class'=>'form-control','maxlength'=>255, 'placeholder'=>'Dirección 2')); ?>
                        <?php echo $form->error($newAddress, 'direccion_2'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="provincia" class="sr-only">
                            Provincia
                        </label>
                        <?php              
		                $provinces = Provincia::model()->findAll(array('order' => 'nombre'));
						$list = CHtml::listData($provinces,'id', 'nombre'); 
						echo $form->dropDownList($newAddress, 'provincia_id', $list, array('empty' => 'Seleccione Estado...', 'class' => 'form-control')); 
		                ?>
		                
		                <?php echo $form->error($newAddress, 'provincia_id'); ?>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="cuidad" class="sr-only">
                            Ciudad
                        </label>
                        <?php
                        echo $form->dropDownList($newAddress, 'ciudad_id', array(), array('empty' => 'Seleccione Ciudad...', 'class' => 'form-control')); 
                        ?>
                        <?php echo $form->error($newAddress, 'ciudad_id'); ?>
                        
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="telefono" class="sr-only">Teléfono</label>
                         <?php echo $form->textField($newAddress,'telefono',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Teléfono')); ?>
                    	<?php echo $form->error($newAddress, 'telefono'); ?>
                    </div>
                </div>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'ajaxSubmit',
					'url'=>$this->createUrl('addAddress'),
					'htmlOptions'=>array('class'=>'btn btn-info'),
					'label'=>'Agregar',
					'ajaxOptions'=>array(
							'success'=>'js:function(data){
								
								if(data.indexOf("div") != -1){ // Si encuentra "div" se guardó la dirección
									$("#addresses").append(data);
									$("#address-form").find("input[type=text], select").val("");
								}
								else{									
									var valor = JSON.parse(data); // transformando a Json para leer
									
									// alert(data);
									// alert(valor.DireccionEnvio_telefono); 
									
									if(valor.DireccionEnvio_nombre) // falta
									{
										$("#DireccionEnvio_nombre").addClass("help-inline error");
										$("#DireccionEnvio_nombre_em_").attr("class","help-inline error");
										$("#DireccionEnvio_nombre_em_").attr("style","");
										$("#DireccionEnvio_nombre_em_").html(valor.DireccionEnvio_nombre);
									}
									
									if(valor.DireccionEnvio_direccion_1) // falta
									{
										$("#DireccionEnvio_direccion_1").addClass("help-inline error");
										$("#DireccionEnvio_direccion_1_em_").attr("class","help-inline error");
										$("#DireccionEnvio_direccion_1_em_").attr("style","");
										$("#DireccionEnvio_direccion_1_em_").html(valor.DireccionEnvio_direccion_1);
									}
									
									if(valor.DireccionEnvio_provincia_id) // falta
									{
										$("#DireccionEnvio_provincia_id").addClass("help-inline error");
										$("#DireccionEnvio_provincia_id_em_").attr("class","help-inline error");
										$("#DireccionEnvio_provincia_id_em_").attr("style","");
										$("#DireccionEnvio_provincia_id_em_").html(valor.DireccionEnvio_provincia_id);
									}
									
									if(valor.DireccionEnvio_ciudad_id) // falta
									{
										$("#DireccionEnvio_ciudad_id").addClass("help-inline error");
										$("#DireccionEnvio_ciudad_id_em_").attr("class","help-inline error");
										$("#DireccionEnvio_ciudad_id_em_").attr("style","");
										$("#DireccionEnvio_ciudad_id_em_").html(valor.DireccionEnvio_ciudad_id);
									}
									
									if(valor.DireccionEnvio_telefono) // falta
									{
										$("#DireccionEnvio_telefono").addClass("help-inline error");
										$("#DireccionEnvio_telefono_em_").attr("class","help-inline error");
										$("#DireccionEnvio_telefono_em_").attr("style","");
										$("#DireccionEnvio_telefono_em_").html(valor.DireccionEnvio_telefono);
									}
								}
							}',
						),
				)); 
				?>
            <?php $this->endWidget(); ?>

        </div>

    </section>
    

    <!-- METODO DE PAGO ON -->
    <section class="row">
    	<?php
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'payment-metods-form',
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('onsubmit'=>"return false;",),
		));
		?>
            <div class="page-header"><h3>Método de Pago</h3></div>    
                
                <div class="btn-group" data-toggle="buttons">
                    <ul class="nav nav-tabs">
                        <!-- <li>
                            <a href="#tarjetaCredito" data-toggle="tab">
                                <label for="ratiotarjetaCredito" class="btn btn-default padding_small">
                                    <input type="radio" class="metodo_pago" name="metodoPago" id="ratiotarjetaCredito" value="1">
                                    Tarjeta de Crédito 
                                </label>
                            </a>
                        </li> -->
                    
                        <li>
                            <a href="#depositoTransferencia" data-toggle="tab">
                                <label for="ratiodepositoTransferencia" class="btn btn-default padding_small">
                                    <input type="radio" class="metodo_pago" name="metodoPago" id="ratiodepositoTransferencia" value="2" checked>
                                    Depósito/Transferencia
                                </label>
                            </a>
                        </li>
                        
						<!--
                        <li>
                            <a href="#tarjetadeRegalo" data-toggle="tab">
                            <label for="ratiotarjetaRegalo" class="btn btn-default padding_small">
                                <input type="radio" class="metodo_pago" name="metodoPago" id="ratiotarjetaRegalo" value="3">
                                Tarjeta de Regalo
                            </label>
                            </a>
                        </li>
						
						
                        <li>
                            <a href="#mercadoPago" data-toggle="tab">
                                <label for="ratioMercadoPago" class="btn btn-default padding_small">
                                    <input type="radio" class="metodo_pago" name="metodoPago" id="ratioMercadoPago" value="4">
                                    MercadoPago
                                </label> 
                            </a>
                        </li>
                       -->
                    </ul>  
                </div>  
                <div class="tab-content well">
                  <div class="tab-pane" id="tarjetaCredito">
                    <h4>Tarjeta de Crédito</h4>
                    <div class="form-horizontal">
                            <div class="form-group">
                            <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-4">
                              <input type="email" class="form-control" id="nombre" placeholder="Nombre">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tarjetaCredito" class="col-sm-2 control-label">Número de Tarjeta de Crédito</label>
                            <div class="col-sm-4">
                              <input type="email" class="form-control" id="tarjetaCredito" placeholder="Número de Tarjeta de Crédito">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="codigoSeguridad" class="col-sm-2 control-label">Código de Seguridad</label>
                            <div class="col-sm-3">
                              <input type="email" class="form-control" id="codigoSeguridad" placeholder="Código de Seguridad">
                            </div>
                        </div>     
                        <div class="col-sm-offset-2">
                            <button class="btn btn-success">Comprar</button>                                           
                        </div>
                    </div>

                </div>
                  <div class="tab-pane" id="depositoTransferencia">  <p>Siga las instrucciones que se enviaran a su cuenta de correo</p></div>
                  <div class="tab-pane" id="tarjetadeRegalo">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-2 control-label">Codigo</label>
                            <div class="col-sm-4">
                              <input type="email" class="form-control" id="nombre" placeholder="Codigo">
                            </div>
                        </div>
   
                        <div class="col-sm-offset-2">
                            <button class="btn btn-success">Canjear</button>                                           
                        </div>
                    </div>                      

                  </div>
                  <div class="tab-pane" id="mercadoPago"> Haga click en en el botón <strong>Comprar</strong> para continuar</div>
                </div>                
        <?php $this->endWidget(); ?>          
    </section>

    <!-- METODO DE PAGO OF -->

    <section class="row">
    	
    	<?php if(Yii::app()->user->hasFlash('success')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
		    <div class="alert in alert-block fade alert-error text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } ?>
    	
        <div class="page-header">
            <h3>Productos</h3>
        </div>
        <div class="col-sm-7">

			<?php
			if(isset($model))
			{

			$bolsa_has = BolsaHasInventario::model()->findAllByAttributes(array('bolsa_id'=>$model->id));
			$subtotal = 0;
            $numero_productos = 0;
            $peso = 0;
            $envio = 0;

			if(isset($bolsa_has) && count($bolsa_has)>0 ){	
				?>
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>Nombre del producto</th>
							<th>Precio</th>
							<th>Cantidad</th>
						</tr>
					</thead>
					<tbody>
						<?php

						foreach($bolsa_has as $uno)
						{
							$inventario = Inventario::model()->findByPk($uno->inventario_id);	

							if($inventario->estado ==1){

								$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$inventario->producto_id));

								$producto = Producto::model()->findByPk($inventario->producto_id);
								$subtotal += $inventario->precio * $uno->cantidad;
                                $numero_productos += $uno->cantidad;
                                $peso += $producto->peso * $uno->cantidad;

								if($principal->getUrl())
									$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Preview", array("height"=>"100px", "width" => "100px",'class'=>'img-responsive'));
								else 
									$im = '<img src="http://placehold.it/100x100" width="100%">';  	

								$marca = Marca::model()->findByPk($producto->marca_id);
								//echo $marca->nombre;						    								

								echo ' <tr id="'.$inventario->id.'">
											<td>'.$im.'</td>
											<td>
												<div>'.$producto->nombre.' '.$marca->nombre.'</div>
												<div>Caracteristicas</div>
											</td>
											<td>'.$inventario->precio.' Bs.</td>
											<td><span id="menos-'.$inventario->id.'" class="glyphicon glyphicon-minus-sign" style="cursor:pointer;" onclick="actualizar(this,'.$inventario->id.');"></span>
												<span id="cantidad-'.$inventario->id.'">'.$uno->cantidad.'</span>
												<span id="mas-'.$inventario->id.'" class="glyphicon glyphicon-plus-sign" style="cursor:pointer;" onclick="actualizar(this,'.$inventario->id.');"></span>
											</td>
										</tr>';
							} // estado del inventario
						}
						?>
					</tbody> 
				</table>
				<?php
			}
            echo CHtml::hiddenField('numero_productos', $numero_productos, array('id'=>'numero_productos'));
            echo CHtml::hiddenField('subtotal', $subtotal, array('id'=>'subtotal'));
            echo CHtml::hiddenField('peso', $peso, array('id'=>'peso'));
            echo CHtml::hiddenField('envio', $envio, array('id'=>'envio'));
            echo CHtml::hiddenField('balance', 0, array('id'=>'balance'));
            echo CHtml::hiddenField('balanceUsado', 0, array('id'=>'balanceUsado'));
		}
			?>                       	          
			
			
            
        </div>
        <div class="col-sm-4 col-sm-offset-1 caja">
            <h3> Resumen</h3>
            
                <?php
                $balance = Balance::model()->getTotal();

                if($balance > 0){ ?>  
                <label class="radio" id="BalanceDisponible">
                    <!-- <input type="radio" name="opcionBalance" id="radio-balance" value="1" onclick="usarBalance(<?php echo $balance; ?>)"> -->
                    <input type="checkbox" name="opcionBalance" id="check-balance" value="Balance" onclick="usarBalance(<?php echo $balance; ?>)">
                    Usar Balance Disponible
                    <strong>
                        <?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($balance, ''); ?>
                    </strong>      
                </label>
                <?php } ?>
            <hr>
            
            <div class="padding_xsmall">
                <span>Subtotal: <strong><?php echo $subtotal; ?> Bs.</strong></span>
            </div>
            <div class="padding_xsmall">
                <span>Envio: <strong><span class="envio">0,00</span> Bs.</strong></span>
            </div>
            <div class="padding_xsmall">
                <span>IVA: <strong>0,00 Bs.</strong></span>
            </div>
            <div id="total_balance" style="display: none;">
            </div>
            <div id="total_compra">
                <h4>Total: <strong><span class="total"><?php echo $subtotal; ?></span> Bs.</strong> </h4>
            </div>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'link',
				'url'=>'#',
				'htmlOptions'=>array('class'=>'btn btn-success btn-lg margin_top', 'id'=>'place_order'),
				'label'=>'<span class="glyphicon glyphicon-shopping-cart"></span> Comprar',
				'encodeLabel' => false,
				/*'ajaxOptions'=>array(
					'beforeSend'=>'js:function(){
						
					}',
					//'data'=>array('address_id'=>),
					'success'=>'js:function(data){
						console.log(data);
						//$("#addresses").append(data);
						//$("#address-form").find("input[type=text], select").val("");
					}',
				),*/
			)); 
			?>
			<div id="place_order_error" style="display:none;"></div>
        </div>

    </section>
</div>

<script>

	  	
	  	$("#DireccionEnvio_nombre").focus(function() {
	  		
			if( $("#DireccionEnvio_nombre").hasClass("help-inline error") )
		  	{
		  		$("#DireccionEnvio_nombre").removeClass("help-inline error");
				$("#DireccionEnvio_nombre_em_").removeClass("help-inline error");
				$("#DireccionEnvio_nombre_em_").attr("style","display:none;");
				$("#DireccionEnvio_nombre_em_").html(""); 		
		  	}		 
		  		
		}); 
		
		$("#DireccionEnvio_direccion_1").focus(function() {
			if( $("#DireccionEnvio_direccion_1").hasClass("help-inline error") )
		  	{
		  		$("#DireccionEnvio_direccion_1").removeClass("help-inline error");
				$("#DireccionEnvio_direccion_1_em_").removeClass("help-inline error");
				$("#DireccionEnvio_direccion_1_em_").attr("style","display:none;");
				$("#DireccionEnvio_direccion_1_em_").html(""); 		
		  	}				
		});
		
		$("#DireccionEnvio_provincia_id").focus(function() {
			if( $("#DireccionEnvio_provincia_id").hasClass("help-inline error") )
		  	{
		  		$("#DireccionEnvio_provincia_id").removeClass("help-inline error");
				$("#DireccionEnvio_provincia_id_em_").removeClass("help-inline error");
				$("#DireccionEnvio_provincia_id_em_").attr("style","display:none;");
				$("#DireccionEnvio_provincia_id_em_").html(""); 		
		  	}				
		});
	  	
		$("#DireccionEnvio_ciudad_id").focus(function() {
			if( $("#DireccionEnvio_ciudad_id").hasClass("help-inline error") )
		  	{
		  		$("#DireccionEnvio_ciudad_id").removeClass("help-inline error");
				$("#DireccionEnvio_ciudad_id_em_").removeClass("help-inline error");
				$("#DireccionEnvio_ciudad_id_em_").attr("style","display:none;");
				$("#DireccionEnvio_ciudad_id_em_").html(""); 		
		  	}				
		});
	  
		$("#DireccionEnvio_telefono").focus(function() {
			if( $("#DireccionEnvio_telefono").hasClass("help-inline error") )
		  	{
		  		$("#DireccionEnvio_telefono").removeClass("help-inline error");
				$("#DireccionEnvio_telefono_em_").removeClass("help-inline error");
				$("#DireccionEnvio_telefono_em_").attr("style","display:none;");
				$("#DireccionEnvio_telefono_em_").html(""); 		
		  	}				
		});


	$('#DireccionEnvio_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('bolsa/cities'); ?>",
			      type: "post",
			      data: { stateId : $(this).val() },
			      success: function(data){
			           $('#DireccionEnvio_ciudad_id').html(data);
			      },
			});
		}
	});

    $('.address_radio').change(function(){
        if($(this).val() != ''){
            var path = location.pathname.split('/');
            $.ajax({
                    url: "<?php echo Yii::app()->createUrl('bolsa/calcularEnvio'); ?>",
                    type: "post",
                    data: { direccion_id : $(this).val(), numero_productos : $('#numero_productos').val(), subtotal : $('#subtotal').val(), peso : $('#peso').val() },
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        var envio = parseFloat(data.subtotal.replace(",", "."));
                        $('.envio').html(envio);
                        $('#envio').val(envio);
                        var total = parseFloat(data.subtotal.replace(",", ".")) + parseFloat($('#subtotal').val().replace(",", "."));
                        $('#subtotal').val( parseFloat($('#subtotal').val()) + parseFloat(envio) );
                        $('.total').html(total);
                    },
            });
        }
    });

	$("#place_order").click(function(event){
	  	var pass_address = false;
		var pass_payment_method = false;
		var address_id, payment_method_id;
		$(".address_radio").each(function( index ) {
			if($(".address_radio").prop("checked", true)){
				pass_address = true;
				address_id = $(this).val();
			}
		});
		$(".metodo_pago").each(function( index ) {
			if($(".metodo_pago").prop("checked")){
				pass_payment_method = true;
				payment_method_id = $(this).val();
			}
		});

		if(!pass_address || !pass_payment_method){
			if(!pass_address){
				$("#place_order_error").html("Debe seleccionar una dirección válida para continuar");
			}
			if(!pass_payment_method){
				$("#place_order_error").html("Debe seleccionar un método de pago para continuar");
			}
			$("#place_order_error").show();
			event.preventDefault();
		}else{
			$("#place_order_error").hide();
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('bolsa/placeOrder'); ?>",
			      type: "post",
			      data: { address_id : address_id, payment_method_id : payment_method_id, envio: $('#envio').val(), balance: $('#balance').val(), subtotal: $('#subtotal').val()},
                  dataType : 'json',
			      success: function(data){
                        if(data.status == 'ok'){
                            window.location = "<?php echo Yii::app()->createUrl('orden/view/"+data.order+"'); ?>";
                        }else{
                            alert('Error');
                        }
			      },
			});
		}
	});
	
	function actualizar(boton,inventario)
	{
	
		var cantidad = $("#cantidad-"+inventario).text(); // cantidad actual
		var opcion = boton.id; // opcion: mas o menos
		
		if(cantidad==0 && opcion=="menos"){
			alert("Ingrese una cantidad valida.");
		}
		else{
			$.ajax({
	        type: "post",
	        url: "actualizar", // action de actualizar
	        data: {'accion':opcion, 'cantidad':cantidad, 'bolsa':<?php echo $model->id; ?> },
	       
	       
	        success: function (data) {
				if(data=="ok"){
					alert("cantidad actualizada"); 
				}
				
				if(data=="borrado"){
					alert("El producto ha sido eliminado."); 
				}
				
				if(data=="NO"){
					alert("Lo sentimos, no es posible actualizar la cantidad. La Cantidad es mayor a la existencia en inventario."); 
				}
				
				window.location.reload()
					
	       	} //success
	       }) // ajax
			
		}
	
	}

    function usarBalance(total){
        if($('#check-balance').is(':checked')){ // si se seleccióno
            var subtotal = $('#subtotal').val();
            var balanceRestante = 0;
            var balanceUsado = 0;

            if(parseFloat(total) > parseFloat(subtotal)){ // Balance es mayor a la orden
                balanceRestante = parseFloat(total) - parseFloat(subtotal);

                balanceUsado = parseFloat(subtotal);
                $('#balanceUsado').val(balanceUsado);

                $('#total_balance').html('<span>Balance: <strong>'+balanceUsado+' Bs.</strong></span>');                        
                $('#total_balance').show();
        
                $('#total_compra').html('<h4>Total: <strong><span class="total">0</span> Bs.</strong></h4>');
        
                $('#balance').val(balanceUsado);
                $('#subtotal').val(0);

            }else{ // orden normal, el balance pasa a ser un descuento
                $('#total_balance').html('<span>Balance: <strong>'+total+' Bs.</strong></span>');                        
                $('#total_balance').show();
        
                $('#total_compra').html('<h4>Total: <strong><span class="total">'+(subtotal-total)+'</span> Bs.</strong></h4>');
        
                $('#balance').val(total);
                $('#subtotal').val(subtotal-total);
            }

        }
        else{
            var balanceUsado = $('#balanceUsado').val();
            var subtotal = $('#subtotal').val(); 

            if(subtotal > 0){ // no se uso todo el balance
                $('#total_balance').html('');                        
                $('#total_balance').hide();

                var nuevo = parseFloat(subtotal)+parseFloat(total); //+parseInt($('#envio').val());

                $('#total_compra').html('<h4>Total: <strong><span class="total">'+nuevo+'</span> Bs.</strong></h4>');
                
                $('#balance').val(0);
                $('#subtotal').val(nuevo);
            }
            else{
                $('#total_balance').html('');                        
                $('#total_balance').hide();

                $('#total_compra').html('<h4>Total: <strong><span class="total">'+balanceUsado+'</span> Bs.</strong></h4>');
                
                $('#balanceUsado').val(0);
                $('#balance').val(0);
                $('#subtotal').val(balanceUsado); 
            }
        }
    }
</script>