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
    echo CHtml::dropDownList('activo', '', array('0' => 'Inactivo',
                                                       '1' => 'Activo',
                                                       ),
                            array('class'=>'form-control','style' => 'display:none'));

    echo CHtml::dropDownList('destacado', '', array('0' => 'No destacado',
                                                       '1' => 'Destacado',
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
    
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filters.js");
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/filtersCategorias.js");
    
    
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
                                'nombre' => 'Nombre',
                                'url_amigable' => 'URL Amigable',
                                'activo' => 'Estatus',
                                'destacado' => 'Destacado',

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
        <!--<a href="#" id="filter-remove" class="btn btn-gray " title="Borrar Filtro">Borrar Filtro</a>-->
    </div>
    <div class="span2 pull-right">
       <!-- <a href="#" id="filter-save" class="btn btn-gray" title="Buscar con el filtro actual y guardarlo">Buscar y Guardar</a> -->
    </div>
    <div class="span2 pull-right" style="display: none">
       <!-- <a href="#" id="filter-save2" class="btn" title="Guardar filtro actual">Guardar Filtro</a> -->
    </div>
    <div class="span1 pull-right"> <!-- Quitar la clase mientras cuando se descomente los filtros de arriba-->
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