<!DOCTYPE html>
<html lang="en">
  <head>

<?php
$meta = array(
        array('name' => 'robots', 'content' => 'no-cache'),
        array('name' => 'description', 'content' => 'Energy Saving'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
    );
echo meta($meta); 
?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <style type="text/css">
      body {
        padding-top: 0px;
        padding-bottom: 0px;
        min-width:1000px;
      }
    </style>

    <link href="/static/site/css/main.css?id=<?= hsid()?>" rel="stylesheet">
    <link href="/static/site/css/frontend.css?id=<?= hsid()?>" rel="stylesheet">
    <link href="/static/site/css/backend.css?id=<?= hsid()?>" rel="stylesheet"> 
    <link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/static/bootstrap/patch/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/static/bootstrap/ico/favicon.ico">

    <title><?= $this->dt['title']?>  SEMOS节能云 </title>

    <link type="text/css" href="/static/jquery/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="/static/jquery/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="/static/jquery/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="/static/jquery/ex/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="/static/site/js/public.js?id=<?= hsid()?>"></script>
  
    <script>
    $(document).ready(function(){
            // hide #back-top first
            $("#back-top").hide();

            // fade in #back-top
            $(function () {
                    $(window).scroll(function () {
                            if ($(this).scrollTop() > 100) {
                                    $('#back-top').fadeIn();
                            } else {
                                    $('#back-top').fadeOut();
                            }
                    });

                    // scroll body to 0px on click
                    $('#back-top a').click(function () {
                            $('body,html').animate({
                                    scrollTop: 0
                            }, 800);
                            return false;
                    });
            });

    });
    </script>

    <style>
    /*
    Back to top button 
    */
    #back-top {
            position: fixed;
            bottom: 200px;
            margin-right: 10px;
            float: right;
    }
    #back-top a {
            width: 108px;
            display: block;
            text-align: center;
            font: 11px/100% Arial, Helvetica, sans-serif;
            text-transform: uppercase;
            text-decoration: none;
            color: #bbb;
            /* background color transition */
            -webkit-transition: 1s;
            -moz-transition: 1s;
            transition: 1s;
    }
    </style>
