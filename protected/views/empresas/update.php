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
				$model->provincia=Ciudad::model()->findByPk($model->ciudad)->provincia_id;
				$model->ciudad2=$model->ciudad;
				$model->tipoEmpresa=$model->rol;
				echo $this->renderPartial('_form2',array('model'=>$model));
			?>

		</div>
	</div>
</div>