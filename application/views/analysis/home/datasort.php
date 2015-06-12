<div class = "base_center">
    
<style>
.detail_f{margin:0;padding:0}
.detail_f ul{float:left;margin:2px 0;padding:0;}
.detail_f ul.body{width:965px;}
.detail_f ul.line{width:1000px;border-bottom:1px dashed #ccc;height:2px;}
.detail_f ul li{float:left;margin:2px;padding:1px 6px;}
.detail_f ul li a{color:#000;}
.detail_f ul li.head{width:65px;text-align:left;font-weight:bold}
.detail_f ul li.active{background-color:#69c;color:#fff}
.detail_f ul li.active a{background-color:#69c;color:#fff}
.reslist{ border:1px solid #999; background-color:#fff; font-size:12px; width:100%; }
.reslist th{ border:1px solid #666;color:#fff;background-color:#999; font-weight:bold; padding:2px; text-align:center; }
.reslist td{ border:1px solid #666;padding:2px; text-align:center; }

.reslist tr{ background: #fff;} 
.reslist tr:nth-child(2n){ background: #ddd; } 


.reslist td.name_alive{ background: #6f6 }
.reslist td.fan_on_0{  }
.reslist td.fan_on_1{ background: #0f0; }
.reslist td.colds_0_on_0{  }
.reslist td.colds_0_on_1{ background: #f93; }
.reslist td.colds_1_on_0{  }
.reslist td.colds_1_on_1{ background: #9dd; }

.reslist .leftline{ border-left: 2px solid #444; }
.reslist .rightline{ border-right: 2px solid #444; }
</style>

<div style="margin:0;width:100%">
    <font> 基站最新数据 </font>
</div>

<form id="filter" method="get" action="">
<div class='filter'>
    项目:<?= h_flist_project_select($projects,$project_id); ?>
    城市:<?= h_flist_city_select($cities,$city_id); ?>
</div>
<div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
</div>
</form>

<div class='detail_f'>
    <ul class=body>
        <li class="head">排序方式:</li>
        <li class=<?= ($option=="indoor_tmp")? "active":"" ?>> 
            <a href=<?= '/analysis/home/datasort?project_id='.$project_id .'&city_id='.$city_id .'&option=indoor_tmp'?>>室内温度</a> 
        </li>
        <li class=<?= ($option=="outdoor_tmp")? "active":"" ?>>
            <a href=<?= '/analysis/home/datasort?project_id='.$project_id .'&city_id='.$city_id .'&option=outdoor_tmp'?>>室外温度</a> 
        </li> 
        <li class=<?= ($option=="colds_0_tmp")? "active":"" ?>>
            <a href=<?= '/analysis/home/datasort?project_id='.$project_id .'&city_id='.$city_id .'&option=colds_0_tmp'?>>空调1温度</a> 
        </li> 
        <li class=<?= ($option=="colds_1_tmp")? "active":"" ?>>
            <a href=<?= '/analysis/home/datasort?project_id='.$project_id .'&city_id='.$city_id .'&option=colds_1_tmp'?>>空调2温度</a> 
        </li>         
    </ul>
    <ul class=line> </ul>
</div>
<div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'></div>
</div>

<div class = "base_center" id="batch_oper_form"> 
<table class="reslist" >
<tr>
<th> <b></b> </td>
<th> <b></b> </td>
<th colspan=5> <b>温度</b> </td>
<th colspan=2 class="leftline"> <b>湿度</b> </td>
<th colspan=4 class="leftline"> <b>开关</b> </td>
<th colspan=2 class="leftline"> <b>电能</b> </td>
<th colspan=2 class="leftline rightline"> <b>功率</b> </td>
</tr>
<tr>
<th> <b>采样时间</b> </td>
<th> <b>基站</b> </td>
<th> <b>室内</b> </td>
<th> <b>室外</b> </td>
<th> <b>空调1</b> </td>
<th> <b>空调2</b> </td>
<th> <b>恒温</b> </td>
<th class="leftline"> <b>内</b> </td>
<th > <b>外</b> </td>
<th class="leftline"> <b>风</b> </td>
<th> <b>空1</b> </td>
<th> <b>空2</b> </td>
<th> <b>恒</b> </td>
<th class="leftline"> <b>总</b> </td>
<th> <b>dc</b> </td>
<th class="leftline"> <b>总</b> </td>
<th> <b>dc</b> </td>

</tr>

<? foreach($result_datas as $res){?>
<tr>
<td class="<?= h_compare_dur($res['create_time'],"",10)?"name_alive":"" ?>"  style="width:130px"> 
    <?= $res['create_time']?> 
</td>
<td> <?= $res['station_name_chn']?>  </td>
<td> <?= $res['indoor_tmp']?>  </td>
<td> <?= $res['outdoor_tmp']?>  </td>
<td> <?= $res['colds_0_tmp']?>  </td>
<td> <?= $res['colds_1_tmp']?>  </td>
<td> <?= $res['box_tmp']?>  </td>
<td class="leftline"> <?= $res['indoor_hum']?>  </td>
<td class="rightline"> <?= $res['outdoor_hum']?>  </td>
<td> <?= $res['fan_0_on']?>   </td>
<td> <?= $res['colds_0_on']?> </td>
<td> <?= $res['colds_1_on']?> </td>
<td> <?= $res['colds_box_on']?>  </td>
<td class="leftline"> <?= $res['energy_main']?>  </td>
<td> <?= $res['energy_dc']?>  </td>
<td class="leftline"> <?= $res['power_main']?>  </td>
<td> <?= $res['power_dc']?>  </td>
</tr>
<?}?>

</table>
</div>

<script>
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/datasort";
            document.getElementById('filter').submit();
        });
    });
</script>

