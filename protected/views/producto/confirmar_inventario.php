<?php
$empresas_all = Empresas::model()->findAllByAttributes(array('tipo'=>2, 'estado'=>2));
?>
<div class="container">
    <div class="row-fluid">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
        <div>
            <div>
                <h1>Vender Producto <small> - Agregar al inventario </small></h1>
            </div>
            <div class="well margin_top_small">
                <p>Verifique los datos, complete la información y presione Aceptar para proceder</p>
                <?php 
                $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'id'=>'inventario-form',
                    'enableAjaxValidation'=>false,
                    'htmlOptions'=>array('class'=>'form-horizontal'),
                ));
                ?>
                    <?php /*
                    if(Yii::app()->user->isAdmin()){
                        ?>
                        <div class="form-group ">
                            <label for="" class="col-sm-2 control-label">Empresa</label>
                            <div class="col-sm-3">
                                <?php
                                echo CHtml::dropDownList('empresas_all', '', CHtml::listData($empresas_all, 'id', 'razon_social'), array('class'=>'form-control', 'empty'=>'Seleccione una empresa...', 'id'=>'empresas_all'));
                                ?>
                            </div>
                        </div>
                        <?php
                    } */ // name="Inventario[almacen_id]" id="Inventario_almacen_id"
                    ?>
                    <!-- <div class="form-group ">
                        <label for="" class="col-sm-2 control-label">Almacén</label>
                        <div class="col-sm-3">
                            <?php
                            echo $form->dropDownList($model, 'almacen_id', CHtml::listData($almacenes, 'id', 'alias'), array('class'=>'form-control', 'empty'=>'Seleccione una sucursal...'));
                            ?>
                        </div>
                    </div> -->

                    <?php  echo $form->hiddenField($model,'almacen_id',array('value'=>14)); ?>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label" for="nombre">Nombre del producto</label>
                        <div class="col-md-6">
                            <input id="nombre" type="text" class="form-control" disabled value="<?php echo $producto->nombre; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label" for="descipcion">Descripción</label>
                        <div class="col-md-6">
                            <div id="descripcion" class="form-control-static"><?php echo $producto->descripcion; ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label" for="marca">Marca</label>
                        <div class="col-md-4" >
                            <input id="marca" type="text" class="form-control" disabled value="<?php echo $producto->marca->nombre; ?>">
                        </div>
                    </div>

                    <?php
                    $cont = 0;
                    foreach ($producto->caracteristicasProducto as $cp) {
                        $cont++;
                        ?>
                        <div class="form-group has-success">
                            <label for=""  class="col-sm-2 control-label" for="marca"><?php echo $cp->caracteristica->nombre; ?></label>
                            <div class="col-md-4" >
                                <input id="<?php echo $cp->caracteristica->id; ?>" name="<?php echo $cp->caracteristica->id; ?>" type="text" class="form-control caracteristica_text_field" placeholder="<?php echo $cp->caracteristica->nombre; ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group has-success">
                        <label for=""  class="col-sm-2 control-label" for="sku"> Código SKU </label>
						<div class="col-md-4" >
                        	<?php
                         		echo $form->textField($model, 'sku', array('class'=>'form-control', 'placeholder'=>'Código SKU'));
                       		?>
                    	</div>
                   	</div>

                    <div class="col-sm-offset-2 form-inline">
                        <div class="row-fluid">
                            <div class="col-md-3">
                                <?php
                                echo $form->textField($model, 'cantidad', array('class'=>'form-control', 'placeholder'=>'Cantidad a vender'));
                                ?>
                            </div>
                            <!--<div class="col-sm-2">
                                <?php
                                echo $form->textField($model, 'precio_tienda', array('class'=>'form-control', 'placeholder'=>'Precio en tienda'));
                                ?>
                            </div>-->
                            <div class="col-md-3">
                                <?php
                                echo $form->textField($model, 'precio', array('class'=>'form-control', 'placeholder'=>'Precio'));
                                ?>
                            </div>
                            <?php
                            if($inventario_menor_precio){
                                ?>
                                <div class="col-md-3">
                                    <h4><span class="label label-success">Menor precio: <?php echo Yii::app()->numberFormatter->formatCurrency($inventario_menor_precio->precio, ''); ?> Bs.</span>
                                    </h4>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            echo $form->hiddenField($model, 'precio_tienda', array('value'=>0));
                            echo $form->hiddenField($model, 'producto_id', array('value'=>$producto->id));
                            ?>
                            <div class="col-md-3">
                                <?php
                                $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType'=>'ajaxSubmit',
                                    'url'=>$this->createUrl('agregarInventarioAjax'),
                                    'htmlOptions'=>array('class'=>'btn btn-danger'),
                                    'label'=>'Agregar',
                                    'ajaxOptions'=>array(
                                            'success'=>'js:function(data){
                                                //console.log(data);
                                                $.fn.yiiListView.update("list-inventarios",{});
                                                //$("#Inventario_almacen_id").val("");
                                                $(".caracteristica_text_field").val("");
                                                $("#Inventario_cantidad").val("");
                                                $("#Inventario_precio").val("");
                                                $("#Inventario_precio_tienda").val("");
												$("#Inventario_sku").val("");
                                            }',
                                        ),
                                )); 
                                ?>
                            </div>
                        </div>
                    </div>
                <?php $this->endWidget(); ?>
                <div class="row-fluid margin_top_small">
                    <div class="col-md-8 col-md-offset-2 bg_white">
                        <?php
                        $template = '{summary}
                            <table class="table">
                            <tr >
                                <th colspan="'.$cont.'">Combinaciones a Vender</th>
                            </tr>
                            {items}
                            </table>
                            {pager} 
                        ';

                        $this->widget('zii.widgets.CListView', array(
                            'id'=>'list-inventarios',
                            'dataProvider'=>$dataProvider,
                            'itemView'=>'_combinaciones',
                            'template'=>$template,
                            'enableSorting'=>'true',
                            'afterAjaxUpdate'=>" function(id, data) {

                            } ",
                            'pager'=>array(
                                'header'=>'',
                                'htmlOptions'=>array(
                                    'class'=>'pagination pagination-right',
                                )
                            ),                  
                        ));

                        Yii::app()->clientScript->registerScript('inventario_update',
                            "$('#Inventario_almacen_id').change(function(){
                                  $.fn.yiiListView.update('list-inventarios', {
                                       data: $(this).serialize(),
                                  }
                              );
                             });
                             return false;",
                        CClientScript::POS_READY);
                        ?>
                    </div>  
                </div>
                <div class="row-fluid margin_top_small">
                    <a href="../producto/admin" class="col-md-4 col-sm-offset-2 btn btn-primary">Finalizar</a>
                </div>
            </div>
        </div>

        <!-- COLUMNA PRINCIPAL DERECHA OFF // -->

    </div>
</div>

<script>
    $('#empresas_all').on('change', function(){
        if($(this).val() != ''){
            var path = location.pathname.split('/');
            $.ajax({
                  url: "<?php echo Yii::app()->createUrl('empresas/getAlmacenes'); ?>",
                  type: "post",
                  data: { empresa_id : $(this).val() },
                  success: function(data){
                       $('#Inventario_almacen_id').html(data);
                  },
            });
        }
    });

    function eliminar_inventario(id){
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('producto/eliminarInventario'); ?>",
            type: "post",
            data: { id : id },
            success: function(html){
                $.fn.yiiListView.update("list-inventarios",{});
            },
        });
    }
</script>