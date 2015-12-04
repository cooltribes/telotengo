<nav class="navbar navbar-default row-fluid" id="adminNav">
        <div class="container-fluid col-md-8 col-md-offset-2">
          <!--<div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>-->
          
          <div id="navbar" class="navbar-collapse collapse">

               <a class="" href="<?php echo Yii::app()->getBaseUrl(true);?>"><img src="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/whitelogo.png" width="20%"/></a>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo Yii::app()->baseUrl; ?>/tienda">Tienda</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
                <ul class="dropdown-menu">
                           
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin/solicitudes">Solicitudes</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/admin">Usuarios</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/almacen/admin">Almacenes</a> </li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Productos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                   <li><a href="<?php echo Yii::app()->baseUrl; ?>/productoPadre/admin">Productos padre</a></li> 
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/producto/admin">Variaciones</a></li>
                         <!--   <li><a href="<?php echo Yii::app()->baseUrl; ?>/pregunta/admin">Preguntas</a></li> -->
                </ul>
              </li>
              <li><a href="<?php echo Yii::app()->baseUrl; ?>/orden/admin">Ordenes</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
                <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/marca/admin">Marcas</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/color/admin">Color</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/unidad/admin">Unidad</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/atributo/admin">Atributo</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/categoria/admin">Categorías</a></li>

                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cuenta <span class="caret"></span></a>
                <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile">Perfil</a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/site/logout">Salir</a></li>                            

                </ul>
              </li>   
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      
    <div class="col-md-8 col-md-offset-2 no_horizontal_padding" id="pageContainer">
        <div class="row-fluid margin_top_small">   
         <?php if(isset($this->breadcrumbs)):?>
          <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                    'links'=>$this->breadcrumbs,
                )); ?>
          <!-- breadcrumbs -->
          <?php endif?> 
        <?php echo $content; ?>
    </div>
</div>