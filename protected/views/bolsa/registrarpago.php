<div class="container">
    <div class="row">
	    <div class="col-md-10 col-md-offset-1 main-content">

	    <h2>Registrar Pago de Gift Card</h2>
	    <hr/>

	    	<div class="well">
				<div class="row-fluid">
					<h3>Datos</h3> 
					<h4>Destinatario: <small><?php echo $model->email; ?></small></h4>
					<h4>Monto: <small><?php echo $model->total; ?></small></h4>
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			        'id'=>'pago-form', 
			        'enableAjaxValidation'=>false,
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
		                'validateOnSubmit'=>true, 
			        ),
			        'htmlOptions' => array(
					    'enctype' => 'multipart/form-data',
				    ),
				)); 
			?>

			<?php echo $form->errorSummary($pago); ?>

		    <div class="form-group">
		    	<?php
		    	echo $form->textFieldRow($pago,'nombre',array('class'=>'form-control','maxlength'=>45, 'placeholder' => 'Nombre del depositante'));
		    	echo $form->error($pago,'nombre');
		    	// echo CHtml::activeTextField($pago,'nombre', array('id' => 'nombre', 'class' => 'col-md-5 form-control', 'placeholder' => 'Nombre del depositante')); 
		    	?>
		    </div>
		    <div class="form-group"> 
	        	<?php
	        	echo $form->textFieldRow($pago,'confirmacion',array('class'=>'form-control','maxlength'=>45,'placeholder' => 'Número o Código del Depósito'));
				echo $form->error($pago,'confirmacion');
	        	//echo CHtml::activeTextField($pago,'confirmacion', array('id' => 'numeroTrans', 'class' => 'col-md-5', 'placeholder' => 'Número o Código del Depósito'));
	        	?>
		    </div>
		    <div class="form-group">
		    	<?php
		    	echo $form->textFieldRow($pago,'cedula',array('class'=>'form-control','maxlength'=>45,'placeholder' => 'Cedula del depositante'));
				echo $form->error($pago,'cedula'); 
	        	// echo CHtml::activeTextField($pago,'cedula', array('id' => 'cedula', 'class' => 'col-md-5', 'placeholder' => 'Cedula del depositante'));
	        	?>
		    </div>
		    <div class="form-group"> 
	        	<?php
	        	echo $form->textFieldRow($pago,'monto',array('class'=>'form-control','maxlength'=>45,'placeholder' => 'Monto depositado en bolivares'));
				echo $form->error($pago,'monto'); 
	        	//echo CHtml::activeTextField($pago,'monto', array('id' => 'monto', 'title' => 'Monto','class' => 'col-md-4','placeholder' => "Monto. Use coma (,) como separador decima"));
	        	?>
		    </div>
			<div class="form-group">
				<?php
					echo $form->labelEx($pago,'fecha');
					    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
					        'model' => $pago,
					        'attribute' => "fecha",
					        'language' => 'es',
					        'htmlOptions' => array('class'=>'form-control','placeholder'=>'Fecha del depósito'), 
					        // additional javascript options for the date picker plugin
					        'options'=>array(
					            'showAnim'=>'fold',
					            'dateFormat'=>'yy-mm-dd',
					        ),
					    ));
					echo $form->error($pago,'fecha');
					?>
			</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Enviar Pago',
		)); ?>
	</div>

	<?php 
    	$this->endWidget();
    ?>
    </div></div></div></div></div>
