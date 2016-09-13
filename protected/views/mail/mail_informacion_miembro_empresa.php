<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Estimado Cliente,
    </div>

    <div style=" margin-top: 4px;">

    <p>Te informamos que <?php echo $nombreCompleto." (".$user->email.")"; ?> ha activado su cuenta en Telotengo. 
	</p>				                       
	Si deseas ver su perfil, haz clic <a href="<?php echo Yii::app()->getBaseUrl(true)."/user/profile/index/ide/".$user->id;?>">aquí</a>
    </div>


</div>