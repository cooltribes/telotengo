<div class="modal-header no_border no_padding_bottom">
     <button type="button" class="close pull-right no_margin_top" data-dismiss="modal" aria-hidden="true">&times;</button>
     <h3>Editar <?php echo $fname ?></h3>
   
  
</div>
<div class="modal-body no_padding_top">
<hr class="no_margin_top"/>
    <div class="padding_small no_padding text-center row-fluid">  
            <div class="col-md-8 col-md-offset-2">
            <?php if($field==1): 
                $vars="var first_name=$('#first_name').val(); var last_name=$('#last_name').val();";
                $post="first_name:first_name, last_name:last_name"                ?>

                <input class="form-control margin_top_small" type="text" name="first_name" id="first_name" placeholder="Nombre" value="<?php echo $profile->first_name?>"/>
                <input class="form-control margin_top_small" type="text" name="last_name" id="last_name" placeholder="Apellido" value="<?php echo $profile->last_name?>"/>
            <?php endif;?>
            
            <?php if($field==2): 
                $vars="var rol=$('#rol').val(); ";
                $post="rol:rol"  
                ?>
                <input class="form-control margin_top_small" type="text" name="rol" id="rol" placeholder="Cargo en la Empresa" value="<?php echo $rol->rol?>"/>
            <?php endif;?>
            
            <?php if($field==4): 
                $vars="var telefono=$('#telefono').val(); ";
                $post="telefono:telefono"?>
                <input class="form-control margin_top_small" type="text" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $profile->telefono ?>"/>
            <?php endif;?>
            
            <?php if($field==6): 
                $vars="var password=$('#password').val(); var new_password=$('#new_password').val(); var new_password2=$('#new_password2').val();";
                $post="password:password, new_password:new_password, new_password2:new_password2"
                
                ?>
                <input class="form-control margin_top_small" type="password" name="password" id="password" placeholder="Contraseña actual" />
                <input class="form-control margin_top_small" type="password" name="new_password" id="new_password" placeholder="Nueva contraseña" />
                <input class="form-control margin_top_small" type="password" name="new_password2" id="new_password2" placeholder="Confirme nueva contraseña"/>
            <?php endif;?>
            
            </div>
            <div class="errorMessage col-md-12"></div>
            <button class="btn btn-orange white margin_top_small" onclick="guardar()" id="save-btn">Guardar</button>
        </div>
        
         
</div>

<script>
    function guardar(){
        
        <?php echo $vars ?>
        editMode=true;
        $('#save-btn').attr('disabled','disabled');
        var opcion='<?php echo $field;?>';
        $.ajax({
                  url: "editField",
                  type: "post",
                  dataType:'json',
                  data: {  <?php echo $post ?>, editMode:editMode, opcion:opcion },
                  success: function(data){
                      if(data.status=="ok"){
                          $('#changeField').modal('toggle');
                          location.reload(); 
                          
                      }else{
                          $(".errorMessage").html('<small>'+data.error+'</small>');
                          $('#save-btn').removeAttr('disabled');
                      }
                      
                  },
            });
    }
</script>

