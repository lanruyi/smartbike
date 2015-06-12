
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
            margin:15px 0 0px 0;color:#333;background-color:#fff;
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
    .sta_table tr td{padding: 6px 6px;}
</style>

<div class="base_center">
    <div style="clear:both;height:10px;overflow:hidden"></div>
<table class="sta_table" cellpadding="3" cellspacing="0" align="center">
<a name="reset_<?= $station['id']?>"></a>
<tr>
    <th <?= ($station['status'] == ESC_STATION_STATUS_REMOVE)?"style='background-color:#333'":""?> colspan=16> 
        <input type="checkbox" name="station_ids[]" value="<?= $station['id']?>" /> 
        <?= $station['name_chn'];?>
        <? if($station['status'] == ESC_STATION_STATUS_REMOVE){?>
            &nbsp;&nbsp;
            <b>======= 本站已拆除 =======</b>
        <?}?>
    </th>
</tr>
<? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__FRONTEND_DETAIL)){ ?>
    <? if(count($station['bugs']) > 0){ ?>
        <tr>
            <td colspan="16" style="background-color:#600">
            <? foreach($station['bugs'] as $bug){?>
                <font style="color:#fff"> <?= h_bug_type_name_chn($bug['type'])?> </font> &nbsp;&nbsp;&nbsp;&nbsp;
            <?}?>

            </td>
        </tr>
    <?}?>
<?}?>

<tr>
    <td style="width:30px;"><b>当前</b></td>
    <td style="width:50px;">
        <?= $station['alive'] == ESC_ONLINE? 
        "<font color=green>在线</font>":
        "<font color=red><b>不在线</b></font>" ?>  
    </td>
    <td><b>项目</b></td>
    <td style="width:80px;">  
        <?= $station['project']['name_chn']?>
    </td>
    <td><b>分期</b></td>
    <td colspan="3">  
        <?= $station['batch']?$station['batch']['name_chn']:"无"?>
    </td>
    <td><b>城市</b></td>
    <td style="width:50px;">
        <?= $station['city']['name_chn'] ?> 
    </td>
    <td style="width:40px;"><b>区县</b></td>
    <td style="width:50px;">
        <?=$station['district']?$station['district']['name_chn']:''?> 
    </td>
    <td style="width:50px;"><b>负载(A)</b> </td>
    <td style="width:50px;">
        <b><?= $station['load_num']?></b> 
    </td>
    <td style="width:40px;"><b>建筑</b> </td>
    <td style="width:40px;">
        <?= h_station_building_name_chn($station['building'])?> 
    </td>
</tr>
<tr>
    <td>
        <b> 电价 </b>
    </td>
    <td>
        <?= $station['price']?>
    </td>
    <td><b>SIM卡</b></td>
    <td> <?= $station['sim_num'] ?> </td>
    <td style="width:30px;"><b>风机</b> </td>
    <td style="width:70px;"> <?= $station['air_volume'] == ESC_STATION_VOLUME_NONE?"<font color=red><b>无</b></font>" :h_station_air_volume_name_chn($station['air_volume'])?></td>
    
    <td style="width:50px;"><b>恒温柜</b></td>
    <td> 
        <?= ($station['have_box']==ESC_HAVE_BOX)?
        h_station_box_type_name_chn($station['box_type']):
        "<font color=red>无</font>"?> 
    </td>
    <td><b> 室外温感</b></td>
    <td> <?= $station['equip_with_outdoor_sensor']==ESC_BEINGLESS?"<font color=red><b>无</b></font>":"有"?> </td>
    <td><b>类型</b></td>
    <td> <?= h_station_station_type_name_chn($station['station_type'])?> </td>
    <td><b>对比站</b></td>
    <? if($station['station_type'] == ESC_STATION_TYPE_NPLUSONE){?>
        <td colspan=4> (n=<?= $station['ns']?>) <?= $station['ns']?$station['ns_start']:""?></td>
    <?}elseif($station['station_type'] == ESC_STATION_TYPE_COMMON || 
                    $station['station_type'] == ESC_STATION_TYPE_SAVING){?>
        <td colspan=4> 
             <?=($s = $this->station->find_sql($station['standard_station_id']))?$s['name_chn']:""?>
        </td>
    <?}elseif($station['station_type'] == ESC_STATION_TYPE_STANDARD){?>
        <td colspan=4> 
        </td>
    <?}?>
    
</tr>
<tr>
    <td style="width:30px;"><b>空调</b> </td>
    <td style="width:20px;"> <?= $station['colds_num']?>台 </td>
    <td style="width:35px;"><b>ESG</b></td>
    <td style="width:80px;">
        <?= $station['esg'] ? $station['esg']['id']:"<font color=#f00><b>无ESG</b></font>"?>  
    </td>
    <td><b>地址</b></td>
    <td colspan=5>  
        <a href="#"><?= mb_substr($station['address_chn'],0,15)?> </a>   
    </td>
    <td><b>建站</b></td>
    <td style="width:80px;">  
        <?= $station['create_time']?h_dt_format($station['create_time'],"Y-m-d"):"无"?>
    </td>

    <td style="width:50px;"><b>验收名</b> </td>
    <td colspan="3"><?=$station['change_name_chn']?> </td>
</tr>

<tr>
    <td><b>操作</b></td>
    <td colspan=15 style="text-align:left">
        <a class="btn btn-primary btn-mini" href="/frontend/single/day/<?= $station['id']?>"> 
            图表显示
        </a>
        <a class="btn btn-primary btn-mini" href="/frontend/single/data?station_id=<?= $station['id']?>"> 
            原始数据 
        </a>
        
        <? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__FRONTEND_DETAIL)){ ?>
            <a class="btn btn-primary btn-mini" href="/frontend/single/energy?station_id=<?= $station['id']?>"> 
                能耗统计 
            </a>
            <a class="btn btn-inverse btn-mini" href="/frontend/single/command/1?station_id=<?= $station['id']?>" style="display:none"> 
                命令历史 
            </a>
            <a class="btn btn-inverse btn-mini" href="/frontend/single/bug?station_id=<?= $station['id']?>"> 
                告警历史
            </a>
            <a class="btn btn-inverse btn-mini" 
                href="/frontend/single/sync_meter?station_id=<?= $station['id']?>"> 
                电表同步
            </a>
            <a class="btn btn-inverse btn-mini" 
                href="/frontend/single/blog?station_id=<?= $station['id']?>"> 
                维护日志
            </a>
            <a class="btn btn-inverse btn-mini" 
               href="/frontend/single/mod_station?station_id=<?= $station['id']?>" style="display:none">
                修改属性
            </a>
            <a class="btn btn-inverse btn-mini" 
                href="/frontend/single/station_log/1?station_id=<?=$station['id']?>">
                修改记录
            </a>
             &nbsp; 

            <a class="btn btn-inverse btn-mini" 
               href="/backend/esgconf/set_setting/<?= $station['id']?>?backurl=<?= $backurlstr?>" style="display:none">
               站点设置
            </a>
            <a class="btn btn-inverse btn-mini" 
               href="/backend/property/read/<?= $station['id']?>?backurl=<?= $backurlstr?>" style="display:none">
               读取属性
            </a>

            <a class='btn btn-mini' href="#"
                onclick="confirm_jumping('强制重启 <?= $station['name_chn']?> 的ESG','/backend/station/force_reboot/<?= $station['id']?>?backurl=<?= $backurlstr?>')" style="display:none">强制重启</a> 
            <a class='btn btn-mini' href="#"
                onclick="confirm_jumping('远程打开 <?= $station['name_chn']?> 的ESG','/backend/station/remote_on/<?= $station['id']?>?backurl=<?= $backurlstr?>')" style="display:none">远程开</a> 
             <?if($this->current_os === ESC_OS_ANDROID) {?>
                <a class="btn btn-inverse btn-mini" href="bdapp://map/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= trim($station["name_chn"])?>&src=abc.com|location"
                title="<?= $station['address_chn']?>" target="_blank"> 基站定位 
                </a>      
            <?}elseif($this->current_os === ESC_OS_IOS){?>
                <a class="btn btn-inverse btn-mini" href="baidumap://map/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= trim($station["name_chn"])?>&src=abs.com|ioslocation"
                title="<?= $station['address_chn']?>" target="_blank"> 基站定位 
                </a>      
            <?}else{?>
                <a class="btn btn-inverse btn-mini" href="http://api.map.baidu.com/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= $station["name_chn"]?>&output=html" 
                title="<?= $station['address_chn']?>" target="_blank"> 基站定位 
                </a>
            <?}?>   
        <?}?>
    </td>
</tr>
<tr>

</tr>
<tr style="background-color:#dfd; display: none">
    <td colspan=2><b>新风逻辑 </b> <font color=red>*</font></td>
    <td colspan=14>
    <?
            $esgconf   = $station['esgconf'];
            $fan_on_t  = $esgconf['ch_tmp']-2-2*$esgconf['cd_tmp']+$esgconf['temp_adjust_factor'];
            $fan_off_t = $fan_on_t-2+$esgconf['all_close_temp'];
            $cold_0_on_t = $esgconf['ch_tmp'];
            $cold_1_on_t = $esgconf['ch_tmp'] + $esgconf['cd_tmp']+$esgconf['temp_adjust_factor'] - 0.3;
            $cold_off_t  = $esgconf['ch_tmp'] - $esgconf['colds_onoff_distance']; 
    ?>

    <a href="javascript:void(0)" title="空调1启动温度-2-2*步进量+新风启动补偿因子">新风开温度</a> 
    : <b><?= $fan_on_t?></b>   
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0)" title="t新风开-2+设备全关补偿因子">新风关温度</a>  
    : <b><?= $fan_off_t?></b>   
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0)" title="空调1启动温度">空调1开温度</a>  
    : <b><?= $cold_0_on_t?></b>  
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0)" title="空调1启动温度+步进量+新风启动补偿因子-0.25">空调2开</a>  
    : <b><?= $cold_1_on_t?></b>  
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0)" title="空调1启动温度-空调开关温差">空调关</a>  
    : <b><?= $cold_off_t?></b>  
    &nbsp;&nbsp;&nbsp;&nbsp;
    </td>
</tr>

</table>

</div>




<script src="/static/hicharts/highcharts.js"></script>

      
