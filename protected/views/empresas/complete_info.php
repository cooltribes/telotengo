<!-- CONTENIDO ON -->
    <div class="container-fluid" style="padding: 0 15px;">
	
	<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->

        <div class="col-md-10  col-md-push-2 main-content" role="main">
			<h1>Empresas<small> - Solicitud</small></h1>
	
<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

<?php
$this->breadcrumbs=array(
	'Empresas'=>array('listado'),
	'Completar Información',
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

<h3>Completa la información de tu empresa: <?php echo $model->razon_social; ?></h3>

<h6>Completa los datos adicionales para acreditar tu empresa como vendedora.</h6>

<hr>

<h4>Documentos</h4>

<p>Agregue los documentos que verifiquen la existencia de la empresa (RIF, etc).</p>

<?php 
echo CHtml::link('Agregar', $this->createUrl('agregarDocumento', array('empresa_id'=>$model->id)), array('class'=>'btn btn-success'));
?>
<div id='contenedor_documentos'>
    <ul>
        <?php
        foreach ($documentos as $documento) {
            $nombre = '';
            switch ($documento->tipo) {
                case 1:
                    $nombre = 'RIF';
                    break;
                case 1:
                    $nombre = 'Registro de comercio';
                    break;
                case 1:
                    $nombre = 'Última declaración ISLR';
                    break;
                case 1:
                    $nombre = 'Referencia bancaria';
                    break;
                case 9:
                    $nombre = $documento->nombre;
                    break;
                default:
                    # code...
                    break;
            }
            echo '<li>'.CHtml::link($nombre, Yii::app()->baseUrl.'/documentos/'.$documento->empresas_id.'/'.$documento->ruta, array('target'=>'_blank')).' | '.CHtml::link('x', $this->createUrl('eliminarDocumento', array('id'=>$documento->id)), array()).'</li>';
        }
        ?>
    </ul>
</div>
<hr>
<h4>Datos de contacto</h4>  
<?php 
echo CHtml::link('Agregar', $this->createUrl('agregarDato', array('empresa_id'=>$model->id)), array('class'=>'btn btn-success'));
?>
<div id='contenedor_datos'>
    <ul>
        <?php
        foreach ($datos as $dato) {
            echo '<li><strong>'.$dato->tipo->nombre.': </strong>'.$dato->valor.' | '.CHtml::link('x', $this->createUrl('eliminarDato', array('id'=>$dato->id)), array()).'</li>';
        }
        ?>
    </ul>
</div>

<div class="form-actions">
    <?php
    echo CHtml::link('Finalizar', 'listado', array('class'=>'btn btn-info'));
    ?>
</div>



</div>
</div>
</div>
</div>
</div>
</div>