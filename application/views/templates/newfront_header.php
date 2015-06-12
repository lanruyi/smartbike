<? $this->load->view('templates/header.php');?>
</head>
<body>


<div style="float:left;width:100%;background-color:#2C4056;">
    <div class="base_center">
             <li style="float:right;padding:0 4px;list-style:none;">
                 <a href='/main' style="color:#fff;">切换系统</a> 
             </li>

			 <li style="float:right;padding:0 4px;list-style:none;">
				<a href="/static/download/semos_1.0.rar" style="color:#fff;" ><?=$this->lang->line("To download the client")?></a>
             </li>

             <li style="float:right;padding:0 4px;list-style:none;">
                 <a href='/newfront/project/switching' style="color:#fff;">切换项目</a> 
             </li>

             <li style="float:right;padding:0 5px;list-style:none">
                 <a href="/usercenter/index" title="个人中心" style="color:#fff;">我的账号</a>
             </li>
             <li style="float:right;padding:0 5px;list-style:none">
                 <a href="/user/logout" title="" style="color:#fff;"><?=$this->lang->line("Exit")?></a>
             </li>
             <li style="float:right;padding:0 5px;list-style:none"> 
                 <span style="color:#999;"><?=$this->lang->line("Hello")?></span><span style="color:#fff" ><?= $this->curr_user['name_chn'] ?></span>
             </li>
    </div>
</div>


<div style="width:100%;background-color:#507aaa;">
    <div class="base_center">
        <div class="es_sub_menu">
            <ul>
              <li class="<?= $this->uri->rsegment(1) == "project"?"active":"" ?>">
                <a href="">
                    项目
                </a>
              </li>
              <li class="<?= $this->uri->rsegment(1) == "city"?"active":"" ?>">
                <a href="">
                    城市
                </a>	
              </li>
              <li class="<?= $this->uri->rsegment(1) == "station"?"active":"" ?>">
                <a href="">
                    基站
                </a>	
              </li>
            </ul>
        </div>
    </div>
    <div style="clear:both"> </div>
</div>

