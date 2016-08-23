<div class="modal-header no_border no_padding_bottom">
     <button type="button" class="close pull-right no_margin_top" data-dismiss="modal" aria-hidden="true">&times;</button>
     <h3>Editar <?php echo $fname ?></h3>
   
  
</div>
<div class="modal-body no_padding_top">
<hr class="no_margin_top"/>
    <div class="padding_small no_padding text-center row-fluid">  
            <div class="col-md-8 col-md-offset-2">
            
            
            <?php if($field==4): 
                $vars="var telefono=$('#telefono').val(); ";
                $post="telefono:telefono"?>
                <input class="form-control margin_top_small" type="text" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $empresas->telefono ?>"/>
            <?php endif;?>

            <?php if($field==5): 
                $vars="var web=$('#web').val(); ";
                $post="web:web"?>
                <input class="form-control margin_top_small" type="text" name="web" id="web" placeholder="Telefono" value="<?php echo $empresas->web ?>"/>
            <?php endif;?>
            
            </div>
            <div class="errorMessage col-md-12"></div>
            <button class="btn btn-orange white margin_top_small" onclick="guardar()" id="save-btn">Guardar</button>
        </div>
        
         
</div>

<script>
    function guardar(){
        
        <?php echo $vars ?>
        var id_empresa="<?php echo $empresas->id;?>";
        editMode=true;
        $('#save-btn').attr('disabled','disabled');
        var opcion='<?php echo $field;?>';
        $.ajax({
                  url: "editField",
                  type: "post",
                  dataType:'json',
                  data: {  <?php echo $post ?>, editMode:editMode, opcion:opcion, id_empresa:id_empresa },
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
