<style type="text/css">
.load_level_building{ float:left;width:132px;margin:0 0 0 10px;border:1px solid #369;color:#369;background-color:#ace}
.first{margin:0px;}
.load_level_building ul{margin: 0 0}
.load_level_building ul h3{text-align:center;margin:2px 0}
.load_level_building ul h3.active{font-size:14px;font-weight:bold;color:#000;}
.load_level_building ul li{color:#000;width:126px;margin:3px;background-color:#69c;}
.load_level_building ul li a{display:block;color:#000;padding:1px 3px}
.load_level_building ul li a:hover {background-color:#036;color:#fff;}
.load_level_building ul li.active a{background-color:#036;color:#fff;}
    
.es_cc{}
.es_cc tr td{text-align:right;}
.cc_head{width:980px;background-color:#ccc;}
.es_cc td.station_pos{width:120px;padding:0 0 0 24px;text-align:left; height:26px;line-height:26px;}
.big_num{font-size:12px;font-weight:bold;color:#666}
.big_num_ggh{font-size:13px;font-weight:bold;color:#69c}

.station_type_head{float:left;text-align:left;width:980px;margin:5px 0;padding:2px 8px;color:#fff;background-color:#369;}
</style>


<div class='base_center'>

    <div style='clear:both;height:10px'>  </div>
    <div style='clear:both;height:24px;line-height:24px;padding:0 8px;width:980px;border:1px solid #c96'>  
        基站按不同档位和建筑类型分类显示，查看某一类型基站请点选下面按钮!
    </div>
    <div style='clear:both;height:6px'>  </div>


    <!------------------------------------- 此处开始菜单 ---------------------------------------->
    <div style="margin:8px 0 0 0">
    <? foreach (h_station_total_load_array() as $_load_level => $level_name){?>
    <div class="load_level_building <?= $_load_level == 1?"first":""?>">
            <ul>
                <h3 class='<?= $load_level == $_load_level?"active":""?>'> <?= $level_name?> </h3>
                <li class='<?= $load_level == $_load_level && $building == 1?"active":""?>'>
                    <a href="/frontend/stations/stdlist?load_level=<?= $_load_level?>&building=1">
                    <? $_nums = $station_nums[$_load_level][ESC_BUILDING_ZHUAN]?>
                    砖墙 &nbsp;(<?= $_nums[ESC_STATION_TYPE_STANDARD]?>
                    + <?= $_nums[ESC_STATION_TYPE_COMMON]?>)
                    </a>
                </li>
                <li class='<?= $load_level == $_load_level && $building == 2?"active":""?>'>
                    <a href="/frontend/stations/stdlist?load_level=<?= $_load_level?>&building=2">
                    <? $_nums = $station_nums[$_load_level][ESC_BUILDING_BAN]?>
                    板房 &nbsp;(<?= $_nums[ESC_STATION_TYPE_STANDARD]?>
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
        <td> 负载 </td>
        <td> </td>
        <td> 昨日能耗 </td>
        <td> 基准平均 </td>
        <td> 昨日节能量 </td>
        <td> 节能率 </td>
        <td> </td>
        <td> 本月能耗 </td>
        <td> 基准平均 </td>
        <td> 节能量 </td>
        <td> 节能率 </td>
    </tr>
    <tr>
        <td colspan=13>
            <div class='station_type_head'> 
                <?= h_fake_jizhu_to_biaogan(ESC_STATION_TYPE_STANDARD,$this->current_project['id'])?>
                &nbsp;(<?= $station_nums[$load_level][$building][ESC_STATION_TYPE_STANDARD]?>) 
            </div>
        </td>
    </tr>
    <? foreach ($standard_stations as $station){ temp0043_station($station,$day_average_main_energy,$month_average_main_energy,h_role_is_admin($this->user_role),
                in_array($station['id'],$std_station_ids));}?>
    <tr>
        <td colspan=13>
            <div class='station_type_head'> 
                <?= h_station_station_type_name_chn(ESC_STATION_TYPE_COMMON)?>
                &nbsp;(<?= $station_nums[$load_level][$building][ESC_STATION_TYPE_COMMON]?>) 
            </div>
        </td>
    </tr>
    <? foreach ($common_stations as $station){ temp0043_station($station,$day_average_main_energy,$month_average_main_energy,h_role_is_admin($this->user_role));}?>
    <tr>
        <td colspan=12>
            <?= $common_pagination?>
        </td>
    </tr>

    </table>
    <?php function temp0043_station($station,$day_average_main_energy,$month_average_main_energy,$show,$in_stds = false){?>

        <? 
        $rate = null;
        //if($station['station_type']==ESC_STATION_TYPE_SAVING){
            //$rate = isset($day_rates[$station['id']])?$day_rates[$station['id']]:null;
        //}else if($station['station_type']==ESC_STATION_TYPE_COMMON){
            //$rate = $day_rates['rate'];
        //}
        ?>    
        <tr>
            <td class=station_pos style="background:url(<?= h_online_gif_new($station['alive'])?>) 0px 6px no-repeat;">
                <a href="/frontend/single/day/<?= $station['id']?>">
                    <?= $station['name_chn']?>
                    <?if($in_stds){?>
                        <br />[本日本档标杆.]
                    <?}?>
                </a> 
            </td>
            <td style="width:5px"></td>
            <td style="width:40px"> 
                <?= $station['load_num']  ?>A 
            </td>

            <td style="width:10px"></td>
            <? if($station['day_energy']&&$day_average_main_energy&& $show){?>
                <td style="width:70px"> 
                    <?= $station['day_energy']."度"?>
                </td>
                <td style="width:70px"> 
                    <?= round($day_average_main_energy,2)."度"?>
                </td>
                <? if($station['station_type'] == ESC_STATION_TYPE_COMMON){?>
                    <td style="width:70px"> 
                        <?= round($day_average_main_energy-$station['day_energy'],2)."度"?>
                    </td>
                    <td style="width:60px"> 
                        <?= round(($day_average_main_energy-$station['day_energy'])*100/$day_average_main_energy,2)."%"?>
                    </td>
                <?}else{?>
                    <td colspan=2 style="color:#eee"> </td>
                <?}?>
            <?}else{?>
                <? if(!$station['day_energy']){?>
                    <td colspan=4 style="color:#ccc;text-align:left">&nbsp;&nbsp;&nbsp;&nbsp; 能耗统计有误 </td>
                <?}else{?>
                    <td colspan=4 style="color:#eee"> </td>
                <?}?>
            <?}?>



            <td style="width:10px"></td>
            <? if($station['month_energy']&&$month_average_main_energy&&$show){?>
                <td style="width:70px"> 
                    <?= $station['month_energy']."度"?>
                </td>
                <td style="width:70px"> 
                    <?= round($month_average_main_energy,2)."度"?>
                </td>
                <? if($station['station_type'] == ESC_STATION_TYPE_COMMON){?>
                    <td style="width:70px"> 
                        <?= round($month_average_main_energy-$station['month_energy'],2)."度"?>
                    </td>
                    <td style="width:60px"> 
                        <?= round(($month_average_main_energy-$station['month_energy'])*100/$month_average_main_energy,2)."%"?>
                    </td>
                <?}else{?>
                    <td colspan=2 style="color:#eee"> </td>
                <?}?>
            <?}else{?>
                <? if(!$station['month_energy']){?>
                    <td colspan=4 style="color:#ccc;text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;  </td>
                <?}else{?>
                    <td colspan=4 style="color:#eee"> </td>
                <?}?>
            <?}?>




        </tr>
    <?}?>
    


</div>
