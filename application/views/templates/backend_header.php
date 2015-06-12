<? $this->load->view('templates/header');?>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>

<div style="float:left;width:100%;background-color:#2C4056;">
    <div class="base_center">
        <ul style="list-style:none;padding:0;margin:0">
             <li style="float:right;padding:0;list-style:none;">
                 <a href='/main' style="color:#fff;">切换系统</a> 
             </li>
             <li style="float:right;list-style:none"> 
                 <span style="color:#999;">您好！</span><strong style="color:#fff" ><?= $this->curr_user['name_chn'] ?></strong>
                    <?php echo anchor('/user/logout', '注销'); ?>  &nbsp;&nbsp;
             </li>
       </ul>
  </div>
</div>
