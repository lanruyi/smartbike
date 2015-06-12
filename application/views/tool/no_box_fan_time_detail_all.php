<style type="text/css">
    .frametable{border: 1px #ccc solid; border-collapse:collapse;}
    .frametable th{font-size:1.8em;text-align: center;padding: 15px 0 15px 0;border: 1px #ccc solid}
    .frametable td{font-size: 1.2em;padding:5px 10px;border: 1px #ccc solid}
    td{padding:0 0}
</style>

<div class=base_center>
<a href="/tool/no_box_fan_time"> 返回 </a>
<br>

<table class="frametable">
<tr><td colspan="11">时间:<?= h_dt_format($month,"Y年m月")?></td></tr>
<tr>
    <td style="width:40px">城市</td>
    <td style="width:60px">批次</td>
    <td style="width:100px">基站名称</td>
    <td style="width:50px">档位</td>
    <td style="width:30px">负载</td>
    <td>本月真实负载</td>
    <td>本月用电</td>
    <td>新风开启时间(分钟)</td>
    <td>省电(每小时2度)</td>
    <td>电费单价(元)</td>
    <td>节电费</td>
</tr>



    <? foreach($stations as $station){ ?>
        <?
            $fan_time = null;
            if(isset($fan_time_hash[$station['id']])){
                $fan_time = $fan_time_hash[$station['id']]['time'];
            }
        ?>
        <tr>
            <td><?= $station['city']['name_chn']?></td>
            <td><?= h_station_stage_name_chn($station['stage'])?></td>
            <td>
                <a href="/backend/data?station_id=<?= $station['id']?>&time=<?= $month?>">
                    <?= $station['name_chn']?>
                </a>
            </td>
            <td><?= h_station_total_load_name_chn($station['total_load'])?></td>
            <td><?= $station['load_num']?></td>
            <td><?= $monthdata_hash[$station['id']]?$monthdata_hash[$station['id']]['true_load_num']:""?></td>
            <td><?= $monthdata_hash[$station['id']]?$monthdata_hash[$station['id']]['main_energy']:""?></td>
            <td><b><?= round($fan_time)?></b></td>
            <td><?= round($fan_time/60*2,2)?></td>
            <td><?= $station['price']?></td>
            <td><?= round($fan_time*$station['price']/60*2,2)?></td>
        </tr>
    <?}?>


</table>


</div>

