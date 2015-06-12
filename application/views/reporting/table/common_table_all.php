<style type="text/css">
    .frametable{border: 1px #ccc solid; border-collapse:collapse;}
    .frametable th{font-size:1.8em;text-align: center;padding: 15px 0 15px 0;border: 1px #ccc solid}
    .frametable td{font-size: 1.2em;padding:5px 10px;border: 1px #ccc solid}
    td{padding:0 0}
</style>

<div class=base_center>
<a href="<?= $backurl?>"> 返回 </a>
<br>
<br>

<table class="table2">
<tr><td colspan="13"><?= $project['name_chn']?></td>
</tr>
<tr>
    <td style="width:70px">月份</td>
    <td style="width:30px">城市</td>
    <td>建筑</td>
    <td>基站</td>
    <td></td>
    <td>档位</td>
    <td>直流负载</td>
    <td>月用电量</td>
    <td>节电率</td>
    <td>节电量</td>
    <td>电费单价</td>
    <td>电费</td>
    <td>备注</td>
</tr>

<? foreach($cities as $city){ ?>
<? foreach(h_station_building_array() as $building=>$building_name){ ?>


<? foreach($station_hash[$city['id']][$building] as $stage => $station_level_hash){?>

    <? foreach(h_station_total_load_array() as $total_load=>$name){ ?>
        
        <? 
            $stations    = isset($station_level_hash[$total_load])?$station_level_hash[$total_load]:array(); 
            if(!$stations){
                continue; 
            }

        ?>
        <? foreach($stations as $station){ ?>
            <? $err = h_station_month_main_energy_err($station['monthdata']['main_energy'],$station['load_num']); ?>
            <?
                $p_energy = ($err?$average_energy_hash[$city['id']][$building][$total_load]:
                    $station['monthdata']['main_energy'])*$average_rate[$city['id']][$building][$total_load]
                            /(1-$average_rate[$city['id']][$building][$total_load]);
                $p_money = $station['price'] * $p_energy;
            ?>
            <tr>
                <td> <?= h_dt_format($datetime,"Y-m-1")?> </td>
                <td> <?= $city['name_chn']?> </td>
                <td> <?= $building_name?> </td>
                <td> <?= $station['name_chn']?> </td>
                <td>
                    <a href="/backend/energy?station_id=<?= $station['id']?>&datetime=<?=$datetime?>" >详细能耗</a>
                </td>
                <td><?= h_station_total_load_name_chn($station['total_load'])?></td>
                <td><?= $station['load_num']?></td>
                <td><?= h_round2($err?$average_energy_hash[$city['id']][$building][$total_load]:
                    $station['monthdata']['main_energy'])?></td>
                <td><?= h_round2($average_rate[$city['id']][$building][$total_load]*100)?>%</td>
                <td><?= round($p_energy,2)?></td>
                <td><?= $station['price']?></td>
                <td><?= round($p_money,2)?></td>
                <td><?= h_disp_common_table_err($err)?></td>
            </tr>
        <? }?>
    <? }?>
<? }?>









<?}?>
<?}?>

</table>



<?php 
    function h_disp_common_table_err($err){
        $errs[0]="";
        $errs[1]="无能耗";
        $errs[2]="能耗偏少";
        return $errs[$err];
    }
?>

</div>
