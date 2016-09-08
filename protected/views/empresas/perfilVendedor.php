<style>
          .admini{
             padding-top:21px;
          }
</style>
<?php $this->breadcrumbs=array('Perfil de empresa'); ?>
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="alert in alert-block fade alert-success text_align_center">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php } ?>
<?php if(Yii::app()->user->hasFlash('error')){?>
    <div class="alert in alert-block fade alert-danger text_align_center">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php } ?> 

<div class="col-md-3 profile-leftBar">
    <?php $this->renderPartial('left_bar',array('model'=>$model, 'empresaPropia'=>$empresaPropia, 'admin'=>$admin)); ?> 
</div>
<?php if($avatar===true):
    echo "<script>$('#layout-avatar').attr('src','".Yii::app()->getBaseUrl(true);
     if(strpos($model->avatar_url, ".png")==-1)
        echo str_replace(".jpg", "_thumb.jpg", $model->avatar_url);
    else
        echo str_replace(".png", "_thumb.png", $model->avatar_url); 

     
     echo "');</script>"; 
     endif;  
     ?>
        <div class="col-md-9 profile-center margin_top_large">

    <?php $this->renderPartial('informacionGeneral',array('model'=>$model, 'empresaPropia'=>$empresaPropia, 'admin'=>$admin)); ?> 
    </div>
<script>
    
    function showInfo(id){
        if($(id).hasClass('hide')){
            $(id).removeClass('hide');
            $(id+'-show').html('Ocultar Información');           
        }            
        else{
            $(id).addClass('hide');
            $(id+'-show').html('Mostrar Información');
        }
            
    }
</script>