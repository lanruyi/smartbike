<!DOCTYPE html>
<html lang="en">
<head>   
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
</head>

<body>
登录成功！
<br>
<a href="/">点击进入首页</a>
<br>
<a href= "<?= $this->session->userdata('his_url')?>">点击进入之前的页面</a>
</body>
</html>