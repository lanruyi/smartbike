
<style type="text/css">
    .frametable{border: 1px #ccc solid; border-collapse:collapse;}
    .frametable th{font-size:1.8em;text-align: center;padding: 15px 0 15px 0;border: 1px #ccc solid}
    .frametable td{font-size: 1.2em;border: 1px #ccc solid}
    .innertable{width:100%;border-left: 0px;border-right: 0px;margin-top: -1px;margin-bottom:  -1px}
    .innertable td{font-size: 1.1em;border-left: 0px;border-right: 0px;padding: 0px 0px;}
    .datatable{width:100%;margin-top: -1px;margin-bottom: -1px}
    .datatable td{width:90px;padding: 5px 5px;border: 1px #ccc solid}
    .hearder{padding:5px 5px}
    td{padding:0 0}
</style>

<div class=base_center>
<a href="<?= $backurl?>"> 返回 </a>
<br>
<br>

<table class="frametable">
<tr>
    <th colspan ="9"><?= $city['name_chn']?>基站蓄电池保温柜及智能新风项目节能标杆站节能核算表 </th>
</tr>
<tr>
    <td colspan="4" style="padding:5px 5px">分公司：<?= $project['name_chn']."-".$city['name_chn']?></td>
    <td colspan ="4"style="padding:5px 5px">时间：<?= $disp_time?></td>
</tr>

<tr>
    <td width="100px" class ="hearder">负载类型</td>
    <td width="100px" class ="hearder">基站名称</td>
    <td width="100px" class ="hearder">直流负载(A)</td>
    <td width="100px" class ="hearder">基站类型</td>
    <td width="100px" class ="hearder">总用电量(度)</td>
    <td width="100px" class ="hearder">直流用电量(度)</td>
    <td width="100px" class ="hearder">节电率</td>
    <td width="100px" class ="hearder">节电量(度)</td>
    <td width="100px" class ="hearder">平均节电率</td> 
</tr>

<?php foreach($savpair_hash as $total_load=>$pairs){ ?>
<tr>
    <td colspan="9">
    
    <table class="innertable" width="600px">
    <tr>
        <td width="99px" style="padding:5px 5px"><?= h_station_total_load_name_chn($total_load)?></td>
        <td  width="661">
            <div id="datatable">
               <table class="datatable">
                <?php foreach($pairs as $savpair){?>
                <tr><td><?= $savpair[ESC_STATION_TYPE_STANDARD]['name_chn']?></td>
                    <td><?= $savpair[ESC_STATION_TYPE_STANDARD]['load_num']?></td>
                    <td>基准站</td>
                    <td><?= $savpair[ESC_STATION_TYPE_STANDARD]['main_energy']?></td>
                    <td><?= $savpair[ESC_STATION_TYPE_STANDARD]['dc_energy']?></td>
                    <td rowspan="2"><?= h_round2($savpair['save_rate']*100)?>%</td>
                    <td rowspan="2"><?= h_round2($savpair[ESC_STATION_TYPE_SAVING]['main_energy']*$savpair['save_rate']/(1-$savpair['save_rate']))?></td>
                </tr>
                <tr><td><?= $savpair[ESC_STATION_TYPE_SAVING]['name_chn']?></td>
                    <td><?= $savpair[ESC_STATION_TYPE_SAVING]['load_num']?></td>
                    <td>标杆站</td>
                    <td><?= $savpair[ESC_STATION_TYPE_SAVING]['main_energy']?></td>
                    <td><?= $savpair[ESC_STATION_TYPE_SAVING]['dc_energy']?></td>
                </tr>
                <?php }?>  
               </table>
            </div>
        </td>
        <td  width="99px" style="padding:5px 5px"><?= h_round2($average_rate[$total_load]*100)?>%</td>
    </tr>
    </table>
    </td>
</tr>
<?php }?>
</table>
</div>
