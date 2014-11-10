<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	'Detalle de la solicitud',
);

?>
    <?php if(Yii::app()->user->hasFlash('success')){?>
        <div class="alert in alert-block fade alert-success text_align_center">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>
    <?php if(Yii::app()->user->hasFlash('error')){?>
        <div class="alert in alert-block fade alert-error text_align_center">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php } ?>
    
    
<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
    		<h1>Detalle de la solicitud #<?php echo $model->id; ?> - 
    			<?php
    				switch ($model->estado) {
						case 1:
							echo "Solicitud de venta recibida.";
							break;
						case 2:
							echo "Aprobada.";
							break;
						case 3:
							echo "Rechazada.";
							break;
						case 4:
							echo "Suspendida.";
							break;
						case 5:
							echo "Solicitud cancelada.";
							break;
						
					}
    			?>
    			</h1>
  
<div class="row">
	<div class="span12">
		
		<div class="well">
			<h4>Información del usuario.</h4>	
		</div>
	
		<hr/>
			
		<?php
			$perfil = $user->profile;
		?>	
		
		<div class="span2">
			<a href="#" class=""><img src="http://placehold.it/150x150" alt="Perfil"></a>
			<p> <?php echo $perfil->first_name." ".$perfil->last_name; ?> </p>
		</div>
		
		<h5>Datos</h5>
		<hr/>
	
		<div class="span4">
			<p><strong>Email:</strong> <?php echo $user->email; ?> </p>
			<p><strong>Telefono:</strong> <?php echo $perfil->telefono; ?> </p>
			<p><strong>Fecha de Nacimiento:</strong> <?php echo $perfil->fecha_nacimiento; ?> </p>
		</div>
		
		<div class="span4">
			<p><strong>Cuenta registrada:</strong> <?php echo $user->create_at;  ?> </p>
			<?php
				$ven = Empresas::model()->countByAttributes(array('tipo'=>1));
				$com = Empresas::model()->countByAttributes(array('estado'=>2,'tipo'=>2));
				$total = EmpresasHasUsers::model()->countByAttributes(array('users_id'=>$user->id));
			?>
			<p><strong>Empresas a su nombre:</strong> <?php echo $total; ?> </p>
		</div>
		
	</div>
</div>		
		
<div class="row">
	<div class="span12">
		
	<div class="span7">
    	<div class="well well-small margin_top well_personaling_small">
			<h5 class="braker_bottom "> Datos de la empresa a registrar</h5>
			<hr/>	
				<p><strong>Razón Social:</strong> <?php echo $model->razon_social; ?> </p>
				<p><strong>RIF:</strong> <?php echo $model->rif; ?> </p>
				<p><strong>Dirección principal:</strong> <?php echo $model->direccion; ?> </p>
				<p><strong>Pagina Web:</strong> <?php echo $model->web; ?> </p>
				<p><strong>Email:</strong> <?php echo $model->mail; ?> </p>
        </div>
 	</div>
 	
 	<div class="span4">
    	<div class="well well-small margin_top well_personaling_small">
			<h5 class="braker_bottom margin_top"> Documentos </h5>
			<?php
				
				$doc = Documentos::model()->findAllByAttributes(array('empresas_id'=>$model->id));
			
				if(isset($doc))
				{                
					foreach($doc as $uno)
					{
						switch($uno){
							case 1:
								echo '<p><a href="'.Yii::app()->baseUrl.'/documentos/'.$model->id.'/'.$uno->ruta.'" target="_blank" >RIF </a></p>';		
								break;
							case 2:
								echo '<p><a href="'.Yii::app()->baseUrl.'/documentos/'.$model->id.'/'.$uno->ruta.' target="_blank" ">Registro de Comercio</a></p>';	
								break;
							case 3:
								echo '<p><a href="'.Yii::app()->baseUrl.'/documentos/'.$model->id.'/'.$uno->ruta.' target="_blank" ">Última declaración del ISLR</a></p>';	
								break;
							case 4:
								echo '<p><a href="'.Yii::app()->baseUrl.'/documentos/'.$model->id.'/'.$uno->ruta.' target="_blank" ">Referencias Bancarias</a></p>';	
								break;
							case 9:
								echo '<p><a href="'.Yii::app()->baseUrl.'/documentos/'.$model->id.'/'.$uno->ruta.' target="_blank" ">Otros</a></p>';	
								break;
						
						}
					}
					
				}
				else {
					echo "<p>La empresa solicitante no agregó ningún documento.</p>";
				}
			?>
        </div>
 	</div>
   
	</div>		
</div>

<div>
	
	<?php
	
	if($model->estado != 5)
	{
		$this->widget('bootstrap.widgets.TbButton', array(
	    	'label'=>'Aprobar',
	    	'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    	'buttonType'=>'link',
	    	'url'=>Yii::app()->baseUrl.'/empresas/aprobar/id/'.$model->id,
		)); 
	}
	
	if($model->estado == 1 || $model->estado == 2)
	{
		$this->widget('bootstrap.widgets.TbButton', array(
	    	'label'=>'Rechazar',
	    	'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    	'buttonType'=>'link',
	    	'url'=>Yii::app()->baseUrl.'/empresas/rechazar/id/'.$model->id,
		));
		
	}	
	?>
	
	
</div>
    
    </div>


</div>
</div>

<!-- /container -->
</script>