<!-- CONTENIDO ON -->
<div class="container-fluid" style="padding: 0 15px;">
     	
	<?php
	$this->breadcrumbs=array(
		'Empresas'=>array('admin'),
		'Editar',
	);

	?>

	<div class="row">
	        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Empresas<small> - Editar datos de empresa <?php if($model->tipo == 2) echo "vendedora: "; echo $model->razon_social; ?></small></h1>

			<?php
			if($connected_user->superuser == 1){
				echo $this->renderPartial('_form_admin',array('model'=>$model, 'empresa_user' => $empresa_user));
			}else{
				echo $this->renderPartial('_form',array('model'=>$model, 'empresa_user' => $empresa_user));
			}
			?>

		</div>
	</div>
</div>