<style type="text/css">
    .frametable{border: 1px #ccc solid; border-collapse:collapse;}
    .frametable th{font-size:1.8em;text-align: center;padding: 15px 0 15px 0;border: 1px #ccc solid}
    .frametable td{font-size: 1.2em;padding:5px 10px;border: 1px #ccc solid}
    td{padding:0 0}
    .table2 td{text-align: left;}
</style>

<div class=base_center>
<a href="<?= $backurl?>"> 返回 </a>
<br>

<table class="table2">
<tr>
    <td colspan="12" style="text-align:left;font-size:18px;font-weight:bold">
    <?= $city['name_chn']?> <?= h_station_building_name_chn($building)?> 节能站核算表
    <?= h_dt_format($datetime,"Y年m月")?>
    </td>
</tr>
<tr style="font-weight:bold;background-color:#ddd">
    <td>基站名称</td>
    <td></td>
    <td>负载档位</td>
    <td>直流负载(A)</td>
    <td>月总用电量(度)</td>
    <td>月直流用电量(度)</td>
    <td>节电率</td>
    <td>节电量(度)</td>
    <td>电费单价(元)</td>
    <td>节电费(元)</td>
    <td>备注</td>
    <td>额外交流功率(w)</td>
</tr>


<? foreach($station_hash as $batch_id => $station_level_hash){?>
    <tr>
        <td colspan=12 style="text-align:center;">
            <b><?= isset($batch_name_chn_hash[$batch_id])?$batch_name_chn_hash[$batch_id]:"无分期"?></b>
        </td>
    </tr>
    <? 
        $stage_money = 0;
        $main_energy = 0;
    ?>
    <? foreach(h_station_total_load_array() as $total_load=>$name){ ?>
        
        <? 
            $stations = isset($station_level_hash[$total_load])?$station_level_hash[$total_load]:array(); 
            if(!$stations){
                continue; 
            }

            $main_energy += $average_energy_hash[$total_load] * count($stations);
        ?>
        <? foreach($stations as $station){ ?>
            <? $err = h_station_month_main_energy_err($station['monthdata']['main_energy'],$station['load_num']); ?>
            <?
                $energy = $this->monthdata->getMainEnergy($station['id'],$datetime);
                $dc_energy = $this->monthdata->getDCEnergy($station['id'],$datetime);
                $p_energy = ($err?$average_energy_hash[$total_load]:$energy)
                    * $average_rate[$total_load]/(1-$average_rate[$total_load]);
                $p_money = $station['price'] * $p_energy;
                $stage_money += $p_money;
            ?>
            <tr>
                <td> <?= $station['name_chn']?> </td>
                <td>
                    <a href="/backend/energy?station_id=<?= $station['id']?>&datetime=<?=$datetime?>" target="_blank">能耗详细</a>
                </td>
                <td><?= h_station_total_load_name_chn($station['total_load'])?></td>
                <td><?= $station['load_num']?></td>
                <td><?= h_round2($err?$average_energy_hash[$total_load]:$energy)?></td>
                <td><?= h_round2($dc_energy)?></td>
                <td><?= h_round2($average_rate[$total_load]*100)?>%</td>
                <td><?= round($p_energy,2)?></td>
                <td><?= $station['price']?></td>
                <td><?= round($p_money,2)?></td>
                <td><?= h_disp_common_table_err($err)?></td>
                <td><?= $station['extra_ac']?$station['extra_ac']:"" ?></td>
            </tr>
        <? }?>
    <? }?>
    <tr>
        <td colspan=11 style="text-align:right;">
        <b>总能耗</b>:<?= h_round2($main_energy)?>度 <br>
        <b>总电费</b>:<?= h_round2($stage_money)?>元 <br>
        </td>
    </tr>
<? }?>

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
