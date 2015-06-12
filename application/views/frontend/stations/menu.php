
<div class="base_center">
<div class="es_stations_choose" style="background-color:#ccc">
    <ul style="margin-bottom:2px;">
              <div class="input-append" style="">
                <input class="span2" id="appendedInputButtons" size="12" type="text"><button class="btn" type="button">搜索</button>
              </div>
    </ul>
</div>

<div class="es_stations_choose">
  <ul>
    <li>
    城市地区: 
        <a href="<?= h_list_page_get_str($current_con,"city_id",0);?>" class="btn btn-mini <?= ($this->input->get("city_id") == 0)?"btn-primary":""; ?>">全部</a> 
    <?foreach($cities as $city){?>
        <a href="<?= h_list_page_get_str($current_con,"city_id",$city->getId());?>" class="btn btn-mini <?= ($this->input->get("city_id") == $city->getId())?"btn-primary":""; ?>">
            <?= $city->getNameChn(); ?>
        </a> 
    <?}?>
    </li>
    <li>
    负载等级: 
        <a href="<?= h_list_page_get_str($current_con,"total_load",0);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 0)?"btn-primary":""; ?>">全部</a> 
        <a href="<?= h_list_page_get_str($current_con,"total_load",1);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 1)?"btn-primary":""; ?>">20A-30A</a> 
        <a href="<?= h_list_page_get_str($current_con,"total_load",2);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 2)?"btn-primary":""; ?>">30A-40A</a> 
        <a href="<?= h_list_page_get_str($current_con,"total_load",3);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 3)?"btn-primary":""; ?>">40A-50A</a> 
        <a href="<?= h_list_page_get_str($current_con,"total_load",4);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 4)?"btn-primary":""; ?>">50A-60A</a> 
        <a href="<?= h_list_page_get_str($current_con,"total_load",5);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 5)?"btn-primary":""; ?>">60A-70A</a> 
        <a href="<?= h_list_page_get_str($current_con,"total_load",6);?>" class="btn btn-mini <?= ($this->input->get("total_load") == 6)?"btn-primary":""; ?>">70A+</a> 
    </li>
  </ul>
  <ul>
    <li>
    建筑材料: 
        <a href="<?= h_list_page_get_str($current_con,"building",0);?>" class="btn btn-mini <?= ($this->input->get("building") == 0)?"btn-primary":""; ?>">全部</a> 
        <a href="<?= h_list_page_get_str($current_con,"building",1);?>" class="btn btn-mini <?= ($this->input->get("building") == 1)?"btn-primary":""; ?>">砖墙</a> 
        <a href="<?= h_list_page_get_str($current_con,"building",2);?>" class="btn btn-mini <?= ($this->input->get("building") == 2)?"btn-primary":""; ?>">彩钢板</a> 
    </li>
    <li>
    站点类型: 
        <a href="<?= h_list_page_get_str($current_con,"station_type",0);?>" class="btn btn-mini <?= ($this->input->get("station_type") == 0)?"btn-primary":""; ?>">全部</a> 
        <a href="<?= h_list_page_get_str($current_con,"station_type",1);?>" class="btn btn-mini <?= ($this->input->get("station_type") == 1)?"btn-primary":""; ?>">标杆站</a> 
        <a href="<?= h_list_page_get_str($current_con,"station_type",2);?>" class="btn btn-mini <?= ($this->input->get("station_type") == 2)?"btn-primary":""; ?>">基准站</a> 
        <a href="<?= h_list_page_get_str($current_con,"station_type",3);?>" class="btn btn-mini <?= ($this->input->get("station_type") == 3)?"btn-primary":""; ?>">6+1站</a> 
        <a href="<?= h_list_page_get_str($current_con,"station_type",4);?>" class="btn btn-mini <?= ($this->input->get("station_type") == 4)?"btn-primary":""; ?>">节能站</a> 
    </li>
  </ul>
</div>

<div style="clear:both;width:100%;height:10px;overflow:hidden">
</div>
</div>







