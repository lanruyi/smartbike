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
    <a href="/reporting/alltab/stdsav_day" class="btn btn-primary">清除查询</a>
    </div>
    </form>




<table class="frametable">
<tr>
    <td width="100px" class ="hearder">负载类型</td>
    <td width="100px" class ="hearder">基站名称</td>
    <td width="100px" class ="hearder">直流负载(A)</td>
    <td width="100px" class ="hearder">基站类型</td>
    <td width="100px" class ="hearder">用电量(度)</td>
    <td width="100px" class ="hearder">节电率</td>
    <td width="100px" class ="hearder">日均节电量(度)</td>
    <td width="100px" class ="hearder">平均节电率</td> 
</tr>

<? foreach($savpair_hash as $total_load=>$pairs){ ?>
<tr>
    <td colspan="8">
    
    <table class="innertable" width="600px">
    <tr>
        <td width="99px" style="padding:5px 5px"><?= h_station_total_load_name_chn($total_load)?></td>
        <td  width="661">
            <div id="datatable">
               <table class="datatable">
                <? foreach($pairs as $savpair){?>
                <tr><td><?= $savpair[ESC_STATION_TYPE_STANDARD]['name_chn']?></td>
                    <td><?= $savpair[ESC_STATION_TYPE_STANDARD]['load_num']?></td>
                    <td>基准站</td>
                    <td><?= h_round2($savpair[ESC_STATION_TYPE_STANDARD]['energy']['main_energy'])?></td>
                    <td rowspan="2"><?= h_round2($savpair['save_rate']*100)?>%</td>
                    <td rowspan="2"><?= h_round2($savpair[ESC_STATION_TYPE_SAVING]['energy']['main_energy']*$savpair['save_rate']/(1-$savpair['save_rate']))?></td></tr>
                <tr><td><?= $savpair[ESC_STATION_TYPE_SAVING]['name_chn']?></td>
                    <td><?= $savpair[ESC_STATION_TYPE_SAVING]['load_num']?></td>
                    <td>标杆站</td>
                    <td><?= h_round2($savpair[ESC_STATION_TYPE_SAVING]['energy']['main_energy'])?></td></tr>
                <? }?>  
               </table>
            </div>
        </td>
        <td  width="99px" style="padding:5px 5px"><?= h_round2($average_rate[$total_load]['rate']*100) ?>%</td>
    </tr>
    </table>
    </td>
</tr>
<? }?>
</table>

<br />
<br />

<table class="table2">
    <tr>
        <td> <b>项目</b> </td>
        <td> <b>城市</b> </td>
        <td> <b>建筑</b> </td>
        <td> <b>基站</b> </td>
        <td> <b>档位</b> </td>
        <td> <b>日均能耗(度)</b> </td>
        <td> <b>节能率</b> </td>
        <td> <b>日均节能量(度)</b> </td>
        <td> <b>额外交流功率 (w)</b></td>
    </tr>
<? foreach($stations as $station){
    if($station['station_type'] != ESC_STATION_TYPE_COMMON){
        continue;
    }
?>
    <tr>
        <? $rate = $average_rate[$station['total_load']]['rate']; ?> 
        <? $main = $main_hash[$station['id']]['main_energy']; ?> 

        <td> <?= $project['name_chn']?> </td>
        <td> <?= $city['name_chn']?> </td>
        <td> <?= h_station_building_name_chn($station['building']) ?> </td>
        <td style="text-align: center"> <?= $station['name_chn']?> </td>
        <td> <?= h_station_total_load_name_chn($station['total_load'])?> </td>
        <td> <?= h_round2($main)?> </td>
        <td> <?= $rate != 0?h_round2($rate*100)."%":""?></td>
        <td> <?= h_round2($rate != 1?$main * $rate/(1-$rate):0)?></td>
        <td> <?= $station['extra_ac'] != 0?$station['extra_ac']:""?> </td>
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
            document.getElementById('filter').action = "/reporting/alltab/stdsav_day";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/reporting/alltab/stdsav_day";
            document.getElementById('filter').submit();
        });
    })
</script>
