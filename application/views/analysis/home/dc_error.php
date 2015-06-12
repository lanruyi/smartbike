<style>
	.bg_green{background:#ddd}
	.title_font{font-family: georgia, serif;color: #542525;font-size: 14px;letter-spacing: 0.2pt;}
</style>
<div class="base_center">
	<form id="filter" method="get" action="/bug/bug/detail">
    <div class='filter'>
      项目：<?= h_common_select('project_id',$projects,$project_id); ?>
      城市：<?= h_common_select('city_id',$cities,$city_id); ?>
      <br/>
    </div>
    <div class='operate'>
    <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
      <a href="/analysis/home/dc_error" class="btn btn-primary">清除查询</a>
    </div>
  </form>
	<h5 class='title_font'><?=$title?></h5>
	<table class="table2">
		<tr style="background-color:#ccc">
			<td style="width:50px"><b>城市</b></td>
            <td style="width:145px"><b>基站名</b></td>
			<td style="width:60px"><b>类型</b></td>
			<td style="width:70px"><b>状态</b></td>
            <td style="width:50px"><b>建筑</b></td>
			<td style="width:50px"><b>标称负载</b></td>
			<td style="width:70px"><b>1天真实</b></td>
			<td style="width:70px"><b>1天差值</b></td>
			<td style="width:70px"><b>7天真实</b></td>
			<td style="width:70px"><b>7天差值</b></td>
			<td style="width:70px"><b>15天真实</b></td>
			<td style="width:70px"><b>15天差值</b></td>
            <td style="width:140px"> </td>
		</tr>
		<?foreach($sort_stations as $station_id=>$delt7){?>
            <? $station = $disp_stations[$station_id];?>
            <?
$zf_info = "";
if( $station['load_num']<40 && $station['building']==ESC_BUILDING_ZHUAN && $station['load_num_7']>=39.5){
    $zf_info = "40以下砖-超过39.5";
}

if( $station['load_num']<30 && $station['building']==ESC_BUILDING_BAN && $station['load_num_7']>=29.5){
    $zf_info = "30以下板-超过29.5";
}

if( $station['load_num']>=40 && $station['building']==ESC_BUILDING_ZHUAN && $station['load_num_7']<40){
    $zf_info = "40以上砖-小于40";
}

if( $station['load_num']>=30 && $station['building']==ESC_BUILDING_BAN && $station['load_num_7']<30){
    $zf_info = "30以上板-小于30";
}

if( $station['load_num']>=20 && $station['load_num_7']<20){
    $zf_info = "20以上-小于20";
}



            ?>
            <tr>
				<td><?=$city['name_chn']?></td>
                <td><?=$station['name_chn']?></td>
				<td><?=h_station_station_type_name_chn_slist($station['station_type'])?></td>
				<td><?=h_station_status_name_chn($station['status'])?></td>
                <td><?=h_station_building_name_chn($station['building'])?></td>
				<td><?=$station['load_num'].'A'?></td>
                <td>
                    <? if($station['load_num_1']){?>
                        <?= round($station['load_num_1'],1).'A'?> 
                    <?}?>
                </td>
                <td>
                    <? if($station['load_num_1']){?>
                        <font style="font-weight:bold;color:<?= $station['delta_1']>0?"green":"red"?>">
                            (<?= ($station['delta_1']>0?"+":"").round($station['delta_1'],1)?>)
                        </font>
                    <?}?>
                </td>
                <td style="background-color:#eee">
                    <? if($station['load_num_7']){?>
                        <?= round($station['load_num_7'],1).'A'?> 
                    <?}?>
                </td>
                <td>
                    <? if($station['load_num_7']){?>
                        <font style="font-weight:bold;color:<?= $station['delta_7']>0?"green":"red"?>">
                            (<?= ($station['delta_7']>0?"+":"").round($station['delta_7'],1)?>)
                        </font>
                    <?}?>
                </td>
                <td>
                    <? if($station['load_num_15']){?>
                        <?= round($station['load_num_15'],1).'A'?> 
                    <?}?>
                </td>
                <td>
                    <? if($station['load_num_15']){?>
                        <font style="font-weight:bold;color:<?= $station['delta_15']>0?"green":"red"?>">
                            (<?= ($station['delta_15']>0?"+":"").round($station['delta_15'],1)?>)
                        </font>
                    <?}?>
                </td>
                <td>
                    <?= $zf_info?>
                </td>
			</tr>
		<?}?>
	</table>
</div>

<script type="text/javascript">

    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/dc_error";
            document.getElementById('filter').submit();
        });
    });
</script>
