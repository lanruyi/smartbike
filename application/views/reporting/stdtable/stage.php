<style type="text/css">
    .frametable{border: 1px #ccc solid;border-collapse:collapse;}
    .frametable th{font-size:1.8em;text-align: center;padding: 15px 0 15px 0;border: 1px #ccc solid}
    .frametable td{font-size: 1.2em;padding:5px 10px;border: 1px #ccc solid}
    td{padding:0 0}
    .table2 td{text-align: left;}
</style>

<div class=base_center>
<a href="<?= $backurl?>"> 返回 </a>

<br>
<br>
<font style="color:red">红色</font> 表示使用同城 同建筑 同档位其余数据正常站点的平均值


<br>
<br />

<table class="table2">
<tr>
    <td colspan="8"  style="text-align:left">
        <?= $project['name_chn']." - ".$city['name_chn']?> &nbsp;&nbsp; 
        <?=h_station_building_name_chn($building)?>&nbsp;&nbsp;<?= h_dt_format($datetime,"Y年m月")?>
    </td>
</tr>
<tr style="font-weight:bold;background-color:#ccc">
    <td>基站</td>
    <td>负载(A)</td>
    <td>月总用电量(度)</td>
    <td>月直流用电量(度)</td>
    <td>额外交流功率(w)</td>
    <td>本档平均用电量(度)</td>
    <td>原因</td>
</tr>
<?foreach($sav_stds as $load_level => $sav_std_group){?>
    <tr>
        <td colspan=8><?= h_station_total_load_name_chn($load_level)?></td>
    </tr>
    <?foreach($sav_std_group as $key => $sav_std){?>
        <tr>
            <td><?= $sav_std['station']['name_chn']?></td>
            <td><?= $sav_std['station']['load_num']?></td>
            <td><?= $this->monthdata->getTrueEnergy($sav_std['station']['id'],$datetime)?></td>
            <td><?= $this->monthdata->getDCEnergy($sav_std['station']['id'],$datetime)?></td>
            <td><?= $sav_std['station']['extra_ac']?$sav_std['station']['extra_ac']:"" ?></td>
            <td><?= h_round2($sav_std_average_hash[$load_level]['average_main_energy'])?></td>
            <td><?= $sav_std['monthdata']['reason']?></td>
        </tr>

    <?}?>
<?}?>
</table>
<br />


<form action="/reporting/stdtable/save_true_energy?datetime=<?=$datetime?>&backurl=<?=$backurlstr?>" method="post">
<input type="submit" />

<table class="table2">
<tr>
    <td colspan="16"  style="text-align:left">
        <?= $project['name_chn']." - ".$city['name_chn']?> &nbsp;&nbsp; 
        <?=h_station_building_name_chn($building)?>&nbsp;&nbsp;<?= h_dt_format($datetime,"Y年m月")?>
    </td>
</tr>
<tr style="font-weight:bold;background-color:#ccc">
    <td>基站</td>
    <td></td>
    <td>档位</td>
    <td>负载(A)</td>
    <td>月总用电量(度)</td>
    <td>月直流用电量(度)</td>
    <td>本档基准</td>
    <td>节电量(度)</td>
    <td>节电率</td>
    <td>电费单价(元)</td>
    <td>节电费(元)</td>
    <td>备注</td>
    <td>额外交流功率(w)</td>
    <td>修正后</td>
    <td>原因</td>
</tr>


<? foreach($station_hash as $batch_id => $station_level_hash){?>
    <tr>
        <td colspan=16 style="text-align:left">
            <b><?= isset($batch_name_chn_hash[$batch_id])?$batch_name_chn_hash[$batch_id]:"无分期"?></b>
        </td>
    </tr>
    <? foreach(h_station_total_load_array() as $total_load=>$name){ ?>
        <? 
            $stations    = isset($station_level_hash[$total_load])?$station_level_hash[$total_load]:array(); 
            if(!$stations){
                continue; 
            }
        ?>
        
        <? foreach($stations as $station){ ?>
            <tr>
                <td><?= $station['name_chn']?></td>
                <td>
                    <a href="/backend/energy?station_id=<?= $station['id']?>&datetime=<?=$datetime?>" target="_blank">详细</a>
                </td>
                <td nowrap="nowrap"><?= h_station_total_load_name_chn($station['total_load'])?></td>
                <td><?= $station['load_num']?></td>
                <td><?= $station['sav_average_dis']?></td>
                <td><?= $station['sav_dc_energy']?></td>
                <td><?= h_round2($station['std_average'])?></td>
                <td><?= h_round2($station['sav'])?></td>
                <td><?= ($station['rate'] != 0)?h_round2($station['rate'])."%":""?></td>
                <td><?= $station['price']?></td>
                <td><?= h_round2($station['price']*$station['sav'])?></td>
                <td><?= h_disp_common_table_err($station['err'])?></td>
                <td><?= $station['extra_ac']?$station['extra_ac']:"" ?></td>
                <td>
                    <input name='true_energy[<?= $station['id']?>]' 
                        value="<?= $station['monthdata']['true_energy']>0?
                        $station['monthdata']['true_energy']:""?>" style="width:60px;"/></td>
                <td>
                    <input name='reason[<?= $station['id']?>]' 
                        value="<?= $station['monthdata']['reason']?>" style="width:120px;"/></td>
            </tr>
        <? }?>
    <? }?>

<? }?>

</table>
<input type="submit" />
</form>


<?php 
    function h_disp_common_table_err($err){
        $errs[0]="";
        $errs[1]="无能耗";
        $errs[2]="能耗偏少";
        $errs[6]="不节能";
        return $errs[$err];
    }
?>

</div>

