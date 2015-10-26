<div class="col-md-4">
    <?php 
                        if($model->avatar_url){
                            echo CHtml::image(str_replace(".", "_thumb.", Yii::app()->baseUrl.$model->avatar_url),"Avatar",array('width'=>'70%','style'=>'border-radius: 50px;'));
                        }else{
                            echo '<img src="http://placehold.it/300x300" class="img-responsive" alt="Responsive image">';
                        }
                    ?>
</div>
<div class="col-md-8">
    
</div>
