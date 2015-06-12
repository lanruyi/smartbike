<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title><?= $this->dt['title']?></title>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="" name="description" />
   <meta content="xiang" name="author" />
   <!-- BEGIN GLOBAL MANDATORY STYLES -->          
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/font-awesome/css/font-awesome.min.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap/css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/uniform/css/uniform.default.css" />
   <!-- END GLOBAL MANDATORY STYLES -->
   <!-- BEGIN PAGE LEVEL PLUGIN STYLES --> 

   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/jquery-multi-select/css/multi-select.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-conquer.css"/>
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/jquery-tags-input/jquery.tagsinput.css" />
   <link rel="stylesheet" type="text/css" href="/static/assets/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">

   <link rel="stylesheet" type="text/css" href="/static/lightbox/css/lightbox.css">

   <!-- END PAGE LEVEL PLUGIN STYLES -->
   <!-- BEGIN THEME STYLES --> 
   <link href="/static/assets/css/style-conquer.css" rel="stylesheet" type="text/css"/>
   <link href="/static/assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="/static/assets/css/style-non-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="/static/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
   <link href="/static/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="/static/assets/css/custom.css" rel="stylesheet" type="text/css"/>
   <!-- END THEME STYLES -->
   <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body style="min-width:1100px">
   <!-- BEGIN HEADER -->   
   <!-- END HEADER -->
   <div class="clearfix"></div>
   <!-- BEGIN CONTAINER -->
   <div class="page-container">

      <!-- vimjumper back_side.php -->
      <?= $this->load->view('/newback/back_side'); ?>

      <!-- BEGIN PAGE -->
      <div class="page-content">

<!-- BEGIN PAGE HEADER-->
<div class="well my-page-title">
<!-- BEGIN PAGE TITLE & BREADCRUMB-->
<span class="title"><?= $title?></span> 
<!-- END PAGE TITLE & BREADCRUMB-->
</div>
<!-- END PAGE HEADER-->
