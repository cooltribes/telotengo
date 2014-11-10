<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">

<?php
$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	'Crear',
);
?>

<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>asEmpresas<small> - Solicitud</small></h1>

			<h3><?php echo '¡Bienvenido, '.$profile->first_name.'!'; ?></h3>

<?php echo $this->renderPartial('_form_admin', array('model'=>$model, 'empresa_user' => $empresa_user)); ?>

</div>
</div>
</div>