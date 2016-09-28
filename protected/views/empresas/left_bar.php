<style>
    .button-form{
        width:100%; 
    }
</style>
<h1>Perfil de la empresa</h1>
    <div class="avatar margin_top_medium">
        <div class="image text-center">
            <?php 
                        if($model->avatar_url){ 
                            echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('width'=>'100%','style'=>'border-radius: 0px;'));
                        }else{
                            echo '<img src="http://placehold.it/300x300" class="img-responsive" alt="Responsive image">';
                        }
             ?>
        </div>
        <?php if($empresaPropia==1 && $admin==1): // si es igual edite, del resto no?>
        	<div class="change"> 
                	<a onclick="$('#changeAvatar').modal()">Cambiar foto</a>
       		 </div>
        <?php endif;?>
    </div>
     


    <div class="row-fluid info clearfix">
            <div class="col-md-9 no_padding_left name">
                <?php echo $model->razon_social; ?>
            </div>
            <div class="col-md-3 text-center no_horizontal_padding edit edit-name">
            </div>
     </div> 
     <div class="info clearfix"> 
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-briefcase"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    <?php echo $model->itemAlias('Sector', $model->sector); ?>
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                <?php if($empresaPropia==1 && $admin==1): // si es igual edite, del resto no?>
                  <!--  <a onclick="editField(4,'Teléfono',<?php echo $model->id; ?>)">Editar</a> -->
                <?php endif;?>

                </span>  
            </div>
         <div class="row-fluid item clearfix margin_top_small">
             <span class="col-md-1 no_horizontal_padding icon">
                <span class="glyphicon glyphicon-info-sign"></span>
            </span>
            
            <span class="col-md-8 no_horizontal_padding value">
                <?php echo $model->rif; ?>
            </span>
            
            <span class="col-md-3 text-center no_horizontal_padding edit">  
            </span>
             
         </div>     
             <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-map-marker"></span>
                </span>
                
                <span class="col-md-11 no_horizontal_padding value">
                    <?php echo $model->direccion; ?>
                </span>
                
            </div>
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-map-marker"></span>
                </span>
                
                <span class="col-md-11 no_horizontal_padding value">
                    <?php echo $model->city->nombre.", ".$model->city->provincia->nombre.", ".$model->zip; ?>
                </span>
            </div>
             <!-- -->
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-phone"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    <?php echo $model->telefono!=''?$model->telefono:"N/D"; ?>
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                <?php if($empresaPropia==1 && $admin==1): // si es igual edite, del resto no?>
                	<a onclick="editField(4,'Teléfono',<?php echo $model->id; ?>)">Editar</a>
                <?php endif;?>

                </span>  
            </div>
            <?php if($model->web!="")
            {?>
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-globe"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    <?php echo $model->web; ?>
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                <?php if($empresaPropia==1 && $admin==1): // si es igual edite, del resto no?>
                    <a onclick="editField(5,'web', <?php echo $model->id ?>)">Editar</a>
                <?php endif;?>

                </span>  
            </div>
        <?php
            }else
            {
               if($empresaPropia==1 && $admin==1)
               {?>
                <div class="row-fluid item clearfix margin_top_small">
                    <span class="col-md-1 no_horizontal_padding icon">
                        <span class="glyphicon glyphicon-globe"></span>
                    </span>
                    
                    <span class="col-md-6 no_horizontal_padding value">
                        <a onclick="editField(5,'web', <?php echo $model->id ?>)">Añadir página web</a>
                    </span>
                </div>
                <?php
               } 
            }?>

            
       
    </div>
    <div id="changeAvatar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; min-height: 550px;">
        <?php echo $this->renderPartial('avatar', array( 'model'=>$model ),true); ?>
    </div>
    <div id="changeField" class="modal fade miniModal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;" >
        
    </div>
    
    <script>
      function  editField(field,fname, id_empresa){
 
        $.ajax({
            type: "post", 
            url: "editField", // action 
            dataType: 'json',
            data: { 'field':field,'fname':fname, 'id_empresa':id_empresa}, 
            success: function (data) {
                
                if(data.status=='ok')
                {
                    $('#changeField').html(data.content);
                    $('#changeField').modal();
 
                }
                            
            }
            //success
           });   
        }
        
    </script>
   
