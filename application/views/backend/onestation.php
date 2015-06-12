<table class="sta_table" cellpadding="3" cellspacing="0" align="center">
<a name="reset_<?= $station['id']?>"></a>
<tr>
    <th <?= ($station['status'] == ESC_STATION_STATUS_REMOVE)?"style='background-color:#333'":""?> colspan=16> 
        <input type="checkbox" name="station_ids[]" value="<?= $station['id']?>" /> 
        <?= $station['name_chn'];?>
        <? if($station['status'] == ESC_STATION_STATUS_REMOVE){?>
            &nbsp;&nbsp;
            <b>======= 本站已拆除 =======</b>
        <?}else{?>
            <?= $station['frontend_visible'] == ESC_FRONTEND_UNVISIBLE?"<font color=red>(隐藏)</font>":"" ?>    
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            (<?= h_autocheck_report_trans($station['autocheck_report']) ?>)
            &nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/setup/home/station/<?= $station['id']?>" style="color:#fff;font-weight:normal;" target='_blank'> >> 跳到基站安装 </a> 
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/frontend/single/day/<?= $station['id']?>" style="color:#fff;font-weight:normal" target='_blank'> >> 跳到前端 </a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="http://gk.semos-cloud.com:2002/patrol/index?station_id=<?= $station['id']?>" style="color:#fff;font-weight:normal"  target='_blank'> >> 跳到巡检 </a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="http://api.map.baidu.com/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= $station["name_chn"]?>&output=html" 
               style="color:#fff;font-weight:normal" target="_blank"> >> 查看地图详情 </a>
        <?}?>
    </th>
</tr>

<? if(count($station['bugs']) > 0){ ?>
    <tr>
        <td colspan="16" style="background-color:#600">
        <? foreach($station['bugs'] as $bug){?>
            <font style="color:#fff"> <?= h_bug_type_name_chn($bug['type'])?> </font> &nbsp;&nbsp;&nbsp;&nbsp;
        <?}?>

        </td>
    </tr>
<?}?>

<tr>
    <td style="width:30px;"><b>当前</b></td>
    <td style="width:50px;">
        <?= $station['alive'] == ESC_ONLINE? 
        "<font color=green>在线</font>":
        "<font color=red><b>不在线</b></font>" ?>  
    </td>
    <td style="width:35px;"><b>ESG</b></td>
    <td style="width:80px;">
        <?= $station['esg'] ? $station['esg']['id']:"<font color=#f00><b>无ESG</b></font>"?>  
    </td>
    <td style="width:30px;"><b>城市</b></td>
    <td style="width:50px;">
        <?= $station['city']['name_chn'] ?> 
    </td>
    <td style="width:40px;"><b>区县</b></td>
    <td style="width:50px;">
        <?=$station['district']?$station['district']['name_chn']:''?> 
    </td>
    <td style="width:40px;"><b>负载</b> </td>
    <td style="width:80px;">
        (<b><?= $station['load_num']?></b>)&nbsp; 
        <?= h_station_total_load_name_chn($station['total_load'])?>    
    </td>
    <td style="width:40px;"><b>建筑</b> </td>
    <td style="width:40px;">
        <?= h_station_building_name_chn($station['building'])?> 
    </td>
    <td style="width:30px;"><b>风机</b> </td>
    <td style="width:70px;"> <?= $station['air_volume'] == ESC_STATION_VOLUME_NONE?"<font color=red><b>无</b></font>" :h_station_air_volume_name_chn($station['air_volume'])?></td>
    
    <td style="width:30px;"><b>ROM</b> </td>
    <td><?= $station['rom']['version'] ?></td>
</tr>
<tr>
    <td><b>督导</b></td>
    <td> <?= $station['creator'] ?$station['creator']['name_chn'] :"无记录"?> </td>
    <td><b>SIM卡</b></td>
    <td> <?= $station['sim_num'] ?> </td>
    <td><b></b></td>
    <td> 
        <!--<?= $station['force_on']==ESC_STATION_FORCE_ONOFF?"<font color=red><b>是</b></font>":"否"?>--> 
    </td>
    <td><b>恒温柜</b></td>
    <td> 
        <?= ($station['have_box']==ESC_HAVE_BOX)?
        h_station_box_type_name_chn($station['box_type']):
        "<font color=red>无</font>"?> 
    </td>
    <td><b>外温感</b></td>
    <td> <?= $station['equip_with_outdoor_sensor']==ESC_BEINGLESS?"<font color=red><b>无</b></font>":"有"?> </td>
    <td><b>类型</b></td>
    <td> <?= h_station_station_type_name_chn($station['station_type'])?> </td>
    <td><b>>></b></td>
    <? if($station['station_type'] == ESC_STATION_TYPE_NPLUSONE){?>
        <td colspan=4> (n=<?= $station['ns']?>) <?= $station['ns']?$station['ns_start']:""?></td>
    <?}elseif($station['station_type'] == ESC_STATION_TYPE_COMMON || 
                    $station['station_type'] == ESC_STATION_TYPE_SAVING){?>
        <td colspan=4> 
            对比站: <?=($s = $this->station->find_sql($station['standard_station_id']))?$s['name_chn']:"随机"?>
        </td>
    <?}elseif($station['station_type'] == ESC_STATION_TYPE_STANDARD){?>
        <td colspan=4> 
        </td>
    <?}?>
</tr>
<tr>
    <td style="width:30px;"><b>空调</b> </td>
    <td style="width:20px;"> <?= $station['colds_num']?>台 </td>
    <td>
        <b> 电价 </b>
    </td>
    <td>
        <?= $station['price']?>
    </td>
    <td><b>项目</b></td>
    <td colspan="3">  
        <?= $station['project']['name_chn']?>
    </td>
    <td><b>分期</b></td>
    <td colspan="3">  
        <?= $station['batch']?$station['batch']['name_chn']:"无"?>
    </td>
    <td><b>无线模块</b></td>
    <td><?= h_3g_module_name($station['3g_module']) ?></td>
    <td><b>验收名</b></td>
    <td><?=$station['change_name_chn']?></td>
</tr>

<tr>
    <td><b>地址</b></td>
    <td colspan=5>  
        <?if($this->current_os === ESC_OS_ANDROID) {?>
        <a href="bdapp://map/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= trim($station["name_chn"])?>&src=abc.com|location"
           title="<?= $station['address_chn']?>" target="_blank"><?= mb_substr($station['address_chn'],0,15)?>
        </a>      
        <?}elseif($this->current_os === ESC_OS_IOS){?>
        <a href="baidumap://map/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= trim($station["name_chn"])?>&src=abs.com|ioslocation"
           title="<?= $station['address_chn']?>" target="_blank"><?= mb_substr($station['address_chn'],0,15)?>
        </a>      
        <?}else{?>
        <a href="http://api.map.baidu.com/marker?location=<?= trim($station["lat"])?>,<?= trim($station["lng"])?>&coord_type=wgs84&zoom=15&title=基站位置&content=<?= $station["name_chn"]?>&output=html" 
               title="<?= $station['address_chn']?>" target="_blank"> <?= mb_substr($station['address_chn'],0,15)?>
        </a>
        <?}?>      
    </td>
    <td><b>备注</b></td>
    <td colspan=5>  
        <a href='#' title="<?= $station['comment']?>"><?= mb_substr($station['comment'],0,15)?></a>       
    </td>
    <td><b>设置锁定</b></td>
      <td> <?= $station['setting_lock']==ESC_STATION_SETTING_LOCK?"<font color=red><b>是</b></font>":"否"?> </td>
    <td><b>建站</b></td>
    <td colspan=1>  
        <?= $station['create_time']?h_dt_format($station['create_time'],"Y-m-d"):"无"?>
    </td>
</tr>
<tr>
    <td><b>操作</b></td>
    <td colspan=15 style="text-align:left"> 
        <a class="btn btn-primary btn-mini" href="/backend/data?station_id=<?= $station['id']?>"> 
            数据 
        </a>
        <a class="btn btn-primary btn-mini" href="/backend/energy?station_id=<?= $station['id']?>"> 
            能耗 
        </a>
        <a class="btn btn-inverse btn-mini" href="/backend/command?station_id=<?= $station['id']?>"> 
            命令 
        </a>
        <a class="btn btn-inverse btn-mini" href="/backend/bug?station_id=<?= $station['id']?>"> 
            故障 
        </a>
        <a class="btn btn-inverse btn-mini" href="/backend/autocheck?station_id=<?= $station['id']?>"> 
            自检 
        </a>
        <a class="btn btn-inverse btn-mini" 
            href="/backend/restart?station_id=<?= $station['id']?>&backurl=<?= $backurlstr?>"> 
            重启 
        </a>
        <a class="btn btn-inverse btn-mini" href="/backend/correct?station_id=<?= $station['id']?>"> 
            同步电表 
        </a>
        <a class="btn btn-inverse btn-mini" 
            href="/backend/blog/index?station_id=<?= $station['id']?>"> 
            维护日志
        </a>
        <a class="btn btn-inverse btn-mini" 
            href="/backend/esgfix/index?station_id=<?= $station['id']?>"> 
            维修
        </a>
        <a class="btn btn-inverse btn-mini" 
            href="/backend/station/mod_station/<?= $station['id']?>?backurl=<?= $backurlstr?>">
            修改属性
        </a>
        <a class="btn btn-inverse btn-mini" 
            href="/backend/station/station_log/1?station_id=<?=$station['id']?>">
            修改记录
        </a>
         &nbsp; 

        <a class="btn btn-inverse btn-mini" 
           href="/backend/esgconf/set_setting/<?= $station['id']?>?backurl=<?= $backurlstr?>">
           站点设置
        </a>
        <a class="btn btn-inverse btn-mini" 
           href="/backend/property/read/<?= $station['id']?>?backurl=<?= $backurlstr?>">
           读取属性
        </a>
        <? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)){ ?>
        <a class="btn btn-inverse btn-mini" 
           href="/backend/rom_update/single?station_id=<?= $station['id']?>&backurl=<?= $backurlstr?>"> 
           更新固件 
        </a>
        <?}?>
        <? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)){ ?>
        <a class="btn btn-mini" href="#" 
            onclick="confirm_jumping('删除 <?= $station['name_chn']?> 基站','/backend/station/del_station/<?= $station['id']?>?backurl=<?= $backurlstr?>')">删除</a>
        <?}?>
        <a class='btn btn-mini' href="#"
            onclick="confirm_jumping('强制重启 <?= $station['name_chn']?> 的ESG','/backend/station/force_reboot/<?= $station['id']?>?backurl=<?= $backurlstr?>')">强制重启</a> 
        <a class='btn btn-mini' href="#"
            onclick="confirm_jumping('远程打开 <?= $station['name_chn']?> 的ESG','/backend/station/remote_on/<?= $station['id']?>?backurl=<?= $backurlstr?>')">远程开</a> 
    </td>
</tr>
<tr>
    <td><b>设置</b></td>
    <td colspan=15>
        [S17]系统模式:<b><?= $station['esgconf']['sys_mode']?> </b>
        &nbsp;&nbsp;&nbsp;&nbsp;
        [S18]简单控制:<b><?= $station['esgconf']['simple_control']?></b>
    </td>
</tr>
<tr style="background-color:#dfd">
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



<? if($station['current_rom_update']){?>
<? $current_rom_update = $station['current_rom_update'];?>

<style>
    .ur_all{float:left;width:985px;border:1px solid #666;}
    .ur_head{float:left;width:100%;height:25px;padding:0;margin:0;}
    .ur_body{float:left;width:100%;height:32px;padding:0;margin:0;background-color:#6c6}
    .ur_all ul{float:left;height:25px;line-height:25px;padding:2px 12px;margin:0;}
    .ur_head ul.active{float:left;background-color:#8d8;font-weight:bold}
    .ur_body ul{float:left;height:32px;line-height:32px;}
</style>

<tr> <td colspan=18 style="background-color:#fff;padding:5px">
<div class='ur_all'>
    <div class='ur_head'>
        <ul class="">
            <li class="icon icon-ok"></li>
            开始更新rom &nbsp; <b style="font-size:15px"><?= $current_rom_update['new_rom']['version']?></b>
        </ul>
        <ul class="<?= (1==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(1,$current_rom_update['status'])?>
            已发送更新请求 
        </ul>
        <ul class="<?= (2==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(2,$current_rom_update['status'])?>
            正在更新中
        </ul>
        <ul class="<?= (3==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(3,$current_rom_update['status'])?>
            等待测试结果
        </ul>
        <ul class="<?= (4==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(4,$current_rom_update['status'])?>
            已发送确认
        </ul>
        <ul>
            <a href="/backend/rom_update/reset_update_rom?station_id=<?= $station['id']?>"> 
                手动强制结束本次更新(有问题的话) 
            </a>
        </ul>
    </div>

    <div class='ur_body'>
    <ul>
        花去时间 [<?= h_last_time($current_rom_update['start_time'])?>]
    </ul>

    <?if($current_rom_update['status'] == 1):?>
        <ul>
        即将更新固件：<?= $current_rom_update['new_rom']['version']?>
        等待ESG智能网关接受命令... (此过程1到2分钟)
        </ul>
    <? endif ?>


    <?if($current_rom_update['status'] == 2){?>
        <ul>
            更新 <?= $current_rom_update['new_rom']['version'] ?>
            固件进度：<?= $current_rom_update['update_percent']?> %
        </ul>
        <ul style="padding-top:8px">
            <div class="progress progress-striped active" style="width:420px">
            <div class="bar" style="width:<?= $current_rom_update['update_percent']?>%;"></div>
            </div>
        </ul>
    <?}?>

    <?if($current_rom_update['status'] == 3){?>
        <ul>
            确认固件：<?= $current_rom_update['new_rom']['version'] ?>
            请在20分钟时间内确认 若确定正常工作 请按确认更新按钮 此过程会自动执行 手欠也可以
            <a href="/backend/rom_update/urcsent_update_rom?station_id=<?= $station['id']?>"> >>> 手动确认更新 </a>
             
        </ul>
    <?}?>

    <?if($current_rom_update['status'] == 4){?>
        <ul>
            已发出确认消息 确认urc已被开发版执行 即可关闭 此过程会自动执行 手欠也可以
            <a href="/backend/rom_update/confirm_update_rom?station_id=<?= $station['id']?>"> >>> 手动确认关闭 </a>
        </ul>
    <?}?>

    </div>
    <div style='clear:both'> </div>
</div>
</td> </tr>

<?}?>




</table>




