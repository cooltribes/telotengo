<div class="row" id="filters-view">
<!--<div class="row" id="filters-view" style="display: none">-->

<div class="span12">
  <div class="alert in" id="alert-msg" style="display: none">
    <button type="button" class="close" >&times;</button> 
    <!--data-dismiss="alert"-->
    <div class="msg"></div>
  </div>
</div>          
    
<?php
    echo CHtml::dropDownList('status', '', User::getStatus(), array('style' => 'display:none'));
    
    echo Chtml::dropDownList('Operadores', '', array('>' => '>', '>=' => '>=',
                            '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), 
                                array('empty' => 'Operador',
                                    'style' => 'display:none'));
    echo CHtml::dropDownList('tipoUsuario', '', array('admin' => 'Administrador',
                                                       'comprador' => 'Comprador',
                                                       'vendedor' => 'Vendedor',
                                                       'compraVenta' => 'Comprador y vendedor',
                                                       ),
                            array('class'=>'form-control','style' => 'display:none'));    
    
    echo CHtml::dropDownList('fuenteR', '', array('face' => 'Facebook',                                                       
                                                  'user' => 'Registro Normal',
                                                   ),
                            array('style' => 'display:none'));    
    
    echo CHtml::dropDownList('prods_marca', '', CHtml::listData(Marca::model()->findAll(), 'id', 'nombre'),
                            array('style' => 'display:none'));
    
   /* echo CHtml::dropDownList('looks_ps', '', CHtml::listData(User::model()->with(array(
                               'profile'=>array(),
                            ))->findAll('personal_shopper = 1'), 'id', 'profile.first_name'),
                            array('style' => 'display:none'));*/

    echo CHtml::dropDownList('interno', '', array(0 => 'No',
                                                    1 => 'Si',),
                            array('style' => 'display:none'));
    
    /*************      TIPO DE CUERPO ON   ****************/
    //Para las alturas    
    /*$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('altura', '', $valores,
                            array('style' => 'display:none'));
    //Para la contextura
    $field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('contextura', '', $valores,
                            array('style' => 'display:none'));
    //Para cabello
    $field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('pelo', '', $valores,
                            array('style' => 'display:none'));
    //Para ojos
    $field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('ojos', '', $valores,
                            array('style' => 'display:none'));
    //Para piel
    $field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('piel', '', $valores,
                            array('style' => 'display:none'));
    
    //Para tipo_cuerpo
    $field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('tipo_cuerpo', '', $valores,
                            array('style' => 'display:none'));*/
    /*************      TIPO DE CUERPO OFF        ****************/
    
    
    /*************      ESTILO        ****************/
    
    //Para coctel
   /* $field = ProfileField::model()->findByAttributes(array('varname'=>'coctel'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('coctel', '', $valores,
                            array('style' => 'display:none'));
    
    //Para fiesta
    $field = ProfileField::model()->findByAttributes(array('varname'=>'fiesta'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('fiesta', '', $valores,
                            array('style' => 'display:none'));
    
    //Para playa
    $field = ProfileField::model()->findByAttributes(array('varname'=>'playa'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('playa', '', $valores,
                            array('style' => 'display:none'));
    
    //Para sport
    $field = ProfileField::model()->findByAttributes(array('varname'=>'sport'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('sport', '', $valores,
                            array('style' => 'display:none'));
    
    //Para trabajo
    $field = ProfileField::model()->findByAttributes(array('varname'=>'trabajo'));  
    $valores = Profile::range($field->range);    
    $valores[0] = "Ninguno";
    echo CHtml::dropDownList('trabajo', '', $valores,
                            array('style' => 'display:none'));*/
    
    /*Para el genero*/
   /* $field = ProfileField::model()->findByAttributes(array('varname'=>'sex'));  
    $valores = Profile::range($field->range);      
    echo CHtml::dropDownList('sex', '', $valores,
                            array('style' => 'display:none'));*/
    
    
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filters.js");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filtersUsuarios.js");
    
    
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
    'htmlOptions' => array('class' => 'form-stacked span12'),
    'id' => 'form_filtros'
    ));

		
?>
    
    <h4 class="pepe">Nueva búsqueda avanzada:</h4>
    <fieldset>
        <div id="filters-container" class="clearfix">
            <div id="filter">
                <div class="control-group">
                    <div class="controls" >
                    <div class="col-md-12">
                        <div class="span3" >
                            <?php 
                            $opcionesFiltros = array(
                                'tipoUsuario' => 'Tipo de usuario',
                                'id' => 'ID',
                                'first_name' => 'Nombre',
                                'last_name' => 'Apellido',
                                'telefono' => 'Teléfono',
                                'email' => 'Correo Electronico',
                                //'status' => 'Estado',
                               // 'balance' => 'Saldo Disponible',
                               // 'ciudad' => 'Ciudad',
                                //'fuenteR' => 'Fuente de registro',
                               // 'invitaciones' => 'Invitaciones enviadas',
                                'visit' => 'Número de ingresos al portal',
                                'lastvisit_at' => 'Fecha de última visita',
                                'create_at' => 'Fecha de registro',
                                'monto' => 'Monto comprado',
                                'lastorder_at' => 'Fecha de última compra',                                
                                /*'looks' => 'Cantidad de looks comprados',                                
                                'looks_ps' => 'Looks comprados por Personal Shopper',
                                'prods_marca' => 'Looks comprados por Marca',                                
                                'altura' => 'Altura', 
                                'contextura' => 'Condición Física', 
                                'pelo' => 'Color de cabello', 
                                'ojos' => 'Color de ojos', 
                                'piel' => 'Color de piel', 
                                'tipo_cuerpo' => 'Forma de cuerpo', 
                                'coctel' => 'Estilo Diario', 
                                'fiesta' => 'Estilo Fiesta', 
                                'playa' => 'Estilo Vacaciones', 
                                'sport' => 'Estilo Deporte', 
                                'trabajo' => 'Estilo Oficina',                                 
                                'sex' => 'Género',                                 
                                'compras' => 'Compras hechas',                                 
                                'prendas' => 'Prendas compradas',  
                                'zoho_id' => 'Zoho ID',
                                'birthday' => 'Fecha de nacimiento',
                                'interno' => 'Interno',*/
                                'ordenAprobada'=>'Cantidad de ordenes aprobadas por usuario',
                                'ordenCancelada'=>'Cantidad de ordenes canceladas por usuario',
                                'ordenGeneradaPendiente'=>'Cantidad de ordenes generadas por usuario (pendientes)',
                                'ordenGeneradaAprobada'=>'Cantidad de ordenes generadas por usuario (Aprobadas)',
                                'ordenGeneradaCancelada'=>'Cantidad de ordenes generadas por usuario (Canceladas)',
                                'fechaOrdenAprobada'=>'Fecha de ordenes aprobadas por usuario',
                                'fechaOrdenCancelada'=>'Fecha de ordenes canceladas por usuario',
                                'fechaOrdenGeneradaPendiente'=>'Fecha de ordenes generadas por usuario (pendientes)',
                                'fechaOrdenGeneradaAprobada'=>'Fecha de ordenes generadas por usuario (aprobadas)',
                                'fechaOrdenGeneradaCancelada'=>'Fecha de ordenes generadas por usuario (canceladas)',
                                'ordenMontoAprobada'=>'Monto de ordenes aprobadas por usuario',
                                'ordenMontoCancelada'=>'Monto de ordenes canceladas por usuario',
                                'ordenMontoGeneradaPendiente'=>'Monto de ordenes generadas por usuario (pendientes)',
                                'ordenMontoGeneradaAprobada'=>'Monto de ordenes generadas por usuario (aprobadas)',
                                'ordenMontoGeneradaCancelada'=>'Monto de ordenes generadas por usuario (canceladas)',
                                'Ingresos'=>'ingresos',
                                'cantItemComprado'=>'Cantidad de Items comprados',
                                 );
                                 asort($opcionesFiltros);
                                 
                            echo Chtml::dropDownList('dropdown_filter[]', '', $opcionesFiltros,
                            array('empty' => '-- Seleccione --', 'class' => 'dropdown_filter form-control')); ?> 
                        </div>
                        <div class="span2" >
                            <?php echo Chtml::dropDownList('dropdown_operator[]', '', array('>' => '>', '>=' => '>=',
                            '=' => '=', '<' => '<', '<=' => '<=', '<>' => '<>'), 
                                array('empty' => 'Operador', 'class' => 'dropdown_operator form-control')); ?>
                        </div>
                        <div class="span2" >
                            <?php echo Chtml::textField('textfield_value[]', '', array('class' => 'textfield_value form-control no_radius')); ?>  
                        </div>
                        <div class="span2" >
                           <?php
                        echo Chtml::dropDownList('dropdown_relation[]', '', array('AND' => 'Y', 'OR' => 'O'),
                                array('class' => 'dropdown_relation form-control', 'style' => 'display:none'));
                        ?> 
                        </div>
                       
                            <a href="#" class="btn span_add span1 btn btn-gray" style="float: right" title="Agregar nuevo campo"> + </a>
                            <a href="#" class="btn btn-danger span_delete span1 negro" style="display:none; float: right" title="Eliminar campo"> - </a> 
                       </div>     
                        
                        
                       
                        
                        

                    </div>
                </div>    
            </div>    
        </div>  
    </fieldset>
    
   <?php $this->endWidget(); ?>

    <div class="span2 pull-right">
        <a href="#" id="filter-remove" class="btn btn-gray " title="Borrar Filtro">Borrar Filtro</a>
    </div>
    <div class="span2 pull-right">
        <a href="#" id="filter-save" class="btn btn-gray" title="Buscar con el filtro actual y guardarlo">Buscar y Guardar</a> 
    </div>
    <div class="span2 pull-right" style="display: none">
        <a href="#" id="filter-save2" class="btn" title="Guardar filtro actual">Guardar Filtro</a> 
    </div>
    <div class="span1 pull-right">
        <a href="#" id="filter-search" class="btn negro" title="Buscar con el filtro actual">Buscar</a>  
    </div>
    
    
    
    

</div>
<script type="text/javascript">
/*<![CDATA[*/
   
   //Buscar      
    $('#filter-search').click(function(e) {
        
        e.preventDefault(); 
        
        search('<?php echo CController::createUrl('') ?>');
        
    });
    
    //Buscar y guardar nuevo
    $('#filter-save').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('') ?>', true);
            
    });
    
    //Buscar y guardar filtro actual
    $('#filter-save2').click(function(e) {
        
        e.preventDefault(); 
        
        searchAndSave('<?php echo CController::createUrl('') ?>', false);
            
    });
    
    //Seleccionar un filtro preestablecido
    $("#all_filters").change(function(){
	
        getFilter('<?php echo $this->createUrl('/orden/getFilter');//CController::createUrl('/orden/getFilter') ?>', $(this).val(), '<?php echo CController::createUrl('') ?>');        	
	
    });
    
    $("#filter-remove").click(function(e){

             e.preventDefault();
             removeFilter('<?php echo $this->createUrl('/orden/removeFilter');//CController::createUrl('orden/removeFilter') ?>',$("#all_filters").val());        	

    });    
    
    
/*]]>*/
</script>