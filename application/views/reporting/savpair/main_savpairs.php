<div class='base_center'>

        <form id="filter" method="get" action="">
        <div class='filter'>
            项目:<?= h_make_select(h_array_2_select($projects),'project_id',$this->input->get('project_id'),""); ?>
            月份:<?= h_make_select($months,'time',$month,""); ?>
        </div>
        <div class='operate'>
	    <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
        <a href="/backend/station/slist" class="btn btn-primary">清除查询</a>
        </div>
        </form>


每小格子里的格式为  [节能对数] 节能率
<br>
<br>
<table class="table2" style="width:1000px">
        <tr>
            <td colspan=10 style="padding:5px;font-size:18px;font-weight:bold;
                        background-color:#ccc;text-align:left">
                <?= h_month_str($month)?>
            </td>
        </tr>
    <tr>
        <th colspan=2> </th>
        <th> </th>
        <? foreach (h_station_total_load_array() as $total_load => $total_load_name){?>
        <th style=""> 
            <?= $total_load_name?>
        </th>
        <?}?>
    </tr>
        <? foreach ($cities as $city_key=>$city){?>
            <? foreach (h_station_building_array() as $building => $building_name){?>
            <tr style="width:40px">
                <? if($building == ESC_BUILDING_ZHUAN){?>
                    <td rowspan=2> <?= $city['name_chn']?> </td>
                <?}?>
                <td style="width:60px"> 
                    <?= $building_name?>
                </td> 
                <td style="width:40px"> 
                <a href="<?= h_url_report_set_savpair($project['id'],$city['id'],$building,$month,$backurl)?>"> 编辑 </a>
                </td>
                <? foreach (h_station_total_load_array() as $total_load => $total_load_name){?>
                <td > 
                    <?= isset($savpairs_info[$city['id']][$building][$total_load])?
                        "[".$savpairs_info[$city['id']][$building][$total_load]['nums']." 对] <font style='color:#096;font-weight:bold'>".
                        h_round2($savpairs_info[$city['id']][$building][$total_load]['save_rate']*100)."%":""?>
                </td>
                <?}?>
            </tr>
            <?}?>
        <?}?>
</table>



<?php

    function h_month_str($time){
        return date("Y年m月",strtotime($time));
    }

    function h_disp_savpairs_info($savpairs){
        foreach(h_station_total_load_array() as $load_level=>$name){
            if(!isset($savpairs[$load_level])){
                $savpairs[$load_level] = 0;
            }
        }
        ksort($savpairs);
        return implode(",",$savpairs);
    }

?>

</div>


<script>
    $(function(){
        $("#download_xls").click(function(){
            document.getElementById('filter').action = "/reporting/savpair";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/reporting/savpair";
            document.getElementById('filter').submit();
        });
    });
</script>


