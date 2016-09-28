<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Estimado <?php echo $user->profile->first_name." ".$user->profile->last_name; ?>,
    </div>

    <div style=" margin-top: 4px;">
    <p>Hemos observado que recientemente te has registrado en Telotengo pero aún no has adjuntado los documentos de tu empresa. Debes hacerlo a la brevedad posible para culminar tu proceso de registro y disfrutes plenamente de todos los beneficios que te ofrece nuestra plataforma. 
	</p>
							                       
	Haz click <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'].Yii::app()->createUrl('empresas/uploadFiles/id/'.$empresas_id_en.'/tipo/recordatorio');?>">aquí</a> y adjunta tus documentos.
    </div>


</div>