<h1>Perfil</h1>
    <div class="avatar margin_top">
        <div class="image text-center">
            <?php 
                        if($model->avatar_url){ 
                            echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('width'=>'100%','style'=>'border-radius: 0px;'));
                        }else{
                            echo '<img src="http://placehold.it/300x300" class="img-responsive" alt="Responsive image">';
                        }
             ?>
        </div>
        <?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
        	<div class="change"> 
                	<a onclick="$('#changeAvatar').modal()">Cambiar foto</a>
       		 </div>
        <?php endif;?>
    </div>
     


    <div class="row-fluid info clearfix">
            <div class="col-md-9 no_padding_left name">
                <?php echo $model->profile->first_name." ".$model->profile->last_name; ?>
            </div>
            <div class="col-md-3 text-center no_horizontal_padding edit edit-name">

            	<?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
                	<a onclick="editField(1,'Nombre')">Editar</a>
                <?php endif;?>

            </div>
     </div> 
     <div class="info clearfix"> 
         
         <div class="row-fluid item clearfix margin_top_small">
             <span class="col-md-1 no_horizontal_padding icon">
                <span class="glyphicon glyphicon-briefcase"></span>
            </span>
            
            <span class="col-md-8 no_horizontal_padding value">
                <?php echo $model->getPuesto($identificador); ?>
            </span>
            
            <span class="col-md-3 text-center no_horizontal_padding edit">

         

                 <?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
                	<a onclick="editField(2,'Cargo')">Editar</a>
                <?php endif;?>

            </span>
             
         </div>     
            
               
            
            <!-- -->
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <b>@</b>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    <?php echo $model->email; ?>
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                  <!--  <a>Editar</a> -->
                </span> 
            </div>
             <!-- -->
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-phone"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    <?php echo $model->profile->telefono; ?>
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
      <?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
                	<a onclick="editField(4,'Teléfono')">Editar</a>
                <?php endif;?>

                </span> 
            </div>
             <!-- -->
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-plus"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    Agregar información
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                <?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
                	<a>Editar</a>
                <?php endif;?>
                </span> 
            </div>
            <div class="separator"></div>
             <!-- -->
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                   <span class="glyphicon glyphicon-asterisk"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    Cambiar Contraseña
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                 <?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
                	<a onclick="editField(6,'Contraseña')">Editar</a>
                <?php endif;?>
                </span>   
             </div>   
             <!-- -->
            <div class="row-fluid item clearfix margin_top_small">
                <span class="col-md-1 no_horizontal_padding icon">
                    <span class="glyphicon glyphicon-envelope"></span>
                </span>
                
                <span class="col-md-8 no_horizontal_padding value">
                    Preferencias de Correo
                </span>
                
                <span class="col-md-3 text-center no_horizontal_padding edit">
                 <?php if(Yii::app()->user->id==$identificador): // si es igual edite, del resto no?>
                	<a>Editar</a>
                <?php endif;?>
                </span> 
        </div>
       
    </div>
    
    <div id="changeAvatar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; min-height: 550px;">
        <?php echo $this->renderPartial('avatar', array( 'model'=>$model ),true); ?>
    </div>
    <div id="changeField" class="modal fade miniModal " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;" >
        
    </div>
    
    <script>
      function  editField(field,fname){
 
        $.ajax({
            type: "post", 
            url: "editField", // action 
            dataType: 'json',
            data: { 'field':field,'fname':fname}, 
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
   
