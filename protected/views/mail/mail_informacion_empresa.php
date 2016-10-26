<div style="font-size: 14px;">
    <div style=" margin-top: 15px; font-size: 14px;">Estimado Cliente,
    </div>

    <div style=" margin-top: 4px;">
    <p>Te informamos que la empresa <?php echo $empresaPropia->razon_social;?> se ha registrado en Telotengo y ya se encuentra activa. 
	</p>
	<form action="<?php echo Yii::app()->getBaseUrl(true)."/empresas/perfilVendedor/".$empresaPropia->id;?>">
	    <input   type="submit" value="Ver su perfil" style="
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.428571429;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
    background-color: #ff5b0b;
    height: 34px;
    border: solid 1px #FFF;
    font-weight: 600;
    border-radius: 0;
    color: #fff;
    margin-left: 41.6%;
"/>
	</form>		                				                       
	
    </div>


</div>