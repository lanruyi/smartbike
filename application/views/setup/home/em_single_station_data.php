<script language='JavaScript'> function myrefresh(){ window.location.reload(); } setTimeout('myrefresh()',10000);</script>

<style>
body{padding:0;margin:0}
.datalist{
    width:100%;
	border:1px solid #333;	/* 表格边框 */
	font-family:Arial;
	border-collapse:collapse;	/* 边框重叠 */
	background-color:#fff;	/* 表格背景色 */
	font-size:10px;
}
.datalist caption{
	padding-bottom:5px;
	font:bold 1.4em;
	text-align:left;
}
.datalist th{
	border:1px solid #333;	/* 行名称边框 */
	background-color:#666;	/* 行名称背景色 */
	color:#FFFFFF;				/* 行名称颜色 */
	font-weight:bold;
	padding-top:0px; padding-bottom:0px;
	padding-left:6px; padding-right:6px;
    text-align:center;
}
.datalist td{
	border:1px solid #0058a3;	/* 单元格边框 */
	text-align:left;
	padding-top:1px; padding-bottom:1px;
	padding-left:6px; padding-right:6px;
}

.datalist tr{ background: #fff;} 
.datalist tr:nth-child(2n){ background: #ddd; } 


.datalist td.name_alive{ background: #6f6 }
.datalist td.fan_on_0{  }
.datalist td.fan_on_1{ background: #0f0; }
.datalist td.colds_0_on_0{  }
.datalist td.colds_0_on_1{ background: #f93; }
.datalist td.colds_1_on_0{  }
.datalist td.colds_1_on_1{ background: #9dd; }

.datalist .leftline{ border-left: 3px solid #444; }
.datalist .rightline{ border-right: 3px solid #444; }
</style>

<? if($esg){?>
    当前ESG <?= $esg['id']?> <?= $esg['alive'] == ESC_ONLINE?"<font style='color:green'>在线</font>":"<font style='color:#f00'>不在线</font>"?>
<? }else{?>
    还没有设置ESG 无法取得数据！     
<? }?>

<table class="datalist" >
<tr>
<th> <b></b> </th>
<th colspan=8 class="leftline"> <b>温度</b> </td>
<th colspan=2 class="leftline"> <b>湿度</b> </td>
<th colspan=4 class="leftline"> <b>开关</b> </td>
<th colspan=2 class="leftline"> <b>电能</b> </td>
<th colspan=2 > <b>功率</b> </td>
</tr>
<tr>
<th class="leftline"> <b>采样时间</b> </td>
<th class="leftline"> <b>室内</b> </td>
<th> <b>室外</b> </td>
<th> <b>室外(真实)</b> </td>
<th> <b>空调1</b> </td>
<th> <b>空调2</b> </td>
<th> <b>柜温</b> </td>
<th> <b>柜温1</b> </td>
<th> <b>柜温2</b> </td>
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
<?php foreach ($datas as $data): ?>
<tr>

<td class="rightline <?= h_compare_dur($data['create_time'],"",10)?"name_alive":"" ?>"><?= $data['create_time'] ?></td>
<td > <?= $data['indoor_tmp']?>  </td>
<td> <?= $data['outdoor_tmp']?>  </td>
<td> <?= isset($data['true_out_tmp'])?$data['true_out_tmp']:""?> </td>
<td> <?= $data['colds_0_tmp']?>  </td>
<td> <?= $data['colds_1_tmp']?>  </td>
<td> <?= $data['box_tmp']?>  </td>
<td> <?= isset($data['box_tmp_1'])?$data['box_tmp_1']:""?> </td>
<td> <?= isset($data['box_tmp_2'])?$data['box_tmp_2']:""?> </td>
<td class="leftline"> <?= $data['indoor_hum']?>  </td>
<td class="rightline"> <?= $data['outdoor_hum']?>  </td>
<td class="fan_on_<?= $data['fan_0_on']?>">       <?= $data['fan_0_on']?>   </td>
<td class="colds_0_on_<?= $data['colds_0_on']?>"> <?= $data['colds_0_on']?> </td>
<td class="colds_1_on_<?= $data['colds_1_on']?>"> <?= $data['colds_1_on']?> </td>
<td > <?= $data['colds_box_on']?>  </td>
<td class="leftline"> <?= $data['energy_main']?>  </td>
<td> <?= $data['energy_dc']?>  </td>
<td class="leftline"> <?= $data['power_main']?>  </td>
<td style="<?= h_judge_power_dc_by_load_num($data['power_dc'], $station['load_num'])?>"> <?= $data['power_dc']?>  </td>
</tr>
<?php endforeach?>

<?php for($i = 0; $i < 8-count($datas); $i++){ ?>
<tr>
    <?php for($j = 0; $j < 19; $j++){ ?> <td style="height:16px;"></td> <?php }?>
</tr>
<?php }?>

</table>

<?php if($station && $load_num = $station['load_num']){ ?>
<div style="float:right;font-size:12;margin-top:5px;">备注: 功率正常范围 <?= intval($load_num*53)."--".intval($load_num*53/0.8)?></div>
<? }?>
