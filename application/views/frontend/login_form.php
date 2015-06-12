<!DOCTYPE html>
<html lang="en">
  <head>
<title>Login</title>

<meta name="robots" content="no-cache" />
<meta name="description" content="Energy Saving" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=3.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 38px;
        padding-bottom: 0px;
      }
    </style>
    <link href="/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/static/bootstrap/patch/html5.js"></script>
    <![endif]-->

    <link href="/static/site/css/main.css?id=<?= hsid()?>" rel="stylesheet">
    <link href="/static/site/css/frontend.css?id=<?= hsid()?>" rel="stylesheet">
    <link href="/static/site/css/backend.css?id=<?= hsid()?>" rel="stylesheet">
    
  </head>
 
        <link type="text/css" href="/static/jquery/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="/static/jquery/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="/static/jquery/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="/static/jquery/ex/jquery-ui-timepicker-addon.js"></script>



<div style="width:260px;margin:10px auto;padding:20px;border:1px solid #ccc">


<table>
        <tr> <td> 本系统支持如下浏览器： </td> </tr>
        <tr> <td> IE 7.0 + </td> </tr>
        <tr> <td> Google Chrome</td> </tr>
        <tr> <td> Firefox 2.0 +</td> </tr>
        <tr> <td> 如无上述浏览器，可<a href="/static/download/semos_1.0.rar">下载客户端</a></td> </tr>
</table>
</div>

<div style="width:260px;margin:10px auto;padding:20px;border:1px solid #ccc">
<form action="/user/login<?= $this->input->get("debug")=="cx"?"?debug=cx":""?>" 
    method="post" accept-charset="utf-8" id="es_login_form" >
<table>
        <tr>
                <td colspan="2"> <h3>登录节能云</h3>  </td>
        </tr>
        <tr>
                <td colspan="2"> <font color="red"><?= $errors?></font> </td>
        </tr>
	<tr>
		<td>用户:&nbsp;</td>
		<td><input name='login' type="text" value="<?= $login ?>" width="40" /></td>
	</tr>
	<tr>
                <td>密码:&nbsp;</td>
		<td colspan="2"><input name='password' type="password"  width="40"  /></td>
        </tr>
    <tr>
        <td colspan="2">
            <a href="javascript:$('#es_login_form').submit();void(0);" class="btn btn-primary" id="log_button">登录</a>
            <!--<a href="#" class="btn btn-primary" id="log_button">参观</a>-->
			<a style="float:right" href="/static/download/semos_1.0.rar" class="btn btn-primary" id="log_button" align="right">下载客户端</a>
        </td>
    </tr>
	
</table>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
	document.onkeydown = function(e){
		if(!e) e=window.event;
		if(e.keyCode==13 || e.which==13){
			document.getElementById("log_button").click();
		}
	}
</script>

