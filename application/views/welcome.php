<!DOCTYPE html>
<html lang="en">
  <head>
<title>节能云 博欧科技</title>

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
    <link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 0px;
        padding-bottom: 0px;
      }
    </style>
    <link href="/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/static/bootstrap/patch/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/static/bootstrap/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/static/bootstrap/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/static/bootstrap/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/static/bootstrap/ico/apple-touch-icon-57-precomposed.png">


<style>

/* Add additional stylesheets below
-------------------------------------------------- */
/*
  Bootstrap's documentation styles
  Special styles for presenting Bootstrap's documentation and examples
*/


/* Tweak navbar brand link to be super sleek
-------------------------------------------------- */
.navbar-fixed-top .brand {
  padding-right: 0;
  padding-left: 0;
  margin-left: 20px;
  float: right;
  font-weight: bold;
  color: #000;
  text-shadow: 0 1px 0 rgba(255,255,255,.1), 0 0 30px rgba(255,255,255,.125);
  -webkit-transition: all .2s linear;
     -moz-transition: all .2s linear;
          transition: all .2s linear;
}
.navbar-fixed-top .brand:hover {
  text-decoration: none;
}


/* Space out sub-sections more
-------------------------------------------------- */
section {
  padding-top: 60px;
}

/* Faded out hr */
hr.soften {
  height: 1px;
  margin: 54px 0;
  background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  border: 0;
}


/* Jumbotrons
-------------------------------------------------- */
.jumbotron {
  position: relative;
}
.jumbotron h1 {
  margin-bottom: 9px;
  font-size: 81px;
  font-weight: bold;
  letter-spacing: -1px;
  line-height: 1;
}
.jumbotron p {
  margin-bottom: 18px;
  font-weight: 300;
}
.jumbotron .btn-large {
  font-size: 20px;
  font-weight: normal;
  padding: 14px 24px;
  margin-right: 10px;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
}
.jumbotron .btn-large small {
  font-size: 14px;
}

 /* Jumbotron buttons */
  .jumbotron .btn {
    margin-bottom: 10px;
  }


/* Masthead (docs home) */
.masthead {
  padding-top: 36px;
  margin-bottom: 72px;
}
.masthead h1,
.masthead p {
  text-align: center;
}
.masthead h1 {
  margin-bottom: 18px;
}
.masthead p {
  margin-left: 5%;
  margin-right: 5%;
  font-size: 30px;
  line-height: 36px;
}


/* Specific jumbotrons
------------------------- */
/* supporting docs pages */
.subhead {
  padding-bottom: 0;
  margin-bottom: 9px;
}
.subhead h1 {
  font-size: 54px;
}

/* Subnav */
.subnav {
  width: 100%;
  height: 36px;
  background-color: #eeeeee; /* Old browsers */
  background-repeat: repeat-x; /* Repeat the gradient */
  background-image: -moz-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%); /* FF3.6+ */
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f5f5), color-stop(100%,#eeeeee)); /* Chrome,Safari4+ */
  background-image: -webkit-linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* Chrome 10+,Safari 5.1+ */
  background-image: -ms-linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* IE10+ */
  background-image: -o-linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* Opera 11.10+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#eeeeee',GradientType=0 ); /* IE6-9 */
  background-image: linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* W3C */
  border: 1px solid #e5e5e5;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}
.subnav .nav {
  margin-bottom: 0;
}
.subnav .nav > li > a {
  margin: 0;
  padding-top:    11px;
  padding-bottom: 11px;
  border-left: 1px solid #f5f5f5;
  border-right: 1px solid #e5e5e5;
  -webkit-border-radius: 0;
     -moz-border-radius: 0;
          border-radius: 0;
}
.subnav .nav > .active > a,
.subnav .nav > .active > a:hover {
  padding-left: 13px;
  color: #777;
  background-color: #e9e9e9;
  border-right-color: #ddd;
  border-left: 0;
  -webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,.05);
     -moz-box-shadow: inset 0 3px 5px rgba(0,0,0,.05);
          box-shadow: inset 0 3px 5px rgba(0,0,0,.05);
}
.subnav .nav > .active > a .caret,
.subnav .nav > .active > a:hover .caret {
  border-top-color: #777;
}
.subnav .nav > li:first-child > a,
.subnav .nav > li:first-child > a:hover {
  border-left: 0;
  padding-left: 12px;
  -webkit-border-radius: 4px 0 0 4px;
     -moz-border-radius: 4px 0 0 4px;
          border-radius: 4px 0 0 4px;
}
.subnav .nav > li:last-child > a {
  border-right: 0;
}
.subnav .dropdown-menu {
  -webkit-border-radius: 0 0 4px 4px;
     -moz-border-radius: 0 0 4px 4px;
          border-radius: 0 0 4px 4px;
}

/* Fixed subnav on scroll, but only for 980px and up (sorry IE!) */
@media (min-width: 980px) {
  .subnav-fixed {
    position: fixed;
    top: 40px;
    left: 0;
    right: 0;
    z-index: 1020; /* 10 less than .navbar-fixed to prevent any overlap */
    border-color: #d5d5d5;
    border-width: 0 0 1px; /* drop the border on the fixed edges */
    -webkit-border-radius: 0;
       -moz-border-radius: 0;
            border-radius: 0;
    -webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
       -moz-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
            box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); /* IE6-9 */
  }
  .subnav-fixed .nav {
    width: 938px;
    margin: 0 auto;
    padding: 0 1px;
  }
  .subnav .nav > li:first-child > a,
  .subnav .nav > li:first-child > a:hover {
    -webkit-border-radius: 0;
       -moz-border-radius: 0;
            border-radius: 0;
  }
}


/* Quick links
-------------------------------------------------- */
.bs-links {
  margin: 36px 0;
}
.quick-links {
  min-height: 30px;
  margin: 0;
  padding: 5px 20px;
  list-style: none;
  text-align: center;
  overflow: hidden;
}
.quick-links:first-child {
  min-height: 0;
}
.quick-links li {
  display: inline;
  margin: 0 5px;
  color: #999;
}
.quick-links .github-btn,
.quick-links .tweet-btn,
.quick-links .follow-btn {
  position: relative;
  top: 5px;
}


/* Marketing section of Overview
-------------------------------------------------- */
.marketing .row {
  margin-bottom: 9px;
}
.marketing h1 {
  margin: 36px 0 27px;
  font-size: 40px;
  font-weight: 300;
  text-align: center;
}
.marketing h2,
.marketing h3 {
  font-weight: 300;
}
.marketing h2 {
  font-size: 22px;
}
.marketing p {
  margin-right: 10px;
}
.marketing .bs-icon {
  float: left;
  margin: 7px 10px 0 0;
  opacity: .8;
}
.marketing .small-bs-icon {
  float: left;
  margin: 4px 5px 0 0;
}



/* Footer
-------------------------------------------------- */
.footer {
  margin-top: 45px;
  padding: 35px 0 36px;
  border-top: 1px solid #e5e5e5;
}
.footer p {
  margin-bottom: 0;
  color: #555;
}



/* Special grid styles
-------------------------------------------------- */
.show-grid {
  margin-top: 10px;
  margin-bottom: 20px;
}
.show-grid [class*="span"] {
  background-color: #eee;
  text-align: center;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
  min-height: 30px;
  line-height: 30px;
}
.show-grid:hover [class*="span"] {
  background: #ddd;
}
.show-grid .show-grid {
  margin-top: 0;
  margin-bottom: 0;
}
.show-grid .show-grid [class*="span"] {
  background-color: #ccc;
}


/* Render mini layout previews
-------------------------------------------------- */
.mini-layout {
  border: 1px solid #ddd;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.075);
     -moz-box-shadow: 0 1px 2px rgba(0,0,0,.075);
          box-shadow: 0 1px 2px rgba(0,0,0,.075);
}
.mini-layout {
  height: 240px;
  margin-bottom: 20px;
  padding: 9px;
}
.mini-layout div {
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
}
.mini-layout .mini-layout-body {
  background-color: #dceaf4;
  margin: 0 auto;
  width: 70%;
  height: 240px;
}
.mini-layout.fluid .mini-layout-sidebar,
.mini-layout.fluid .mini-layout-header,
.mini-layout.fluid .mini-layout-body {
  float: left;
}
.mini-layout.fluid .mini-layout-sidebar {
  background-color: #bbd8e9;
  width: 20%;
  height: 240px;
}
.mini-layout.fluid .mini-layout-body {
  width: 77.5%;
  margin-left: 2.5%;
}


/* Popover docs
-------------------------------------------------- */
.popover-well {
  min-height: 160px;
}
.popover-well .popover {
  display: block;
}
.popover-well .popover-wrapper {
  width: 50%;
  height: 160px;
  float: left;
  margin-left: 55px;
  position: relative;
}
.popover-well .popover-menu-wrapper {
  height: 80px;
}
.large-bird {
  margin: 5px 0 0 310px;
  opacity: .1;
}


/* Download page
-------------------------------------------------- */
.download .page-header {
  margin-top: 36px;
}
.page-header .toggle-all {
  margin-top: 5px;
}

/* Space out h3s when following a section */
.download h3 {
  margin-bottom: 5px;
}
.download-builder input + h3,
.download-builder .checkbox + h3 {
  margin-top: 9px;
}

/* Fields for variables */
.download-builder input[type=text] {
  margin-bottom: 9px;
  font-family: Menlo, Monaco, "Courier New", monospace;
  font-size: 12px;
  color: #d14;
}
.download-builder input[type=text]:focus {
  background-color: #fff;
}

/* Custom, larger checkbox labels */
.download .checkbox {
  padding: 6px 10px 6px 25px;
  color: #555;
  background-color: #f9f9f9;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
  cursor: pointer;
}
.download .checkbox:hover {
  color: #333;
  background-color: #f5f5f5;
}
.download .checkbox small {
  font-size: 12px;
  color: #777;
}

/* Variables section */
#variables label {
  margin-bottom: 0;
}

/* Giant download button */
.download-btn {
  margin: 36px 0 108px;
}
#download p,
#download h4 {
  max-width: 50%;
  margin: 0 auto;
  color: #999;
  text-align: center;
}
#download h4 {
  margin-bottom: 0;
}
#download p {
  margin-bottom: 18px;
}
.download-btn .btn {
  display: block;
  width: auto;
  padding: 19px 24px;
  margin-bottom: 27px;
  font-size: 30px;
  line-height: 1;
  text-align: center;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
}



/* Color swatches on LESS docs page
-------------------------------------------------- */
/* Sets the width of the td */
.swatch-col {
  width: 30px;
}
/* Le swatch */
.swatch {
  display: inline-block;
  width: 30px;
  height: 20px;
  margin: -6px 0;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
}
/* For white swatches, give a border */
.swatch-bordered {
  width: 28px;
  height: 18px;
  border: 1px solid #eee;
}


/* Misc
-------------------------------------------------- */

img {
  max-width: 100%;
}

/* Make tables spaced out a bit more */
h2 + table,
h3 + table,
h4 + table,
h2 + .row {
  margin-top: 5px;
}

/* Example sites showcase */
.example-sites img {
  max-width: 100%;
  margin: 0 auto;
}
.marketing-byline {
  margin: -18px 0 27px;
  font-size: 18px;
  font-weight: 300;
  line-height: 24px;
  color: #999;
  text-align: center;
}

.scrollspy-example {
  height: 200px;
  overflow: auto;
  position: relative;
}

/* Remove bottom margin on example forms in wells */
form.well {
  padding: 14px;
}

/* Tighten up spacing */
.well hr {
  margin: 18px 0;
}

/* Fake the :focus state to demo it */
.focused {
  border-color: rgba(82,168,236,.8);
  -webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,.1), 0 0 8px rgba(82,168,236,.6);
     -moz-box-shadow: inset 0 1px 3px rgba(0,0,0,.1), 0 0 8px rgba(82,168,236,.6);
          box-shadow: inset 0 1px 3px rgba(0,0,0,.1), 0 0 8px rgba(82,168,236,.6);
  outline: 0;
}

/* For input sizes, make them display block */
.docs-input-sizes select,
.docs-input-sizes input[type=text] {
  display: block;
  margin-bottom: 9px;
}

/* Icons
------------------------- */
.the-icons {
  margin-left: 0;
  list-style: none;
}
.the-icons i:hover {
  background-color: rgba(255,0,0,.25);
}

/* Eaxmples page
------------------------- */
.bootstrap-examples .thumbnail {
  margin-bottom: 9px;
  background-color: #fff;
}

/* Responsive table
------------------------- */
.responsive-utilities th small {
  display: block;
  font-weight: normal;
  color: #999;
}
.responsive-utilities tbody th {
  font-weight: normal;
}
.responsive-utilities td {
  text-align: center;
}
.responsive-utilities td.is-visible {
  color: #468847;
  background-color: #dff0d8 !important;
}
.responsive-utilities td.is-hidden {
  color: #ccc;
  background-color: #f9f9f9 !important;
}

/* Responsive tests
------------------------- */
.responsive-utilities-test {
  margin-top: 5px;
  margin-left: 0;
  list-style: none;
  overflow: hidden; /* clear floats */
}
.responsive-utilities-test li {
  position: relative;
  float: left;
  width: 25%;
  height: 43px;
  font-size: 14px;
  font-weight: bold;
  line-height: 43px;
  color: #999;
  text-align: center;
  border: 1px solid #ddd;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}
.responsive-utilities-test li + li {
  margin-left: 10px;
}
.responsive-utilities-test span {
  position: absolute;
  top:    -1px;
  left:   -1px;
  right:  -1px;
  bottom: -1px;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}
.responsive-utilities-test span {
  color: #468847;
  background-color: #dff0d8;
  border: 1px solid #d6e9c6;
}



</style>


  </head>

<body>

    <div class="navbar navbar-top">
      <div class="navbar-inner">
        <div class="container">
          <div class="nav-collapse">
            <ul class="nav" style="height:12px;">
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<br/>
<br/>
<br/>
<div class="container">

<header class="jumbotron masthead">
  <div class="inner" style="text-align:center;">
    
    <h1><img src="/static/site/img/green_cloud.png" style="height:80px;padding-bottom:15px"/>节能云&nbsp;&nbsp;博欧科技</h1>
    <p> 为了孩子们的未来 节约使用地球上每一度电</p>
    <p class="download-info">
      <a href="/statm/station" class="btn btn-primary btn-large">后端</a>
      <a href="/station" class="btn btn-primary btn-large ">前端</small></a>
      <a href="/mobile/mrealtime" class="btn btn-primary btn-large ">手机版</small></a>
      <a href="/static/download/airbornecloudv0.0.0.2.ipa" class="btn btn-large">下载IPAD版本</a>
    </p>
    <small> 推荐使用IE8.0+ Firefox6.5+ Chrome所有版本浏览器 以获得最佳效果</small>
  </div>
</header>

<hr class="soften">

<div class="marketing">
  <h1>博欧 通讯节能专家</h1>
  <p class="marketing-byline"> 这里有最方便快捷的通道，管理工具和服务 </p>

  <div class="row">
    <div class="span4">
      <img class="bs-icon" src="/static/bootstrap/img/glyphicons/glyphicons_042_group.png">
      <h2>系统后端，满足所有管理需求</h2>
      <p> 系统后端作为管理核心，组织分析数据，调整控制策略，让每一度电都花在刀口上 </p>
    </div>
    <div class="span4">
      <img class="bs-icon" src="/static/bootstrap/img/glyphicons/glyphicons_079_podium.png">
      <h2>系统前端，随时掌握节能状况</h2>
      <p> 系统前端有强大的图表，地图，分析结果数据报表等工具，将快速提供第一手资料，致力于更好的决策 </p>
    </div>
    <div class="span4">
      <img class="bs-icon" src="/static/bootstrap/img/glyphicons/glyphicons_163_iphone.png">
      <h2>多平台支持，智能终端</h2>
      <p> 让节能需求商务化，我们强大的技术团队将开发更多的应用，除了web端的强大应用，我们将进一步支持IPHONE，IPAD，Andriod等智能终端</p>
    </div>
  </div><!--/row-->

<footer>
<div class="row footer" style="text-align:center;">
    <p><strong> &copy; 2012 Designed by Xiang </strong> <br> Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div><!--row footer-->
</footer>

</div><!--contaner-->
</body>
</html>
