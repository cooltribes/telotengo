<style>
    .form-group{
       height: 51px;
       margin-bottom:10px;
    }
        .button-form{
        width:100%; 
    }
    .form-horizontal input.error{
        color: white;
    }
    a.blueLink {
    color: white;
}
    #UserLogin_username,#UserLogin_password,#btn-login-b2b,#recuperarPassword
    {
        display:none;
    }
</style>
<div class="row-fluid">
    <h5 class="col-md-8 col-md-offset-2 text-center">
            
   </h5>
    <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 margin_top orangepanel">
        <h4 class="text-center">
            y por último, adjunta los siguientes documentos 
        </h4>
              
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'empresas-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'type'=>'horizontal',
    'clientOptions'=>array(
        'validateOnSubmit'=>false,  
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>
     
    <?php 
        echo $form->hiddenField($model,'oculta',array('value'=>'2'));
      #echo $form->errorSummary($model);?>
     

    <div class="col-md-9 margin_top_small">
        <div class="col-md-4 col-md-offset-2 margin_top_small">
            <label class="control-label">RIF</label> <span class="required">*</span>
        </div>
        <div class="col-md-6 margin_top_small">
            <input name="fichero_rif" type="file" id="rif"/>
            <span class="help-inline error hide" id="rif_em">Debe elegir un documento</span>
        </div>
    </div> 
    <div class="col-md-9 margin_top_small"> 
        <div class="col-md-4 col-md-offset-2 margin_top_small">
            <label class="control-label">Registro Mercantil</label> <span class="required">*</span>
        </div>
        <div class="col-md-6 margin_top_small">
            <input name="fichero_registro_mercantil" type="file" id="registro_mercantil"/>
            <span class="help-inline error hide" id="registro_mercantil_em">Debe elegir un documento</span>
        </div>

         

    </div> 

        <div class="col-md-12 margin_top">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Enviar documentos',
            'htmlOptions'=>array('class'=>'btn-black btn btn-danger btn-large botone button-form btn btn-primary','id'=>'guardar')
        )); ?>
        <div class="col-md-5 col-md-offset-4"> 
             <a class="blueLink" href="solicitudFinalizada">Enviar luego los documentos</a> 
        </div>            
    </div>

    <?php $this->endWidget(); ?>
    </div>
    
</div>

<script>
$(document).ready(function(){

    $('#guardar').on('click', function(event) {
        event.preventDefault();
        submitForm();

    });
});

 function submitForm(){
        var respuesta=0;
        var resp;  
        var submit = true;
        var field = "";  
        var array =new Array('#rif', '#registro_mercantil');
        for(i=0; i<array.length; i++){
            resp=validate(array[i]);
            submit = resp[0];
            if(submit==false)
              respuesta=1;
            if(resp[1]!='')
                field = resp[1];
        }    
        if(respuesta==0){
            $('#empresas-form').submit();
        }            
        else{
            $(window).scrollTop($(field).position().top-100);    
        }
    }

        function validate(id){
        var submit = true;
        var field = id;
        if($(id).val()==''){
            submit=false;
            $(field).addClass('error');
            $(field+'_em').removeClass('hide');
            $(field+'_em').text('no puede estar vacio');
        }else
        {
          $(field).removeClass('error');
          if(!$(field+'_em').hasClass('hide'))
          {
              $(field+'_em').addClass('hide');
          }  

        field="";
        }
        
        return [submit,field];
    }

</script>