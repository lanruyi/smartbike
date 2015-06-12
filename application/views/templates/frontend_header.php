<? $this->load->view('templates/header.php');?>
</head>
<body>


<div style="float:left;width:100%;background-color:#2C4056;">
    <div class="base_center">
             <li style="float:right;padding:0 4px;list-style:none;">
                 <a href='/main' style="color:#fff;"><?=$this->lang->line("Switching system")?></a> 
             </li>

			 <li style="float:right;padding:0 4px;list-style:none;">
				<a href="/static/download/semos_1.0.rar" style="color:#fff;" ><?=$this->lang->line("To download the client")?></a>
             </li>

             <li style="float:right;padding:0 4px;list-style:none;">
                 <a href='/frontend/project/projects' style="color:#fff;"><?=$this->lang->line("Switching project")?></a> 
             </li>

             <li style="float:right;padding:0 5px;list-style:none">
                 <a href="/usercenter/index" title="访问个人中心" style="color:#fff;"><?=$this->lang->line("My Account")?></a>
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



        <div class="logo l">
            <h2><a href="#" title=""><?= $this->current_project['name_chn']?></a></h2>
        </div>


        <?if($this->user_role['id'] == 6){?>
            <div class="city l"><span><a href="#" ><?= $this->current_city['name_chn']?></a></span>
            </div>
        <?} else {?>
            <div class="city l"><span><a href="javascript:void(0)" class="js_ct"><?= $this->current_city['name_chn']?></a></span>
              <b><a href="javascript:void(0);" class="js_ct"><?= $this->current_city['name_chn']?></a></b>
            </div>
        <?}?>

        <div class="search" style="float:right;margin-left:50px;">
          <form id="search_form" method="get" action="/frontend/search">
            <p>
                <input type="text" name="search" id="query" class="Int" 
                onblur="this.value==''?this.value=this.title:null" 
                onfocus="this.value==this.title?this.value='':null" 
                title="请输入站点名（或部分）搜索" 
                value="<?= isset($search)?$search:"请输入站点名（或部分）搜索"?>" autocomplete="off">
                <a href="javascript:document.getElementById('search_form').submit()" class="Btn"></a>
            </p>
          </form>
        </div>


        <div style="clear:both;height:3px;overflow:hidden"></div>
        <div class='pop_city_menu'>
            <ul>
              <? if(isset($url)){?>
                <? foreach($this->project_cities as $city){?>
                  <li> <a href='/frontend/stations/change_city/<?= $city['id']?>?url=<?= $url ?>'><?= $city['name_chn']?> </li>
                <?}?>
              <?}else{?>
                <? foreach($this->project_cities as $city){?>
                  <li> <a href='/frontend/stations/change_city/<?= $city['id']?>'><?= $city['name_chn']?> </li>
                <?}?>
              <?}?>
            </ul>
        </div>


        <div class="es_sub_menu">
            <ul>
              <li class="<?= ($this->uri->rsegment(1) == "stations" || 
                              $this->uri->rsegment(1) == "single")?"active":"" ?>">
                <a href="<?= h_project_url("station_list",$this->current_project['type'])?>">
                    <?=$this->lang->line("Station")?></a>
              </li>
              <li class="<?= $this->uri->rsegment(1) == "warning"?"active":"" ?>">
                <a href="/frontend/warning"><?=$this->lang->line("Warning")?></a>	
              </li>
              <li class="<?= $this->uri->rsegment(1) == "map"?"active":"" ?>">
                <a href="/frontend/map"><?=$this->lang->line("Map")?></a>  
              </li>      
              <li  class="<?= $this->uri->rsegment(1) == "export"?"active":"" ?>" style="display:none;">
                <a href="/frontend/export"><?=$this->lang->line("Export")?></a>  
              </li>      
            </ul>
        </div>
    </div>
    <div style="clear:both"> </div>
</div>

<script>
    $(function(){

        $(".js_ct").click(function(){ 
            $(".pop_city_menu").slideToggle("fast");
        });
    
    });
</script>

