<style type="text/css">
.load_level_building{ float:left;width:132px;margin:0 0 0 10px;border:1px solid #369;color:#369;background-color:#ace}
.first{margin:0px;}
.load_level_building ul h3{text-align:center;margin:2px 0}
.load_level_building ul h3.active{font-size:14px;font-weight:bold;color:#000;}
.load_level_building ul li{color:#000;width:126px;margin:3px;background-color:#69c;}
.load_level_building ul li a{display:block;color:#000;padding:1px 3px}
.load_level_building ul li a:hover {background-color:#036;color:#fff;}
.load_level_building ul li.active a{background-color:#036;color:#fff;}
    
    .es_cc{}
    .es_cc tr td{text-align:right;}
    .cc_head{width:980px;background-color:#ccc;}
    .es_cc td.station_pos{width:180px;padding:0 0 0 24px;text-align:left; height:26px;line-height:26px;}
    .big_num{font-size:12px;font-weight:bold;color:#666}
    .big_num_ggh{font-size:13px;font-weight:bold;color:#69c}

    .station_type_head{float:left;text-align:left;width:980px;margin:5px 0;padding:2px 8px;color:#fff;background-color:#369;}
</style>



<div class='base_center'>

    <div style='clear:both;height:10px'>  </div>
    <div style='clear:both;height:24px;line-height:24px;padding:0 8px;width:980px;border:1px solid #c96'>  
        说明:  <b>平均</b>：指平均到每天的能耗 &nbsp; <b>规格化</b>：在每天能耗的基础上按基站负载折算
    </div>
    <div style='clear:both;height:6px'>  </div>
    <div style='clear:both;height:24px;line-height:24px;padding:0 8px;width:980px;border:1px solid #c96'>  
        相关信息:  该城市上个月平均温度为 C  这个月平均温度为 C 昨日平均温度为 C
    </div>


    <!------------------------------------- 此处开始菜单 ---------------------------------------->
    <div style="margin:8px 0 0 0">
    <? foreach (h_station_total_load_array() as $_load_level => $level_name){?>
    <div class="load_level_building <?= $_load_level == 1?"first":""?>">
            <ul>
                <h3 class='<?= $load_level == $_load_level?"active":""?>'> <?= $level_name?> </h3>
                <li class='<?= $load_level == $_load_level && $building == 1?"active":""?>'>
                    <a href="/frontend/stations/newlist?load_level=<?= $_load_level?>&building=1">
                    <? $_nums = $station_nums[$_load_level][ESC_BUILDING_ZHUAN]?>
                    砖墙 &nbsp;(<?= $_nums[ESC_STATION_TYPE_STANDARD]?>
                    + <?= $_nums[ESC_STATION_TYPE_SAVING]?>
                    + <?= $_nums[ESC_STATION_TYPE_COMMON]?>)
                    </a>
                </li>
                <li class='<?= $load_level == $_load_level && $building == 2?"active":""?>'>
                    <a href="/frontend/stations/newlist?load_level=<?= $_load_level?>&building=2">
                    <? $_nums = $station_nums[$_load_level][ESC_BUILDING_BAN]?>
                    板房 &nbsp;(<?= $_nums[ESC_STATION_TYPE_STANDARD]?>
                    + <?= $_nums[ESC_STATION_TYPE_SAVING]?>
                    + <?= $_nums[ESC_STATION_TYPE_COMMON]?>)
                    </a> 
                </li>
            </ul>
        </div>
    <?}?>
    </div>

    <div style='clear:both;height:10px'>  </div>


    <!------------------------------------- 此处开始展示基站列表 ---------------------------------------->
    <table class=es_cc>
    <tr class="cc_head">
        <td class=station_pos> 基站名 </td>
        <td> </td>
        <td> 当前状态&nbsp;&nbsp;(内/外/恒/风/空1/空2)</td>
        <td> </td>
        <td> 负载&nbsp;/&nbsp;空调&nbsp;/&nbsp;恒温柜</td>
        <td> </td>
        <td> 上月能耗&nbsp;/&nbsp;平均&nbsp;/&nbsp;规格化 </td>
        <td> 本月能耗&nbsp;/&nbsp;平均&nbsp;/&nbsp;规格化 </td>
        <td> 昨日能耗&nbsp;/&nbsp;规格化  </td>
        <td> </td>
    </tr>
    <tr>
        <td colspan=12>
            <div class='station_type_head'> 
                基准站&nbsp;(<?= $station_nums[$load_level][$building][ESC_STATION_TYPE_STANDARD]?>) 
            </div>
        </td>
    </tr>
    <? foreach ($standard_stations as $station){ temp0043_station($station);}?>
    <tr>
        <td colspan=12>
            <div class='station_type_head'> 
                标杆站&nbsp;(<?= $station_nums[$load_level][$building][ESC_STATION_TYPE_SAVING]?>) 
            </div>
        </td>
    </tr>
    <? foreach ($saving_stations as $station){ temp0043_station($station);}?>
    <tr>
        <td colspan=12>
            <div class='station_type_head'> 
                节能站&nbsp;(<?= $station_nums[$load_level][$building][ESC_STATION_TYPE_COMMON]?>) 
            </div>
        </td>
    </tr>
    <? foreach ($common_stations as $station){ temp0043_station($station);}?>
    <tr>
        <td colspan=12>
            <?= $common_pagination?>
        </td>
    </tr>

    </table>

    <?php function temp0043_station($station){?>
        <tr>
            <td class=station_pos style="background:url(<?= h_online_gif_new($station['alive'])?>) 0px 6px no-repeat;">
                <a href="/frontend/single/day/<?= $station['id']?>">
                    <?= $station['name_chn']?>
                </a> 
            </td>
            <td> </td>
            <td style="width:200px"> 
                <? if($station['last_data']){?>

<?= $station['last_data']['indoor_tmp'] ?>  /
<?= $station['last_data']['outdoor_tmp'] ?>  /
<?= $station['last_data']['box_tmp'] ?>  /
<?= $station['last_data']['fan_0_on']?"on":"off" ?>  /
<?= $station['last_data']['colds_0_on']?"on":"off" ?>  /
<?= $station['last_data']['colds_1_on']?"on":"off" ?> 

                <?}?>
            </td>
            <td style="width:10px"></td>
            <td style="width:124px"> 
                <?= $station['load_num']  ?>A /
                <?= $station['colds_num'] ?> /
                <?= h_station_have_box_name_chn($station['have_box'])?>
            </td>
            <td style="width:10px"></td>
            <td style="width:180px"> 
                <font class="big_num"> <?= $station['energy_last_month'] ?></font> /
                <font class="big_num"> <?= $station['energy_last_month_pday'] ?></font> /
                <font class="big_num_ggh">
                <?= $station['energy_last_month_ggh'] ?>
                </font> 
            </td>
            <td style="width:180px"> 
                <font class="big_num"> <?= $station['energy_this_month'] ?></font> /
                <font class="big_num"> <?= $station['energy_this_month_pday'] ?></font> /
                <font class="big_num_ggh">
                <?= $station['energy_this_month_ggh'] ?>
                </font> 
            </td>
            <td style="width:130px"> 
                <font class="big_num"> <?= $station['energy_last_day'] ?></font> /
                <font class="big_num_ggh">
                <?= $station['energy_last_day_ggh'] ?>
                </font> 
            </td>
            <td style="width:10px"></td>
        </tr>
    <?}?>
    


</div>
