<div class="row-fluid">
    <h5 class="col-md-8 col-md-offset-2 text-center">
            No hemos encontrado ningún registro de invitación a este correo electrónico, por lo que iniciaremos un proceso de validación que nos permitirá generar una para hacertela llegar a
   </h5>
    <div class="col-md-6 col-md-offset-3 margin_top orangepanel">
        <h4 class="text-center">
            Por favor completa los siguientes datos personales:
        </h4>
                <?php $form=$this->beginWidget('UActiveForm', array(
                            'id'=>'registration-form',
                            'enableAjaxValidation'=>true,
                            'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                            'clientOptions'=>array(
                                'validateOnSubmit'=>true,
                                'validateOnChange'=>false,
                                'validateOnType'=>false,
                            ),
                            'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal margin_top','role'=>"form"),
                        )); ?>

                            <?php
                                echo CHtml::hiddenField('facebook_id','');
                            ?>
                            <div class="control-group">
                            <?php 
                            $profileFields=$profile->getFields();
                            if ($profileFields) {
                                foreach($profileFields as $field) {
                                    ?>
                                  
                                                      <?php 
                                            if ($widgetEdit = $field->widgetEdit($profile)) {
                                                echo $widgetEdit;
                                            } elseif ($field->range) { ?>
                                           
                                         <?php  echo $form->labelEx($profile,$field->varname, array('class'=>'col-sm-3 control-label text-left','style'=>'margin-top:-6px'));
                                                echo $form->radioButtonList($profile,$field->varname,Profile::range($field->range),array('separator'=>'  ', 'labelOptions'=>array('style'=>'display:inline'))); ?>
                                               
                                         <?php       //echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
                                            } elseif ($field->field_type=="TEXT") {
                                                echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50,));
                                            } elseif ($field->field_type=="DATE") {
                                                if($field->varname == 'fecha_nacimiento'){ ?>
                                                   <div class="row-fluid pickDate margin_bottom_small clearfix">
                                                       <div class="col-md-4 text-left margin_top_small" style="padding-left: 0px;"><?php echo CHtml::label($field->title,'',array('class'=>'control-label')); ?></div>
                                                       <div class="col-md-2"><?php echo '<select id="birth_day" class="form-control margin_top_small" ><option value="-1">Día</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>';
                                                     ?></div>
                                                       <div class="col-md-4"><?php  echo '<select id="birth_day" class="form-control margin_top_small" ><option value="-1">Día</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>';
                                                     ?></div>
                                                       <div class="col-md-2"><?php echo '<select id="birth_year" class="form-control margin_top_small" ><option value="-1">Año</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option></select>';
                                                   ?></div>
                                                       
                                                   </div> 
                                                    
                                            <?php                                                  
                                                    echo CHtml::activeHiddenField($profile,$field->varname,array('value'=>""));
                                                    echo '<span class="help-inline"></span>';
                                                    echo $form->error($profile,$field->varname,array('style'=>'margin-top: 8px;'));
                                                }else{
                                                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                        'name'=>$field->varname,
                                                        'language'=>'es',
                                                        'model'=>$profile,
                                                        'attribute'=>$field->varname,
                                                        // additional javascript options for the date picker plugin
                                                        'options'=>array(
                                                            'showAnim'=>'fadeIn',
                                                            'dateFormat'=>'yy-mm-dd',
                                                            'changeYear'=>true,
                                                            'yearRange'=>'1900:2015',
                                                        ),
                                                        'htmlOptions'=>array(
                                                            'class'=>'form-control',
                                                            'placeholder'=>'Fecha'
                                                        ),
                                                    ));
                                                }
                                            } else {
                                                if($field->varname == "telefono"){
                                                #    echo $form->textField($profile,$field->varname,array('class'=>'form-control', 'placeholder'=> $field->title." (opcional)", 'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                                                 #   echo $form->error($profile,$field->varname);
                                                }
                                                else{
                                                    echo $form->textField($profile,$field->varname,array('class'=>'form-control margin_top_small', 'placeholder'=> $field->title, 'size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                                                    echo $form->error($profile,$field->varname);
                                                }
                                            }
                                            ?>
                  
                                        <?php echo $form->error($profile,$field->varname); ?>
                                
                                    <?php
                                }
                            }
                            ?>
     </div>
                            <br/>
                            <div class="align_center margin_top_large margin_bottom_small">
                                <?php echo CHtml::submitButton('Siguiente', array('class'=>'btn-black btn btn-danger btn-large')); ?>
                                
                            </div> 
                                                         
    
                        <?php $this->endWidget(); ?>
                
                
   
            
  
        
    
    </div>
    
</div>
<script>

    $(document).ready(function(){

        $('#birth_day').change(function(){
            if($('#birth_day').val()!=-1 && $('#birth_month').val()!=-1 && $('#birth_year').val()!=-1){
                if(!validar_fecha()){
                    $('#birth_day').val('-1');
                    $('#birth_month').val('-1');
                    $('#birth_year').val('-1');
                }else{
                    $('#Profile_fecha_nacimiento').val($('#birth_year').val()+'-'+$('#birth_month').val()+'-'+$('#birth_day').val());
                }
            }
        });

        $('#birth_month').change(function(){
            if($('#birth_day').val()!=-1 && $('#birth_month').val()!=-1 && $('#birth_year').val()!=-1){
                if(!validar_fecha()){
                    $('#birth_day').val('-1');
                    $('#birth_month').val('-1');
                    $('#birth_year').val('-1');
                }else{
                    $('#Profile_fecha_nacimiento').val($('#birth_year').val()+'-'+$('#birth_month').val()+'-'+$('#birth_day').val());
                }
            }
        });

        $('#birth_year').change(function(){
            if($('#birth_day').val()!=-1 && $('#birth_month').val()!=-1 && $('#birth_year').val()!=-1){
                if(!validar_fecha()){
                    $('#birth_day').val('-1');
                    $('#birth_month').val('-1');
                    $('#birth_year').val('-1');
                }else{
                    $('#Profile_fecha_nacimiento').val($('#birth_year').val()+'-'+$('#birth_month').val()+'-'+$('#birth_day').val());
                }
            }
        });
    });
    
    function validar_fecha(){
        var dia = $('#birth_day').val();
        var mes = $('#birth_month').val();
        var anio = $('#birth_year').val();
        var numDias = 31;
        
        if(mes == 4 || mes == 6 || mes == 9 || mes == 11){
            numDias = 30;
        }
        
        if(mes == 2){
            if(comprobarSiBisisesto(anio)){
                numDias = 29;
            }else{
                numDias = 28;
            }
        }
        
        if(dia > numDias){
            //console.log('fecha invalida');
            return false;
        }
        return true;
    }
    
    function comprobarSiBisisesto(anio){
        if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
            return true;
        }
        else {
            return false;
        }
    }

</script>
