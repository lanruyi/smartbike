
<?
/********************************
Fast JJump 

********************************/
?>

<style>
    .single_sta_list{float:left;cursor:pointer;margin-top:10px;}
    .single_sta_list ul{overflow:hidden; margin:0; padding:0 0 16px 0; list-style:none;}
    .single_sta_list ul li{margin:2px 0 0 0;padding:0 0 0 0; 
                    height:18px;line-height:18px; list-style:none;color:white;}
    .single_sta_list ul li a{ color:white;}
    .single_sta_list ul li a:hover{ color:#66dd88;}
    .single_sta_list ul li .active{ font-weight:bold }
    .list_title_active {list-style:none;margin:5px 0;font-weight:bold}
    .list_title_inactive {list-style:none;margin:5px 0;color:#222}
    .list_category_inactive{display:none;}
    .list_title_click{list-style:none;}

    .chart_title{clear:both;padding:2px 25px 2px 8px;
            margin:35px 0 0px 0;color:#333;background-color:#fff;
            border-top:1px solid #999;width:990;height:22px;}
    .chart_title ul{float:left;color:#333; padding:2px 0;margin:0;text-align:center}
    .chart_title ul.active{background-color:#678;width:36px;margin:0 5px;}
    .chart_title ul.normal{background-color:#fff;width:36px;margin:0 5px;}
    .chart_title ul.active a{color:#fff;}
    .chart_title ul.normal a{color:#333;}
    .chart_title ul a{color:#333;}


    .station_all {height:64px;clear:both;margin:10px 0;}

    .stations_tool {float:left;margin:0;}
    .stations_tool ul li{float:left}
    .stations_tool ul li.back{width:64px;height:64px;background-color:#ccc;}
    .stations_tool ul li.middle{width:10px;height:50px;background-color:#eee;margin:0 0 0 2px}

    .add_note{display:none;margin-top:10px;}
    .add_note textarea{float:left;width:70%;height:50px;margin-right:10px;}
    .add_note ul li{float:left;height:25px;}
    .notes_list{margin-top:20px;}
    .notes_list ul li{list-style:none;}
    .notes_list table th{font-size:12px;}
    .note_title span{background-color:red;color:white;font-weight:bold;}

    .es_time_bar {clear:both;width:100%;height:28px; margin:10px 0 0 0;}
    .es_time_bar ul li{float:left;padding:4px 6px;}
    .es_time_bar ul li.right{float:right;}
    .es_time_bar ul li a{color:#000}
    .es_time_bar ul li.active a{color:#000;font-weight:bold}
    .es_time_bar ul li.active{background-color:#ddd;}


    .es_single_menu {clear:both;width:998px;height:25px;background-color:#eee;border:1px solid #999; margin:10px 0 0 0;border-bottom:1px solid #999}
    .es_single_menu ul li{float:left;padding:3px 6px 2px 6px;margin-top:2px;}
    .es_single_menu ul li.station_name{width:180px;text-align:left;font-size:14px;font-weight:bold;}
    .es_single_menu ul li.right{float:right;}
    .es_single_menu ul li a{color:#000}
    .es_single_menu ul li.active a{color:#000;font-weight:bold}
    .es_single_menu ul li.active{background-color:#fff;border-right:1px solid #999;border-left:1px solid #999;border-top:1px solid #999;}

    .single_station {float:left;width:998px;margin:10px 0 2px 0;background-color:#eee;border:1px solid #ccc;height:60px}
    .single_station ul li.station{border-bottom:1px solid #999;width:966px;padding:4px;margin:2px 0 0 10px;text-align:left;height:20px;overflow:hidden}
    .single_station ul li.station font.title{font-size:16px;font-weight:bold;}
    .single_station ul li.station font.else{font-size:12px;line-height:28px;}
    .single_station ul li.info{width:966px;height:20px;padding:0 0 0 4px;margin:4px 0 0 10px;text-align:left}
    .single_station ul li.name{font-size:16px;}

    .tool_menu {float:left;margin:10px 0 2px 0;background-color:#eee;border:1px solid #ccc;height:24px}
    .tool_menu ul li{float:left;}
    .tool_menu ul li.back{}
    .tool_menu ul li.back a{display:block;margin:3px 0 0 8px;background-image:url('/static/site/img/arrow_left.png');width:18px;height:18px;}

</style>


<div class="base_center">

        <div style="clear:both;height:1px;overflow:hidden"></div>
        <div class='es_single_menu' style="margin-bottom:2px;">  
            <ul>
              <li style="width:2px;">
              </li>
              <li > 
                <a  href="<?= h_project_url("station_list",$this->current_project['type'])?>" > << <?=$this->lang->line("Go to station list")?> </a> </li>
              <li class="divider-vertical"></li>
              <li class="<?= $this->uri->rsegment(2) == "day"?"active":"" ?>"> 
                <a  href="/frontend/single/day/<?=  $station['id'] ?>"> <?=$this->lang->line("Daily energy saving")?> </a> </li>
              <li class="divider-vertical"></li>
              <li class="<?= $this->uri->rsegment(2) == "month"?"active":"" ?>"> 
                <a  href="/frontend/single/month/<?=  $station['id'] ?>"> <?=$this->lang->line("Monthly energy saving")?> </a> </li>
              <li class="divider-vertical"></li>
              <li style="display:none" class="<?= $this->uri->rsegment(2) == "maintenance"?"active":"" ?>"> 
                <a  href="/frontend/single/maintenance/<?= $station['id'] ?> "> <?=$this->lang->line("Log")?> </a> </li>  
              <li class="divider-vertical"></li>       
              <li style="display:none" class="<?= $this->uri->rsegment(2) == "note"?"active":"" ?>"> 
                <a  href="/frontend/single/note/<?= $station['id'] ?> "> <?=$this->lang->line("Notes")?>  </a> </li>                        
              <li class="divider-vertical"></li>
              <li style="display:none" class="<?= $this->uri->rsegment(2) == "month_statistics"?"active":"" ?>"> 
                <a  href="/frontend/single/month_statistics/<?= $station['id'] ?> "> <?=$this->lang->line("Monthly statistics")?> </a> </li>
            </ul>
        </div>
        <div style="clear:both;height:1px;overflow:hidden"></div>
        <div class='single_station'>
            <ul>
              <li class='station'>
                    <font class='title'><?= $station['name_chn'] ?></font>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="http://api.map.baidu.com/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= $station["name_chn"]?>&output=html" 
               style="font-weight:bold" target="_blank"> >> 基站定位 </a>
              </li> 
              <li class='info'> 
                    <?=$this->lang->line("city")?> <?= $city['name_chn'] ?> |
                    <?=$this->lang->line("load")?> <?= $station['load_num']."A"?> |
                    <?=$this->lang->line("build")?> <?= h_station_building_name_chn($station['building'])?> |
                    <?= ($station['have_box']==ESC_BEINGLESS)?h_station_box_type_name_chn($station['box_type']):"<font color=red>无</font>"?><?=$this->lang->line("TLKS-BCT")?>  |
                    <?=$this->lang->line("Air-condition")?> <?= $station['colds_num']?>台 |

                    本站为:<?= h_fake_jizhu_to_biaogan($station['station_type'],$this->current_project['id'])?>

                   <?if(ESC_STATION_TYPE_NPLUSONE == $station['station_type']){?>
                       | <?= $station['ns']?>天节能 1天不节能 
                   <?}?>
                       <font style="float:right">
                            <?=$this->lang->line("Founded in")?> <?= $station['create_time']?>
                        </font>
              </li> 
            </ul>
        </div>
        <div style="clear:both;height:1px;overflow:hidden"></div>

</div>

<script src="/static/hicharts/highcharts.js"></script>

      
