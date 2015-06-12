<div class = "base_center">

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
        <!--<p style="float:right">
            <a href="javascript:void(0)" id="download_xls" class="btn btn-primary">导出xls</a> 
        </p>-->
</div>
</form>

</div>

<style>
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
        $("#download_xls").click(function(){
            document.getElementById('filter').action = "/analysis/home/xls";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/index";
            document.getElementById('filter').submit();
        });
    });
</script>

