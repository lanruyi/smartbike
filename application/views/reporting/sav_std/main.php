<div class='base_center'>


<div style="float:left;width:1000px;margin:12px 0;">
    <ul>
    <? foreach ($projects as $p){?>
        <li style="float:left;font-weight:<?= $p['id']==$project['id']?"bold":""?>">
        <a href="?project_id=<?= $p['id']?>">
            <?= $p['name_chn']?>
        </a>
        <br/>
        </li>
    <?}?>
    </ul>
</div>


每小格子里的格式为  平均月用电量 ( 参与计量基准站/基准站总数 )
<br>
<br>
<table class="table2">
        

    <? foreach ($month_array as $month){?>
        <tr>
            <td colspan=10 style="padding:5px;font-size:15px;font-weight:bold;background-color:#ccc"><?= h_month_str($month)?></td>
        </tr>
    <tr>
        <th colspan=2> </th>
        <th> </th>
        <? foreach (h_station_total_load_array() as $total_load => $total_load_name){?>
        <th style="width:85px"> 
            <?= $total_load_name?>
        </th>
        <?}?>
    </tr>
        <? foreach ($cities as $city_key=>$city){?>
            <? foreach (h_station_building_array() as $building => $building_name){?>
            <tr>
                <? if($building == ESC_BUILDING_ZHUAN){?>
                    <td rowspan=2> <?= $city['name_chn']?> </td>
                <?}?>
                <td> 
                    <?= $building_name?>
                </td> 
                <td> 
                <a href="/reporting/sav_std/detail?project_id=<?= $project['id']?>&city_id=<?=$city['id']?>&building=<?=$building?>&datetime=<?=$month?>&backurl=<?=$backurl?>"> 编辑 </a>
                </td>
                <? foreach (h_station_total_load_array() as $total_load => $total_load_name){?>
                <td > 
                    <?= isset($sav_std_average_hash[$month][$city['id']][$building][$total_load])?
                        round($sav_std_average_hash[$month][$city['id']][$building][$total_load]['average_main_energy'],2):"" ?>
                    (<?= isset($sav_std_hash[$month][$city['id']][$building][$total_load])?
                        count($sav_std_hash[$month][$city['id']][$building][$total_load]):0?>/0)
                </td>
                <?}?>
            </tr>
            <?}?>
        <?}?>
    <?}?>
</table>



<?php

    function h_month_str($time){
        return date("Y年m月",strtotime($time));
    }

?>

</div>


