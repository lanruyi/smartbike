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
    .table2 td{text-align: left;}
</style>

<div class="base_center">

    <form id="filter" method="get" action="">
    <div class='filter'>
        项目:<?= h_make_select(h_array_2_select($projects),'project_id',$this->input->get('project_id'),""); ?>
        城市:<?= h_make_select(h_array_2_select($cities),'city_id',$this->input->get('city_id'),""); ?>
        建筑类型:<?= h_station_building_select($this->input->get('Building'),""); ?>
        开始时间:<input type="text" name="start_time" style="width:100px" value=<?=  $start_time?> />
        结束时间:<input type="text" name="stop_time" style="width:100px" value=<?=  $stop_time?> />
    </div>
    <div class='operate'>
    <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    <a href="/reporting/alltab/stdcom_day" class="btn btn-primary">清除查询</a>
    </div>
    </form>




<table class="table2">
<tr style="font-weight:bold;background-color:#ccc">
    <td>基站</td>
    <td>负载(A)</td>
    <td>日均用电量(度)</td>
    <td>本档平均用电量(度)</td>
</tr>
<?foreach($sav_stds as $load_level => $sav_std_group){?>
    <tr>
        <td colspan=6><?= h_station_total_load_name_chn($load_level)?></td>
    </tr>
    <?foreach($sav_std_group as $key => $sav_std){?>
        <tr>
            <td><?= $sav_std['station']['name_chn']?></td>
            <td><?= $sav_std['station']['load_num']?></td>
            <td><?= h_round2($sav_std['energy']['main_energy'])?></td>
            <td><?= h_round2($average_main[$load_level]['main'])?></td>
        </tr>

    <?}?>
<?}?>
</table>

<br />
<br />


汇总表(有分期)：
<table class="table2">
<tr style="font-weight:bold;background-color:#ccc">
    <td> <b>项目</b> </td>
    <td> <b>城市</b> </td>
    <td> <b>建筑</b> </td>
    <td> <b>档位</b> </td>
    <td> <b>节能站数量(个)</b> </td>
    <td> <b>节能站平均负载(A)</b> </td>
    <td> <b>基准平均(A)</b> </td>
    <td> <b>节能站平均能耗(度)</b> </td>
    <td> <b>节能站平均节能(度)</b> </td>
    <td> <b>节能站平均节能率</b> </td>
</tr>
<?foreach(h_station_total_load_array() as $total_load => $name){?>
<? 
$std  = $average_main[$total_load]['main'];
$main = $total_sta_hash[$total_load]['average_main'];
$save = $std && $main ?($std - $main):"";
$rate = $std?$save / $std:0;
?>

    <tr>
        <td> <?= $project['name_chn']?></td>
        <td> <?= $city['name_chn']?></td>
        <td> <?= h_station_building_name_chn($building) ?> </td>
        <td> <?= h_station_total_load_name_chn($total_load)?></td>
        <td> <?= $total_sta_hash[$total_load]['num'] ?> </td>
        <td> <?= h_round2($total_sta_hash[$total_load]['average_load_num']) ?> </td>
        <td> <?= h_round2($std)?></td>
        <td> <?= h_round2($main) ?> </td>
        <td> <?= h_round2($save) ?> </td>
        <td> <?= $rate != 0?h_round2($rate * 100)."%":""?> </td>

    </tr>

<?}?>
</table>


<br />
<br />

<table class="table2">
    <tr style="font-weight:bold;background-color:#ccc">
        <td> <b>项目</b> </td>
        <td> <b>城市</b> </td>
        <td> <b>建筑</b> </td>
        <td> <b>基站</b> </td>
        <td> <b>档位</b> </td>
        <td> <b>基准能耗(度)</b> </td>
        <td> <b>日均能耗(度)</b> </td>
        <td> <b>日均节能量(度)</b> </td>
        <td> <b>节能率</b> </td>
        <td> <b>额外交流功率(w)</b> </td>
        <td> <b>分期</b> </td>
        <td> <b>查看</b> </td>
    </tr>

<? foreach($stations as $station){
    if($station['station_type'] != ESC_STATION_TYPE_COMMON){
        continue;
    }
?>
    <tr>
        <? $std_main = $average_main[$station['total_load']]['main'];?>
        <? $main = $main_hash[$station['id']]['main_energy']; ?> 
        <? $save = $main>0 && $std_main - $main>0?$std_main - $main:"";?>
        <? $rate = $save>0 && $std_main>0?$save/$std_main:""; ?> 

        <td> <?= $project['name_chn']?> </td>
        <td> <?= $city['name_chn']?> </td>
        <td> <?= h_station_building_name_chn($station['building']) ?> </td>
        <td> <?= $station['name_chn']?> </td>
        <td> <?= h_station_total_load_name_chn($station['total_load'])?> </td>
        <td> <?= h_round2($average_main[$station['total_load']]['main'])?></td>
        <td> <?= h_round2($main)?> </td>
        <td> <?= h_round2($save)?></td>
        <td> <?= $rate != 0?h_round2($rate*100)."%":""?></td>
        <td> <?= $station['extra_ac'] != 0?$station['extra_ac']:""?> </td>
        <td> <?= $station['batch_id']?></td>
        <td> <a href="http://semos-cloud.com:8988/backend/energy?station_id=<?= $station['id']?>">查看</a> </td>
    </tr>
<?}?>



</table>

</div>

<script>
    $(function(){
        $("select[name='project_id']").change(function(){
            var all_cities = <?= json_encode($project_cities_hash)?>;
            var project_id = $("select[name='project_id']").val();
            var project_cities = all_cities[project_id];  
            var str="";
            for(var i=0;i<project_cities.length;i++){
                str+= "<option value="+project_cities[i].id+">";
                str+= project_cities[i].name_chn;
                str+= "</option>";
            }
            $("select[name='city_id']").html(str);
        })
        $("#download_xls").click(function(){
            document.getElementById('filter').action = "/reporting/alltab/stdcom_day";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/reporting/alltab/stdcom_day";
            document.getElementById('filter').submit();
        });
    })
</script>
