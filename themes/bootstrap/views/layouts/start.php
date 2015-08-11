<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon75.png" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl;?>/images/layout/favicon.ico" type="image/x-icon">
<?php  //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/styles.css',null); ?>


<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/helper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/dropdown.vertical.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/themes/default/default.css');
?>
<?php Yii::app()->bootstrap->register(); ?>
<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css',null); ?>
<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title>Sigma Tiendas</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

</head>
<style>
    .navbar.b2b{
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,ffffff+27,ffffff+44,ededed+96 */
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 0%, #ffffff 27%, #ffffff 44%, #ededed 96%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(27%,#ffffff), color-stop(44%,#ffffff), color-stop(96%,#ededed)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffffff 0%,#ffffff 27%,#ffffff 44%,#ededed 96%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffffff 0%,#ffffff 27%,#ffffff 44%,#ededed 96%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffffff 0%,#ffffff 27%,#ffffff 44%,#ededed 96%); /* IE10+ */
background: linear-gradient(to bottom,  #ffffff 0%,#ffffff 27%,#ffffff 44%,#ededed 96%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 ); /* IE6-9 */

    }
    .navbar.b2b>div{
  
    }
    
    .no_horizontal_padding{
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    .no_horizontal_margin{
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
    .no_left_padding{
        padding-left: 0px !important;

    }
    .no_left_margin{
        margin-left: 0px !important;

    }
    .no_right_padding{

        padding-right: 0px !important;
    }
    .no_right_margin{

        margin-right: 0px !important;
    }
    .separator{
        height: 1px;
        margin: 3px 0px;
        background: rgba(212,212,212,1);
background: -moz-linear-gradient(left, rgba(212,212,212,1) 0%, rgba(173,173,173,1) 5%, rgba(125,125,125,1) 51%, rgba(150,150,150,1) 95%, rgba(219,219,219,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(212,212,212,1)), color-stop(5%, rgba(173,173,173,1)), color-stop(51%, rgba(125,125,125,1)), color-stop(95%, rgba(150,150,150,1)), color-stop(100%, rgba(219,219,219,1)));
background: -webkit-linear-gradient(left, rgba(212,212,212,1) 0%, rgba(173,173,173,1) 5%, rgba(125,125,125,1) 51%, rgba(150,150,150,1) 95%, rgba(219,219,219,1) 100%);
background: -o-linear-gradient(left, rgba(212,212,212,1) 0%, rgba(173,173,173,1) 5%, rgba(125,125,125,1) 51%, rgba(150,150,150,1) 95%, rgba(219,219,219,1) 100%);
background: -ms-linear-gradient(left, rgba(212,212,212,1) 0%, rgba(173,173,173,1) 5%, rgba(125,125,125,1) 51%, rgba(150,150,150,1) 95%, rgba(219,219,219,1) 100%);
background: linear-gradient(to right, rgba(212,212,212,1) 0%, rgba(173,173,173,1) 5%, rgba(125,125,125,1) 51%, rgba(150,150,150,1) 95%, rgba(219,219,219,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4d4d4', endColorstr='#dbdbdb', GradientType=1 );
    }
    
</style>






<div class="navbar row-fluid b2b clearfix">
    <div class="col-md-8 col-md-offset-2">
                <div class="row-fluid">
                    <div class="col-md-2">
                        <div style="width:100%; height:30px; background:#000"></div>
                    </div>
                    <div class="col-md-5"><div style="width:100%; height:30px; background:#000"></div></div>
                    <div class="col-md-5"><div style="width:100%; height:30px; background:#000"></div></div> 
                    <div class="col-md-2" style="margin-top: 7px">
                        <div class="dropdown">
                                  <button class="btn btn-default form-control text-left dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Dropdown
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                  </ul>
                                </div>
                    </div>
                    <div class="col-md-10">
                        <div class="separator"></div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row-fluid">
                            <div class="col-md-3 no_horizontal_padding">
                                <div class="dropdown">
                                  <button class="btn btn-default form-control dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Dropdown
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                  </ul>
                                </div>
                            </div>
                            <div class="col-md-7 no_horizontal_padding">
                                <input class="form-control"/>
                            </div>
                            <div class="col-md-2 no_horizontal_padding">
                                <?php echo CHtml::submitButton('Buscar', array('class'=>'btn-orange btn btn-danger btn-large')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 no_horizontal_margin no_left_padding">
                        <div class="row-fluid">
                            <div class="col-md-4 no_right_padding">
                                <div style="width:100%; height:30px; background:#000"></div>
                            </div>
                            <div class="col-md-4 no_right_padding">
                                <div style="width:100%; height:30px; background:#000"></div>
                            </div>
                            <div class="col-md-4 no_right_padding">
                                <div style="width:100%; height:30px; background:#000"></div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
        </div>
</div>